<?php
namespace cmsadmin\base;

abstract class NavItemType extends \yii\db\ActiveRecord
{
    abstract public function getContent();

    abstract public function getHeaders();
    
    public function setOptions($options)
    {
        $this->options = $options;
    }
    
    public function getOption($key)
    {
        return (isset($this->options[$key])) ? $this->options[$key] : false;
    }
}
