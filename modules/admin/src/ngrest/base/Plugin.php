<?php

namespace admin\ngrest\base;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use yii\helpers\Html;
use luya\Exception;
use admin\ngrest\base\Model;

abstract class Plugin extends Component
{
    public $name = null;
    
    public $alias = null;
    
    public $i18n = null; // true/false - active yet?

    abstract public function renderList($id, $ngModel); // @TODO replace $doc with $ngModel as ngModel should not be a global object in this context, also add $id
    
    abstract public function renderCreate($id, $ngModel); // @TODO replace $doc with $ngModel as ngModel should not be a global object in this context, also add $id
    
    abstract public function renderUpdate($id, $ngModel); // @TODO replace $doc with $ngModel as ngModel should not be a global object in this context, also add $id
    
    public function init()
    {
        parent::init();
        
        if ($this->name === null || $this->alias === null || $this->i18n === null) {
            throw new Exception("Plugin attributes id, name, alias, ngModel and i18n must be configured.");
        }
        
        $this->addEvent(Model::EVENT_BEFORE_INSERT, 'onSave');
        $this->addEvent(Model::EVENT_BEFORE_UPDATE, 'onSave');
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
     * an override without calling the parent::events will stop all other events used by default
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
                $event->sender->setAttribute($this->name, $this->i18nDecodedGetActive($this->i18nFieldDecode($event->sender->getAttribute($this->name))));
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
                $event->sender->setAttribute($this->name, $this->i18nDecodedGetActive($this->i18nFieldDecode($event->sender->getAttribute($this->name))));
            }
            
            $this->onAfterFind($event);
        }
    }
    
    public function onBeforeExpandFind($event)
    {
        return true;
    }
    
    public function onExpandFind($event)
    {
        if ($this->onBeforeExpandFind($event)) {
            if ($this->i18n) {
                $event->sender->setAttribute($this->name, $this->i18nFieldDecode($event->sender->getAttribute($this->name)));
            }   
        }
    }
    
    public function onCollectServiceData($event)
    {
        $event->sender->addNgRestServiceData($this->name, $this->serviceData());
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
     * @return array returns an array with decoded field value
     */
    public function i18nFieldDecode($value)
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
                $value[$lang['short_code']] = '';
            }
        }
    
        return $value;
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
    
    // REMOVE BELOW HERE
    
    /*
    protected function createBaseElement($doc, $type)
    {
        $elmn = $doc->createElement($type);
        $elmn->setAttribute('fieldid', $this->id);
        $elmn->setAttribute('fieldname', $this->name);
        $elmn->setAttribute('model', $this->ngModel);
        $elmn->setAttribute('label', $this->alias);
        $elmn->setAttribute('i18n', $this->i18n);
    
        return $elmn;
    }
    
    
    protected $id = null;

    protected $name = null;

    protected $alias = null;

    protected $ngModel = null;

    protected $i18n = null;

    private $_model = null;
    
    public function setModel($model)
    {
        $this->_model = $model;
    }

    public function getModel()
    {
        return $this->_model;
    }
    

    protected function createBaseElement($doc, $type)
    {
        $elmn = $doc->createElement($type);
        $elmn->setAttribute('fieldid', $this->id);
        $elmn->setAttribute('fieldname', $this->name);
        $elmn->setAttribute('model', $this->ngModel);
        $elmn->setAttribute('label', $this->alias);
        $elmn->setAttribute('i18n', $this->i18n);

        return $elmn;
    }

    public function setConfig($id, $name, $ngModel, $alias, $i18n)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ngModel = $ngModel;
        $this->alias = $alias;
        $this->i18n = $i18n;
    }

    public function getServiceName($name)
    {
        return 'service.'.$this->name.'.'.$name;
    }

    public function serviceData()
    {
        return false;
    }

    public function onBeforeCreate($fieldValue)
    {
        return false;
    }

    public function onAfterCreate($fieldValue)
    {
        return false;
    }

    public function onBeforeUpdate($fieldValue, $oldValue)
    {
        return false;
    }

    public function onAfterFind($fieldValue)
    {
        return false;
    }

    public function onAfterNgRestFind($fieldValue)
    {
        return false;
    }

    abstract public function renderList($doc);

    abstract public function renderCreate($doc);

    abstract public function renderUpdate($doc);

    public function events()
    {
        return [];
    }
    */
}
