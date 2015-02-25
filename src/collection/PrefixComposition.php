<?php
namespace luya\collection;

class PrefixComposition
{
    private $_composition = [];
    
    public function __get($key)
    {
        return $this->getKey($key, false);
    }
    
    public function setKey($key, $value)
    {
        $this->_composition[$key] = $value;
    }
    
    public function getKey($key, $defaultValue = false)
    {
        return (isset($this->_composition[$key])) ? $this->_composition[$key] : $defaultValue;
    }
    
    public function getFull()
    {
        return implode("/", $this->_composition);
    }
    
    public function set($array)
    {
        $this->_composition = $array;
    }
}