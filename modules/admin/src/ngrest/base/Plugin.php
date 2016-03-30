<?php

namespace admin\ngrest\base;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use yii\helpers\Html;
use luya\Exception;
use admin\ngrest\base\Model;

/**
 * Base class for all plugins
 * 
 * @author nadar
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
    
    public function init()
    {
        parent::init();
        
        if ($this->name === null || $this->alias === null || $this->i18n === null) {
            throw new Exception("Plugin attributes id, name, alias, ngModel and i18n must be configured.");
        }
        
        $this->addEvent(Model::EVENT_BEFORE_VALIDATE, 'onSave');
        //$this->addEvent(Model::EVENT_BEFORE_VALIDATE, 'onSave'); // before we have used BEFORE_INSERT & BEFORE_UPDATE events instead on before validate
        $this->addEvent(Model::EVENT_AFTER_FIND, 'onFind');
        $this->addEvent(Model::EVENT_AFTER_NGREST_FIND, 'onListFind');
        $this->addEvent(Model::EVENT_AFTER_NGREST_UPDATE_FIND, 'onExpandFind');
        $this->addEvent(Model::EVENT_SERVICE_NGREST, 'onCollectServiceData');
    }
    
    public function addEvent($trigger, $handler)
    {
        $this->_events[$trigger] = $handler;   
    }

    private $_events = [];
    
    /**
     * An override without calling the parent::events will stop all other events used by default.
     */
    public function events()
    {
        return $this->_events;
    }
    
    public function onBeforeSave($event)
    {
        return true;
    }
    
    public function onSave($event)
    {
        if ($this->onBeforeSave($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
            }    
        }
    }
    
    public function onBeforeListFind($event)
    {
        return true;
    }
    
    public function onAfterListFind($event)
    {
        return true;
    }
    
    public function onListFind($event)
    {
        if ($this->onBeforeListFind($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nDecodedGetActive($this->i18nFieldDecode($event->sender->getAttribute($this->name), $this->i18nEmptyValue)));
            }
            $this->onAfterListFind($event);
        }
    }
    
    public function onBeforeFind($event)
    {
        return true;
    }
    
    public function onAfterFind($event)
    {
        return true;
    }
    
    public function onFind($event)
    {
        if ($this->onBeforeFind($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nDecodedGetActive($this->i18nFieldDecode($event->sender->getAttribute($this->name), $this->i18nEmptyValue)));
            }
            
            $this->onAfterFind($event);
        }
    }
    
    public function onBeforeExpandFind($event)
    {
        return true;
    }
    
    public function onAfterExpandFind($event)
    {
        return true;
    }
    
    public function onExpandFind($event)
    {
        if ($this->onBeforeExpandFind($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nFieldDecode($event->sender->getAttribute($this->name), $this->i18nEmptyValue));
            }
            
            $this->onAfterExpandFind($event);
        }
    }
    
    public function onBeforeCollectServiceData($event)
    {
    	return true;
    }
    
    public function onCollectServiceData($event)
    {
    	if ($this->onBeforeCollectServiceData($event)) {
    		$data = $this->serviceData();
    		if (!empty($data)) {
    			$event->sender->addNgRestServiceData($this->name, $data);
    		}
    	}
    }
    
    public function getServiceName($name)
    {
        return 'service.'.$this->name.'.'.$name;
    }
    
    public function serviceData()
    {
        return false;
    }
    
    /**
     * Encode from PHP to Json
     * 
     * @param string|array $field
     * @return string Returns a string
     */
    public function i18nFieldEncode($value)
    {
        if (is_array($value)) {
            return Json::encode($value);
        }
    
        return $value;
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
        $langShortCode = Yii::$app->adminLanguage->getActiveShortCode();
        $languages = Yii::$app->adminLanguage->getLanguages();
    
    
        // if its not already unserialized, decode it
        if (!is_array($value) && !empty($value)) {
            $value = Json::decode($value);
        }
    
        // fall back for not transformed values
        if (!is_array($value)) {
            $value = (array) $value;
        }
    
        // add all not existing languages to the array (for example a language has been added after the database item has been created)
        foreach ($languages as $lang) {
            if (!array_key_exists($lang['short_code'], $value)) {
                $value[$lang['short_code']] = $onEmptyValue;
            }
        }
    
        return $value;
    }
    
    /**
     * Json decode value but verifys if its empty, cause this can thrown an json decode exception.
     * @param string $value The string to encode
     * @return mixed
     */
    public function jsonDecode($value)
    {
        return (empty($value)) ? [] : Json::decode($value);
    }
    
    public function i18nDecodedGetActive(array $fieldValues)
    {
        $langShortCode = Yii::$app->adminLanguage->getActiveShortCode();
    
        return (array_key_exists($langShortCode, $fieldValues)) ? $fieldValues[$langShortCode] : '';
    }
    
    /**
     * wrapper for html tag
     * 
     * @param unknown $name
     * @param unknown $content
     * @param array $options
     * @return string
     */
    public function createTag($name, $content, array $options = [])
    {
        return Html::tag($name, $content, $options);
    }
    
    public function createFormTag($name, $id, $ngModel, array $options = [])
    {
        $opts = array_merge($options, ['fieldid' => $id, 'model' => $ngModel, 'label' => $this->alias, 'fieldname' => $this->name, 'i18n' => ($this->i18n) ? 1 : '']);
        return $this->createTag($name, null, $opts);
    }
    
    public function createListTag($ngModel)
    {
        return $this->createTag('span', null, ['ng-bind' => $ngModel]);
    }
}
