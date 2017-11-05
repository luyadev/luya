<?php

namespace luya\admin\ngrest\base;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use yii\helpers\Html;
use luya\Exception;

use luya\admin\helpers\I18n;
use luya\helpers\ArrayHelper;

/**
 * Base class for NgRest Plugins.
 *
 * Event trigger cycle for different use cases, the following use cases are available with its
 * event cycles.
 *
 * Async:
 * + onCollectServiceData: A collection bag where you can provide data and access them trough angular, its not available inside the same model as this process runs async
 *
 * Async:
 * + onFind: The model is used in your controller frontend logic to display and assign data into the view (developer use case)
 * + onListFind: The model is populated for the Admin Table list view where you can see all your items and click the edit/delete icons.
 * + onExpandFind: Equals to onFind but only for the view api of the model, which means the data which is used for edit.
 * + onSave: Before Update / Create of the new data set.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Plugin extends Component
{
    /**
     * @var string The name of the field corresponding to the ActiveRecord (also known as fieldname)
     */
    public $name;
    
    /**
     * @var string The alias name of the plugin choosen by the user (also known as label)
     */
    public $alias;
    
    /**
     * @var boolean Whether the plugin is in i18n context or not.
     */
    public $i18n;

    /**
     * @var mixed This value will be used when the i18n decodes the given value but is not set yet, default value.
     */
    public $i18nEmptyValue = '';
    
    /**
     * Renders the element for the CRUD LIST overview for a specific type.
     *
     * @param string $id The ID of the element in the current context
     * @param string $ngModel The name to access the data in angular context.
     * @return string|array Returns the html element as a string or an array which will be concated
     */
    abstract public function renderList($id, $ngModel);
    
    /**
     * Renders the element for the CRUD CREATE FORM for a specific type.
     *
     * @param string $id The ID of the element in the current context
     * @param string $ngModel The name to access the data in angular context.
     * @return string|array Returns the html element as a string or an array which will be concated
     */
    abstract public function renderCreate($id, $ngModel);
    
    /**
     * Renders the element for the CRUD UPDATE FORM for a specific type.
     *
     * @param string $id The ID of the element in the current context
     * @param string $ngModel The name to access the data in angular context.
     * @return string|array Returns the html element as a string or an array which will be concated
     */
    abstract public function renderUpdate($id, $ngModel);
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        // call parent initializer
        parent::init();
        
        if ($this->name === null || $this->alias === null || $this->i18n === null) {
            throw new Exception("Plugin attributes name, alias and i18n must be configured.");
        }
        
        $this->addEvent(NgRestModel::EVENT_BEFORE_VALIDATE, 'onSave');
        $this->addEvent(NgRestModel::EVENT_AFTER_FIND, 'onFind');
        $this->addEvent(NgRestModel::EVENT_AFTER_NGREST_FIND, 'onListFind');
        $this->addEvent(NgRestModel::EVENT_AFTER_NGREST_UPDATE_FIND, 'onExpandFind');
        $this->addEvent(NgRestModel::EVENT_SERVICE_NGREST, 'onCollectServiceData');
    }

    /**
     * Return the defined constant for a angular service instance in the current object.
     *
     * @param string $name The name of the service defined as array key in `serviceData()`.
     * @return string
     */
    public function getServiceName($name)
    {
        return 'service.'.$this->name.'.'.$name;
    }
    
    /**
     * Define the service data which will be called when creating the ngrest crud view. You may override
     * this method in your plugin.
     *
     * Example Response
     *
     * ```php
     * return [
     *     'titles' => ['mr, 'mrs'];
     * ];
     * ```
     *
     * The above service data can be used when creating the tags with `$this->getServiceName('titles')`.
     *
     * @param \yii\base\Event $event The event sender which triggers the event.
     * @return boolean|array
     */
    public function serviceData($event)
    {
        return false;
    }
    
    /**
     * Decodes the given JSON string into a PHP data structure and verifys if its empty, cause this can thrown an json decode exception.
     *
     * @param string $value The string to decode from json to php.
     * @return array The PHP array.
     */
    public function jsonDecode($value)
    {
        return (empty($value)) ? [] : Json::decode($value);
    }
    
    // I18N HELPERS

    /**
     * Encode from PHP to Json.
     *
     * See {{luya\admin\helpers\I18n::encode}}
     *
     * @param string|array $value
     * @return string Returns a string
     */
    public function i18nFieldEncode($value)
    {
        return I18n::encode($value);
    }
    
    /**
     * Decode from Json to PHP.
     *
     * See {{luya\admin\helpers\I18n::decode}}
     *
     * @param string|array $value The value to decode (or if alreay is an array already)
     * @param string $onEmptyValue Defines the value if the language could not be found and a value will be returns, this value will be used.
     * @return array returns an array with decoded field value
     */
    public function i18nFieldDecode($value, $onEmptyValue = '')
    {
        return I18n::decode($value, $onEmptyValue);
    }
    
    /**
     * Encode the current value from a language array.
     *
     * See {{luya\admin\helpers\I18n::findActive}}
     *
     * @param array $fieldValues
     * @return string|unknown
     */
    public function i18nDecodedGetActive(array $fieldValues)
    {
        return I18n::findActive($fieldValues);
    }
    
    // HTML TAG HELPERS

    /**
     * Wrapper for Yii Html::tag method
     *
     * @param string $name The name of the tag
     * @param string $content The value inside the tag.
     * @param array $options Options to passed to the tag generator.
     * @return string The generated html string tag.
     */
    public function createTag($name, $content, array $options = [])
    {
        return Html::tag($name, $content, $options);
    }
    
    /**
     * Helper method to create a form tag based on current object.
     *
     * @param string $name Name of the form tag.
     * @param string $id The id tag of the tag.
     * @param string $ngModel The ngrest model name of the tag.
     * @param array $options Options to passes to the tag creator.
     * @return string The generated tag content.
     */
    public function createFormTag($name, $id, $ngModel, array $options = [])
    {
        return $this->createTag($name, null, array_merge($options, ['fieldid' => $id, 'model' => $ngModel, 'label' => $this->alias, 'fieldname' => $this->name, 'i18n' => ($this->i18n) ? 1 : '']));
    }
    
    /**
     * Helper method to create a span tag with the ng-model in angular context for the crud overview
     * @param string $ngModel
     * @param array $options An array with options to pass to the list tag
     * @return string
     */
    public function createListTag($ngModel, array $options = [])
    {
        return $this->createTag('span', null, ArrayHelper::merge(['ng-bind' => $ngModel], $options));
    }
    
    /**
     * Create a tag for relation window toggler with directive crudLoader based on a ngrest model class.
     *
     * @param string $ngrestModelClass
     * @return string The generated tag or null if permission does not exists
     */
    public function createCrudLoaderTag($ngrestModelClass, $ngRestModelSelectMode = null, array $options = [])
    {
        $menu = Yii::$app->adminmenu->getApiDetail($ngrestModelClass::ngRestApiEndpoint());
        
        if ($menu) {
            if ($ngRestModelSelectMode) {
                $options['model-setter'] = $ngRestModelSelectMode;
                $options['model-selection'] = 1;
            }
            
            return $this->createTag('crud-loader', null, array_merge(['api' => $menu['route'], 'alias' => $menu['alias']], $options));
        }
        
        return null;
    }
    
    // EVENTS

    private $_events = [];
    
    /**
     * Add an event to the list of events
     *
     * @param string $trigger ActiveRecord event name
     * @param string $handler Method-Name inside this object
     */
    public function addEvent($trigger, $handler)
    {
        $this->_events[$trigger] = $handler;
    }
    
    /**
     * Remove an event from the events stack by its trigger name.
     *
     * In order to remove an event trigger from stack you have to do this right
     * after the initializer.
     *
     * ```php
     * public function init()
     * {
     *     parent::init();
     *     $this->removeEvent(NgRestModel::EVENT_AFTER_FIND);
     * }
     * ```
     *
     * @param string $trigger The event trigger name from the EVENT constants.
     */
    public function removeEvent($trigger)
    {
        if (isset($this->_events[$trigger])) {
            unset($this->_events[$trigger]);
        }
    }
    
    /**
     * An override without calling the parent::events will stop all other events used by default.
     *
     * @return array
     */
    public function events()
    {
        return $this->_events;
    }
    
    // ON SAVE

    /**
     * This event will be triggered before `onSave` event.
     *
     * @param \yii\db\AfterSaveEvent $event AfterSaveEvent represents the information available in yii\db\ActiveRecord::EVENT_AFTER_INSERT and yii\db\ActiveRecord::EVENT_AFTER_UPDATE.
     * @return boolean
     */
    public function onBeforeSave($event)
    {
        return true;
    }
    
    /**
    * This event will be triggered `onSave` event. If the model property is not writeable the event will not trigger.
    *
    * If the beforeSave method returns true and i18n is enabled, the value will be json encoded.
    *
    * @param \yii\db\AfterSaveEvent $event AfterSaveEvent represents the information available in yii\db\ActiveRecord::EVENT_AFTER_INSERT and yii\db\ActiveRecord::EVENT_AFTER_UPDATE.
    * @return void
    */
    public function onSave($event)
    {
        if ($this->isAttributeWriteable($event) && $this->onBeforeSave($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
            }
        }
    }
    
    // ON LIST FIND

    /**
     * This event will be triger before `onListFind`.
     *
     * @param \luya\admin\ngrest\base\NgRestModel::EVENT_AFTER_NGREST_FIND $event The NgRestModel after ngrest find event.
     * @return boolean
     */
    public function onBeforeListFind($event)
    {
        return true;
    }
    
    /**
     * This event is only trigger when returning the ngrest crud list data. If the property of this plugin inside the model, the event will not be triggered.
     *
     * @param \luya\admin\ngrest\base\NgRestModel::EVENT_AFTER_NGREST_FIND $event The NgRestModel after ngrest find event.
     */
    public function onListFind($event)
    {
        if ($this->isAttributeWriteable($event) && $this->onBeforeListFind($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nDecodedGetActive($this->i18nFieldDecode($event->sender->getAttribute($this->name), $this->i18nEmptyValue)));
            }
            $this->onAfterListFind($event);
        }
    }
    
    /**
     * This event will be triggered after `onListFind`.
     *
     * @param \luya\admin\ngrest\base\NgRestModel::EVENT_AFTER_NGREST_FIND $event The NgRestModel after ngrest find event.
     * @return boolean
     */
    public function onAfterListFind($event)
    {
        return true;
    }
    
    // ON FIND

    /**
     * This event will be trigger before `onFind`.
     *
     * @param \yii\base\Event $event An event that is triggered after the record is created and populated with query result.
     * @return boolean
     */
    public function onBeforeFind($event)
    {
        return true;
    }
    
    /**
     * ActiveRecord afterFind event. If the property of this plugin inside the model, the event will not be triggered.
     *
     * @param \yii\base\Event $event An event that is triggered after the record is created and populated with query result.
     */
    public function onFind($event)
    {
        if ($this->isAttributeWriteable($event) && $this->onBeforeFind($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nDecodedGetActive($this->i18nFieldDecode($event->sender->getAttribute($this->name), $this->i18nEmptyValue)));
            }
            
            $this->onAfterFind($event);
        }
    }
    
    /**
     * This event will be trigger after `onFind`.
     *
     * @param \yii\base\Event $event An event that is triggered after the record is created and populated with query result.
     * @return boolean
     */
    public function onAfterFind($event)
    {
        return true;
    }
    
    // ON EXPAND FIND

    /**
     * This event will be triggered before `onExpandFind`.
     *
     * @param \luya\admin\ngrest\base\NgRestModel::EVENT_AFTER_NGREST_UPDATE_FIND $event NgRestModel event EVENT_AFTER_NGREST_UPDATE_FIND.
     * @return boolean
     */
    public function onBeforeExpandFind($event)
    {
        return true;
    }
    
    /**
     * NgRest Model crud list/overview event after find. If the property of this plugin inside the model, the event will not be triggered.
     * @param \luya\admin\ngrest\base\NgRestModel::EVENT_AFTER_NGREST_UPDATE_FIND $event NgRestModel event EVENT_AFTER_NGREST_UPDATE_FIND.
     */
    public function onExpandFind($event)
    {
        if ($this->isAttributeWriteable($event) && $this->onBeforeExpandFind($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nFieldDecode($event->sender->getAttribute($this->name), $this->i18nEmptyValue));
            }
            
            $this->onAfterExpandFind($event);
        }
    }
    
    /**
     * This event will be triggered after `onExpandFind`.
     *
     * @param \luya\admin\ngrest\base\NgRestModel::EVENT_AFTER_NGREST_UPDATE_FIND $event NgRestModel event EVENT_AFTER_NGREST_UPDATE_FIND.
     * @return boolean
     */
    public function onAfterExpandFind($event)
    {
        return true;
    }
    
    // ON COLLECT SERVICE DATA

    /**
     * This event will be triggered before `onCollectServiceData`.
     *
     * @param \luya\admin\ngrest\base\NgRestModel::EVENT_SERVICE_NGREST $event NgRestModel event EVENT_SERVICE_NGREST.
     * @return boolean
     */
    public function onBeforeCollectServiceData($event)
    {
        return true;
    }
    
    /**
     * The ngrest services collector.
     *
     * > The service event is async to the other events, which means the service event collects data before the the other events are called.
     *
     * @param \luya\admin\ngrest\base\NgRestModel::EVENT_SERVICE_NGREST $event NgRestModel event EVENT_SERVICE_NGREST.
     */
    public function onCollectServiceData($event)
    {
        if ($this->onBeforeCollectServiceData($event)) {
            $data = $this->serviceData($event);
            if (!empty($data)) {
                $event->sender->addNgRestServiceData($this->name, $data);
            }
        }
    }

    /**
     * Check whether the current plugin attribute is writeable in the Model class or not. If not writeable some events will be stopped from
     * further processing. This is mainly used when adding extraFields to the grid list view.
     *
     * @param \yii\base\Event $event The current base event object.
     * @return boolean Whether the current plugin attribute is writeable or not.
     */
    protected function isAttributeWriteable($event)
    {
        return ($event->sender->hasAttribute($this->name) || $event->sender->canSetProperty($this->name));
    }
}
