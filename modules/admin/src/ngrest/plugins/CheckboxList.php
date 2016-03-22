<?php

namespace admin\ngrest\plugins;

use admin\ngrest\base\Plugin;
use yii\helpers\Json;

/**
 * Create a checkbox list with selection based on an array with key value pairing.
 * 
 * @todo testing and complete find and save events.
 * @author nadar
 */
class CheckboxList extends Plugin
{
    public $items = [];
    
    public function renderList($id, $ngModel)
    {
        return $this->createTag('span', 'no supported yet in list view');
    }
    
    public function renderCreate($id, $ngModel)
    {
        return $this->createBasicTag('zaa-checkbox-array', $id, $ngModel, ['options' => $this->getServiceName('checkboxitems')]);
    }
    
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    protected function getItems()
    {
    	$data = [];
    
    	foreach ($this->items as $value => $label) {
    		$data[] = ['value' => $value, 'label' => $label];
    	}
    
    	return ['items' => $data];
    }
    
    public function serviceData()
    {
        return ['checkboxitems' => $this->getItems()];
    }
    
    /*
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
        
        foreach ($this->items as $value => $label) {
            $data[] = ['value' => $value, 'label' => $label];
        }
        
        return ['items' => $data];
    }
    */
}
