<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Base class for Sort Relation Plugins.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class SortRelation extends Plugin
{
    abstract public function getData();
    
    public $i18nEmptyValue = [];
    
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }
    
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-sort-relation-array', $id, $ngModel, ['options' => $this->getServiceName('sortrelationdata')]);
    }
    
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    public function serviceData($event)
    {
        return [
            'sortrelationdata' => $this->getData(),
        ];
    }
    
    public function onBeforeSave($event)
    {
        // if its not i18n casted field we have to serialize the the image array as json and abort further event excution.
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
            return false;
        }
    
        return true;
    }
    
    public function onBeforeFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
        }
        
        return true;
    }
    
    public function onBeforeExpandFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
        }
        
        return true;
    }
}
