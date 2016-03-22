<?php

namespace admin\ngrest\plugins;

/**
 * Create a text input select for a given field.
 * 
 * @author nadar
 */
class Text extends \admin\ngrest\base\Plugin
{
    public $placeholder = null;

    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-text', $id, $ngModel, ['placeholder' => $this->placeholder]);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
