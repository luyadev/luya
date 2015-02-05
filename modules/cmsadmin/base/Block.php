<?php
namespace cmsadmin\base;

abstract class Block
{
    public $name = null;
    
    public $jsonConfig = [];
    
    public $twigFrontend = null;
    
    public $twigAdmin = null;
    
    public function __construct() {
        $fromArray = $this->jsonFromArray();
        
        if ($fromArray) {
            $this->jsonConfig = json_encode($fromArray);
        }
    }
    
    public function jsonFromArray()
    {
        return false;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getJsonConfig()
    {
        return $this->jsonConfig;
    }
    
    public function getTwigFrontend()
    {
        return $this->twigFrontend;
    }
    
    public function getTwigAdmin()
    {
        return $this->twigAdmin;
    }
}