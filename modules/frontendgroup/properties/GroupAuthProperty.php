<?php

namespace frontendgroup\properties;

use Yii;
use yii\helpers\Json;

class GroupAuthProperty extends \admin\base\Property
{
    public function init()
    {
        // parent initializer
        parent::init();
        
        // check if the current menu item does have this group
        //var_dump($this->getValue());
        
    }
    
    public function varName()
    {
        return 'groupAuthProtection';
    }
    
    public function label()
    {
        return 'Welche Gruppen können diese Seite sehen?';
    }

    public function type()
    {
        return 'zaa-checkbox-array';
    }
    
    public function options()
    {
        $opt = [];
        foreach (Yii::$app->getModule('frontendgroup')->frontendGroups as $group) {
            $opt[] = ['value' => $group, 'label' => $group];
        }
        
        return ['items' => $opt];
    }
    
    public function getGroups()
    {
        $groups = [];
        foreach ($this->getValue() as $value) {
            $groups[] = $value['id'];
        }
        return $groups;
    }
    
    public function requiresAuth()
    {
        return (bool) !empty($this->getGroups());
    }
    
    public function getValue()
    {
        return Json::decode($this->value);
    }
}
