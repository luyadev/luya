<?php

namespace cmsadmin\base;

abstract class NavItemType extends \yii\db\ActiveRecord
{
    abstract public function getContent();

    abstract public function getHeaders();

    public function getContextPropertysArray()
    {
        return []; // override
    }
    
    public $options = [];

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($key)
    {
        return (isset($this->options[$key])) ? $this->options[$key] : false;
    }
}
