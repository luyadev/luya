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
        // atache before render to stop render if not in group
        $this->on(self::EVENT_BEFORE_RENDER, [$this, 'eventBeforeRender']);
    }
    
    public function eventBeforeRender($event)
    {
        if ($this->requiresAuth()) {
            $event->isValid = false;
            foreach (Yii::$app->getModule('frontendgroup')->frontendUsers as $userComponent) {
                $user = Yii::$app->get($userComponent);
                if (!$user->isGuest && $user->inGroup($this->getGroups())) {
                    $event->isValid = true;
                }
            }
        }
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
