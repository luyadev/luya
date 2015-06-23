<?php

namespace admin\components;

use \luya\helpers\Url;

class Composition extends \yii\base\Component
{
    private $_composition = [];
    
    public $hideComposition = false;
    
    /**
     * @todo temp remove?
     * @see \yii\base\Component::__get()
     */
    /*
    public function __get($key)
    {
        return $this->getKey($key, false);
    }
    */
    
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
    
        return Url::trailing(implode('/', $this->_composition));
    }
    
    public function getLocale()
    {
        switch($this->_composition['langShortCode']) {
            case "de":
                return "de_DE";
                break;
            case "en":
                return "en_EN";
                break;
            case "fr":
                return "fr_FR";
                break;
            case "it":
                return "it_IT";
                break;
        }
    }
    
    public function getLanguage()
    {
        return $this->_composition['langShortCode'];
    }
    
    public function set($array)
    {
        $this->_composition = $array;
    }
}