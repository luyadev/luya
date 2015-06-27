<?php

namespace cmsadmin\base;

abstract class BlockConfigElement
{
    public $item = [];
    
    public function __construct($item)
    {
        $this->item = $item;
    }
    
    protected function has($key)
    {
        if (!is_array($key)) {
            return (array_key_exists($key, $this->item));
        }
    
        foreach($key as $value) {
            if (!array_key_exists($value, $this->item)) {
                return false;
            }
        }
    
        return true;
    }
    
    abstract public function toArray();
    
}