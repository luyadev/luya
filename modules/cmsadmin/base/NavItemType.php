<?php

namespace cmsadmin\base;

abstract class NavItemType extends \yii\db\ActiveRecord
{
    abstract public function getContent();

    abstract public function getHeaders();

    abstract public function getContext();

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
