<?php

namespace admin\ngrest\base;

class View extends \yii\base\View
{
    public $module = null;
    
    public $id = null;
    
    public function render($view, $params = [], $context = null)
    {
        if ($this->id === null) {
            throw new \Exception("The ActiveWindow View 'id' can't be empty!");
        }
        if ($this->module === null) {
            throw new \Exception("The ActiveWindow View 'module' can't be empty!");
        }
        
        if ($context === null) {
            $context = new \admin\ngrest\base\ViewContext();
            $context->module = $this->module;
            $context->id = $this->id;
        }
        
        return parent::render($view, $params, $context);
    }
}