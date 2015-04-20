<?php
namespace luya\collection;

class PrefixComposition
{
    private $_composition = [];

    public $hideComposition = false;
    
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
        if ($this->hideComposition) {
            return;
        }
        
        return  \luya\helpers\Url::trailing(implode("/", $this->_composition));
    }

    public function set($array)
    {
        $this->_composition = $array;
    }
}
