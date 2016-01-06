<?php

namespace admin\ngrest\base;

use luya\Exception;

class View extends \yii\base\View
{
    public $module = null;

    public $id = null;

    public function render($view, $params = [], $context = null)
    {
        if ($this->id === null || $this->module === null) {
            throw new Exception("The 'id' and 'module' properties are required to render the view file '$view'.");
        }

        if ($context === null) {
            $context = new \admin\ngrest\base\ViewContext();
            $context->module = $this->module;
            $context->id = $this->id;
        }

        return parent::render($view, $params, $context);
    }
}
