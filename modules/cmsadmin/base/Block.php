<?php

namespace cmsadmin\base;

use yii;

abstract class Block implements BlockInterface
{
    private $_jsonConfig = [];
    
    private $_values = [];
    
    public $renderPath = '@app/views/blocks/';

    public function __construct()
    {
        $this->_jsonConfig = json_encode($this->config());
    }
    
    public function setVarValues(array $values)
    {
        $this->_values = $values;
    }
    
    public function getVarValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_values)) ? $this->_values[$key] : $default;
    }
    
    public function getRenderPath()
    {
        return $this->renderPath;
    }
    
    private function render($twigFile)
    {
        return file_get_contents(yii::getAlias($this->getRenderPath().$twigFile));
    }
    
    // access from outside
    
    public function extraVars()
    {
        return [];
    }
    
    public function jsonConfig()
    {
        return $this->_jsonConfig;
    }
    
    /*
    public function getName()
    {
        return $this->name();
    }
    

    public function getTwigFrontend()
    {
        return $this->twigFrontend();
    }

    public function getTwigAdmin()
    {
        return $this->twigAdmin();
    }
    */
}
