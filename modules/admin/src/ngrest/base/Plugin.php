<?php

namespace luya\admin\ngrest\base;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use yii\helpers\Html;
use luya\Exception;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\helpers\I18n;
use luya\helpers\ArrayHelper;

/**
 * Base class for all NgRest Plugins
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Plugin extends Component
{
    /**
     * @var string The name of the field corresponding to the ActiveRecord (also known as fieldname)
     */
    public $name = null;
    
    /**
     * @var string The alias name of the plugin choosen by the user (also known as label)
     */
    public $alias = null;
    
    /**
     * @var boolean Whether the plugin is in i18n context or not.
     */
    public $i18n = null;

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
     * {@inheritDoc}
     * @see \yii\base\Object::init()
     */
    public function init()
    {
        // call parent initializer
        parent::init();
        
        if ($this->name === null || $this->alias === null || $this->i18n === null) {
            throw new Exception("Plugin attributes id, name, alias, ngModel and i18n must be configured.");
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
     * @return boolean|array
     */
    public function serviceData()
    {
        return false;
    }
    
    /**
     * Json decode value but verifys if its empty, cause this can thrown an json decode exception.
     *
     * @param string $value The string to encode
     * @return mixed
     */
    public function jsonDecode($value)
    {
        return (empty($value)) ? [] : Json::decode($value);
    }
    
    // I18N HELPERS

    /**
     * Encode from PHP to Json
     *
     * @param string|array $field
     * @return string Returns a string
     */
    public function i18nFieldEncode($value)
    {
        return I18n::encode($value);
    }
    
    /**
     * Decode from Json to PHP
     *
     * @param string|array $field The value to decode (or if alreay is an array already)
     * @param string $onEmptyValue Defines the value if the language could not be found and a value will be returns, this value will be used.
     * @return array returns an array with decoded field value
     */
    public function i18nFieldDecode($value, $onEmptyValue = '')
    {
        return I18n::decode($value, $onEmptyValue);
    }
    
    /**
     *
     * @param array $fieldValues
     * @return string|unknown
     */
    public function i18nDecodedGetActive(array $fieldValues)
    {
        return I18n::findCurrent($fieldValues);
    }
    
    // HTML TAG HELPERS

    /**
     * Wrapper for Yii Html::tag method
     *
     * @param string $name
     * @param string $content
     * @param array $options
     * @return string
     */
    public function createTag($name, $content, array $options = [])
    {
        return Html::tag($name, $content, $options);
    }
    
    /**
     * Helper method to create a form tag based on current object.
     *
     * @param string $name
     * @param string $id
     * @param string $ngModel
     * @param array $options
     * @return string
     */
    public function createFormTag($name, $id, $ngModel, array $options = [])
    {
        return $this->createTag($name, null, array_merge($options, ['fieldid' => $id, 'model' => $ngModel, 'label' => $this->alias, 'fieldname' => $this->name, 'i18n' => ($this->i18n) ? 1 : '']));
    }
    
    /**
     * Helper method to create a span tag with the ng-model in angular context for the crud overview
     * @param string $ngModel
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
    public function createCrudLoaderTag($ngrestModelClass)
    {
        $menu = Yii::$app->adminmenu->getApiDetail($ngrestModelClass::ngRestApiEndpoint());
        
        if ($menu) {
            return $this->createTag('crud-loader', null, ['api' => str_replace('-', '/', $menu['route'])]);
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
     * This event will be triggered `onSave` event. If the property of this plugin inside the model, the event will not be triggered.
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
     * @param unknown $event
     * @return boolean
     */
    public function onBeforeListFind($event)
    {
        return true;
    }
    
    /**
     * This event is only trigger when returning the ngrest crud list data. If the property of this plugin inside the model, the event will not be triggered.
     *
     * @param \admin\ngrest\base\Model::EVENT_AFTER_NGREST_FIND $event
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
     * @param unknown $event
     * @return boolean
     */
    public function onAfterListFind($event)
    {
        return true;
    }
    
    // ON FIND

    /**
     * This event will be trigger before `onFind`.
     * @param unknown $event
     * @return boolean
     */
    public function onBeforeFind($event)
    {
        return true;
    }
    
    /**
     * ActiveRecord afterFind event. If the property of this plugin inside the model, the event will not be triggered.
     * @param unknown $event
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
     * @param unknown $event
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
     * @param unknown $event
     * @return boolean
     */
    public function onBeforeExpandFind($event)
    {
        return true;
    }
    
    /**
     * NgRest Model crud list/overview event after find. If the property of this plugin inside the model, the event will not be triggered.
     * @param unknown $event
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
     * @param unknown $event
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
     * @param unknown $event
     * @return boolean
     */
    public function onBeforeCollectServiceData($event)
    {
        return true;
    }
    
    /**
     *
     * @param unknown $event
     */
    public function onCollectServiceData($event)
    {
        if ($this->onBeforeCollectServiceData($event)) {
            $data = $this->serviceData();
            if (!empty($data)) {
                $event->sender->addNgRestServiceData($this->name, $data);
            }
        }
    }

    /**
     * Check wehther the current plugin attribute is writeable in the Model class or not. If not writeable some events will be stopped from
     * further processing. This is mainly used when adding extraFields to the grid list view.
     *
     * @param object $event The current event object
     */
    protected function isAttributeWriteable($event)
    {
        return ($event->sender->hasAttribute($this->name) || $event->sender->canSetProperty($this->name));
    }
}
