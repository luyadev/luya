<?php

namespace admin\ngrest\plugins;

class Decimal extends \admin\ngrest\base\Plugin
{
    public $steps = 0;

    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-decimal', $id, $ngModel, ['options' => json_encode(['steps' => $this->steps ])]);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    public function onAfterFind($event)
    {
        $event->sender->setAttribute($this->name, (float) $event->sender->getAttribute($this->name));
    }
    
    /*
    public function onAfterNgRestFind($fieldValue)
    {
        return (float) $fieldValue;
    }
    */
}
