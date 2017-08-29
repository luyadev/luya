<?php

namespace app\properties;

use luya\admin\base\Property;

class TestProperty extends Property
{
    public function init()
    {
        $this->on(self::EVENT_BEFORE_RENDER, [$this, 'beforeIndex']);
    }
    
    public function beforeIndex($event)
    {
        $event->isValid = true;
    }
    
    public function varName()
    {
        return 'test';
    }
    
    public function label()
    {
        return 'Test Property Label';
    }
    
    public function type()
    {
        return 'zaa-radios';
    }
    
    public function defaultValue()
    {
        return 'ul';
    }
    
    public function options()
    {
        return [
            ['value' => 'ul', 'label' => 'Stichpunktliste'],
            ['value' => 'ol', 'label' => 'Nummerierte Liste'],
        ];
    }
}
