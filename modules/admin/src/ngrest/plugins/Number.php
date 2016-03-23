<?php

namespace admin\ngrest\plugins;

use luya\helpers\ArrayHelper;

/**
 * Create a number html 5 input tage with optional placeholder.
 * 
 * @author nadar
 */
class Number extends \admin\ngrest\base\Plugin
{
    public $placeholder = null;

    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-number', $id, $ngModel, ['placeholder' => $this->placeholder]);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    public function onAfterExpandFind($event)
    {
        $fieldValue = $event->sender->getAttribute($this->name);
        
        if (is_array($fieldValue)) {
            $event->sender->setAttribute($this->name, ArrayHelper::typeCast($fieldValue));
        } else {
            $event->sender->setAttribute($this->name, (int) $fieldValue);
        }
    }
    
    public function onAfterFind($event)
    {
        $event->sender->setAttribute($this->name, (int) $event->sender->getAttribute($this->name));
    }
}
