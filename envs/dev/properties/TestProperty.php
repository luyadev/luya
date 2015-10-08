<?php

namespace app\properties;

use Yii;

class TestProperty extends \admin\base\Property
{
    public function init()
    {
        $this->on(self::EVENT_BEFORE_RENDER, [$this, 'beforeIndex']);
    }
    
    public function beforeIndex($event)
    {
        Yii::$app->response->redirect('https://luya.io');
        $event->isValid = false;
    }
    
    public function varName()
    {
        return 'foobar';
    }    
    
    public function label()
    {
        return 'Foo Bar Label';
    }
    
    public function type()
    {
        return 'zaa-select';
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