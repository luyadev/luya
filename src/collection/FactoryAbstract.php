<?php
namespace luya\collection;

abstract class FactoryAbstract
{
    protected $factory = null;
    
    public function __construct($factory)
    {
        $this->factory = $factory;
    }
    
    public function init()
    {
        
    }
}