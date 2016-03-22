<?php

namespace admin\ngrest\plugins;

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
    
    /*
    public function onAfterNgRestFind($fieldValue)
    {
        return (int) $fieldValue;
    }
    */
}
