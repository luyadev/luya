<?php

namespace cmsadmin\models;

class NavItemRedirect extends \cmsadmin\base\NavItemType
{
    public static function tableName()
    {
        return 'cms_nav_item_redirect';
    }
    
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
        ];
    }

    public function getContent()
    {
        return;
    }
    
    public function getHeaders()
    {
        return;
    }
}
