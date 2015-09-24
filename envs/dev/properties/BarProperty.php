<?php

namespace app\properties;

class BarProperty extends \admin\base\Property
{
    public function varName()
    {
        return 'yolor';
    }    
    
    public function label()
    {
        return 'Yolor 1';
    }
    
    public function type()
    {
        return 'zaa-textarea';
    }
    
    /*
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
    */
}