<?php

namespace admin\ngrest\plugins;

use admin\ngrest\base\Model;

/**
 * Base class for select dropdowns via Array or Model.
 * 
 * @author nadar
 */
abstract class Select extends \admin\ngrest\base\Plugin
{
    public $initValue = 0;

    public $data = [];

    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-select', $id, $ngModel, ['initvalue' => $this->initValue, 'options' => $this->getServiceName('selectdata')]);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }

    public function serviceData()
    {
        return ['selectdata' => $this->data];
    }
    
    public function onAfterListFind($event)
    {
        foreach ($this->data as $item) {
            if ($item['value'] == $event->sender->getAttribute($this->name)) {
                $event->sender->setAttribute($this->name, $item['label']);
            }
        }
    }
}
