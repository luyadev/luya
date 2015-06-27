<?php

namespace cmsadmin\base;

use yii;
use cmsadmin\base\BlockVar;
use cmsadmin\base\BlockCfg;

abstract class Block implements BlockInterface
{
    private $_varValues = [];

    private $_cfgValues = [];

    private $_envOptions = [];

    private $_config = null;
    
    public $module = 'app';
    
    public function __construct()
    {
        $this->init();
        $this->_config = $this->config();
    }

    public function init()
    {
        // override
    }
    
    /* getter & setter EnvOptions */

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

    /* getter & setter VarValue */
    
    public function getVarValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_varValues)) ? $this->_varValues[$key] : $default;
    }
    
    public function setVarValues(array $values)
    {
        $this->_varValues = $values;
    }
    
    /* getter & setter CfgValue */
    
    public function getCfgValue($key, $default = false)
    {
        return (array_key_exists($key, $this->_cfgValues)) ? $this->_cfgValues[$key] : $default;
    }

    public function setCfgValues(array $values)
    {
        $this->_cfgValues = $values;
    }
    
    /* render methods */

    /**
     * @todo does first char alread contain '@'
     * @return string
     */
    private function getModule()
    {
        return '@' . $this->module;
    }
    
    public function getRenderFileName()
    {
        $classname = get_class($this);

        if (preg_match('/\\\\([\w]+)$/', $classname, $matches)) {
            $classname = $matches[1];
        }
    
        return $classname . '.twig';
    }

    protected function getTwigRenderFile($app)
    {
        return yii::getAlias($app . '/views/blocks/' . $this->getRenderFileName());
    }
    
    protected function render()
    {
        return $this->baseRender($this->getModule());
    }

    private function baseRender($module)
    {
        $twigFile = $this->getTwigRenderFile($module);
        if (!file_exists($twigFile)) {
            throw new \Exception("Twig file '$twigFile' does not exists!");
        }
        return file_get_contents($twigFile);
    }
    
    public function getTwigFrontendContent()
    {
        $twigFile = $this->getTwigRenderFile('@app');
        if (file_exists($twigFile)) {
            return $this->baseRender('@app');
        }
        return $this->twigFrontend();
    }
    
    // access from outside

    public function extraVars()
    {
        return [];
    }
    
    public function getVars()
    {
        if (!array_key_exists('vars', $this->_config)) {
            return [];
        }
        $data = [];
        foreach($this->_config['vars'] as $item) {
            $data[] = (new BlockVar($item))->toArray();
        }
        
        return $data;
    }
    
    public function getPlaceholders()
    {
        return (array_key_exists('placeholders', $this->_config)) ? $this->_config['placeholders'] : [];
    }
    
    public function getCfgs()
    {
        if (!array_key_exists('vars', $this->_config)) {
            return [];
        }
        $data = [];
        foreach($this->_config['vars'] as $item) {
            $data[] = (new BlockCfg($item))->toArray();
        }
        
        return $data;
    }
    
    /**
     * @todo remove me
     */
    public function jsonConfig()
    {
        return json_encode($this->config());
    }
    
    public function icon()
    {
        return null;   
    }
    
    public function getFullName()
    {
        return ($this->icon() === null) ? $this->name() : '<i class="left '.$this->icon().'"></i> <span>' . $this->name() . '</span>';
    }
}
