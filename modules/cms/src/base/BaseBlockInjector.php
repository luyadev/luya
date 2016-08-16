<?php

namespace cms\base;

use yii\base\Object;
use cmsadmin\base\BlockInterface;

abstract class BaseBlockInjector extends Object
{
    public $varName = null;
    
    public $varLabel = null;
    
    private $_context = null;
    
    public function setContext(BlockInterface $context)
    {
        $this->_context = $context;
    }
    
    public function getContext()
    {
        return $this->_context;
    }
    
    abstract public function setup();
}