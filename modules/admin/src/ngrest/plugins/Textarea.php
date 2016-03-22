<?php

namespace admin\ngrest\plugins;

class Textarea extends \admin\ngrest\base\Plugin
{
    public $placeholder = null;

    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-textarea', $id, $ngModel, ['placeholder' => $this->placeholder]);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
