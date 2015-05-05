<?php

namespace cmsadmin\base;

use yii;

abstract class Block implements BlockInterface
{
    private $_jsonConfig = [];
    
    private $_varValues = [];
    
    private $_cfgValues = [];
    
    private $_envOptions = [];
    
    public $renderPath = '@app/views/blocks/';

    public function __construct()
    {
        $this->init();
    }
    
    public function init()
    {
        // use
    }
    
    public function setEnvOptions(array $values)
    {
        $this->_envOptions = $values;
    }
    
    public function getEnvOption($key, $default = false)
    {
        return (array_key_exists($key, $this->_envOptions)) ? $this->_envOptions[$key] : $default;
    }
    
    public function getEnvOptions()
    {
        return $this->_envOptions;
    }
    
    public function setVarValues(array $values)
    {
        $this->_varValues = $values;
    }
    
    public function getCfgValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_cfgValues)) ? $this->_cfgValues[$key] : $default;
    }
    
    public function getVarValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_varValues)) ? $this->_varValues[$key] : $default;
    }
    
    public function setCfgValues(array $values) {
        $this->_cfgValues = $values;
    }
    
    public function getRenderPath()
    {
        return $this->renderPath;
    }
    
    protected function render($twigFile)
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
        return json_encode($this->config());
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
