<?php

namespace cmsadmin\base;

use cmsadmin\models\NavItem;

abstract class NavItemType extends \yii\db\ActiveRecord
{
    public $options = [];
    
    public $controller = false;
    
    /**
     * Get the response content for the item type
     * 
     * @return mixed
     */
    abstract public function getContent();
    
    /**
     * Get the corresponding nav item type for this type object
     */
    public function getNavItem()
    {
        return $this->hasOne(NavItem::className(), ['nav_item_type_id' => 'id'])->where(['nav_item_type' => static::getNummericType()]);
    }
    
    /*
    public function setNavItem($navItem)
    {
        $this->_navItem = $navItem;
    }

    public function getNavItem()
    {
        return $this->_navItem;
    }
    */

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
