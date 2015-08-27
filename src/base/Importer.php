<?php

namespace luya\base;

abstract class Importer
{
    private $_importer = null;
    
    public function __construct(\luya\commands\ImportController $importer)
    {
        $this->_importer = $importer;
    }
    
    public function getImporter()
    {
        return $this->_importer;
    }
    
    abstract public function run();
}