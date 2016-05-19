<?php

namespace admin\ngrest\plugins;

use admin\ngrest\base\Plugin;

abstract class SortRelation extends Plugin
{
    abstract public function getData();
    
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
    
    public function serviceData()
    {
        return [
            'sortrelationdata' => $this->getData(),
        ];
    }
}