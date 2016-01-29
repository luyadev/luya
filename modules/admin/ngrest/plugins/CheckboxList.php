<?php

namespace admin\ngrest\plugins;

use admin\ngrest\base\Plugin;
use yii\helpers\Json;

/**
 * Createa checkbox list with selection based on an array with key value pairing.
 * 
 * @author nadar
 * @since 1.0.0-beta
 */
class CheckboxList extends Plugin
{
    public $items = [];
    
    public function __construct(array $items)
    {
        $this->items = $items;    
    }
    
    public function renderList($doc)
    {
        return $doc;
    }
    
    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-checkbox-array');
        $elmn->setAttribute('options', $this->getServiceName('checkboxitems'));
        $doc->appendChild($elmn);
        return $doc;
    }
    
    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
    
    public function serviceData()
    {
        return ['checkboxitems' => $this->getItems()];
    }
    
    public function onAfterNgRestFind($fieldValue)
    {
        return Json::decode($fieldValue);
    }
    
    public function onAfterFind($fieldValue)
    {
        return Json::decode($fieldValue);
    }
    
    public function onBeforeUpdate($value, $oldValue)
    {
        return $this->onBeforeCreate($value);
    }
    
    public function onBeforeCreate($value)
    {
        if (empty($value) || !is_array($value)) {
            $values = [];
        } else {
            foreach ($value as $k => $v) {
                if (is_array($v)) {
                    $values[$k] = $v;
                } else {
                    $values[$k] = ['id' => $v];
                }
            }
        }
        return Json::encode($values);
    }
    
    protected function getItems()
    {
        $data = [];
        
        foreach($this->items as $value => $label) {
            $data[] = ['value' => $value, 'label' => $label];    
        }
        
        return ['items' => $data];
    }
}