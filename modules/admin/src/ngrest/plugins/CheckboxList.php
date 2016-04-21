<?php

namespace admin\ngrest\plugins;

use admin\ngrest\base\Plugin;
use yii\helpers\Json;

/**
 * Create a checkbox list with selection based on an array with key value pairing.
 * 
 * Example usage:
 * 
 * ```
 * public function ngrestAttributeTypes()
 * {
 * 		'genres' => ['checkboxList', 'data' => [1 => 'Male', 2 => 'Female']],
 * }
 * 
 * @todo testing and complete find and save events.
 * @author nadar
 */
class CheckboxList extends Plugin
{
    public $data = [];
    
    public function renderList($id, $ngModel)
    {
        return $this->createListTag('span', 'no supported yet in list view');
    }
    
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-checkbox-array', $id, $ngModel, ['options' => $this->getServiceName('checkboxitems')]);
    }
    
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    protected function getItems()
    {
        $data = [];
    
        foreach ($this->data as $value => $label) {
            $data[] = ['value' => $value, 'label' => $label];
        }
    
        return ['items' => $data];
    }
    
    public function serviceData()
    {
        return ['checkboxitems' => $this->getItems()];
    }
    
    public function onBeforeSave($event)
    {
        // if its not i18n casted field we have to serialize the the file array as json and abort further event excution.
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
            return false;
        }
    
        return true;
    }
    
    public function onBeforeExpandFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
            return false;
        }
    
        return true;
    }
    
    public function onBeforeFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
            return false;
        }
    }
}
