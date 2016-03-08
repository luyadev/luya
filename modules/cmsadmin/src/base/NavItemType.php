<?php

namespace cmsadmin\base;

abstract class NavItemType extends \yii\db\ActiveRecord
{
    public $options = [];

    private $_navItem = null;

    abstract public function getContent();

    public function setNavItem($navItem)
    {
        $this->_navItem = $navItem;
    }

    public function getNavItem()
    {
        return $this->_navItem;
    }

    public function getContextPropertysArray()
    {
        return []; // override
    }

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
