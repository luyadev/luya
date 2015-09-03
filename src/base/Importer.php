<?php

namespace luya\base;

/**
 * Abstract importer class provides basic funcionality to access the
 * helper class via `getImporter()`. Each importer class must have run()
 * method where the basic logic of the class will be executed.
 * 
 * ```php
 * class XyzImporter extends \luya\base\Importer
 * {
 *     public function run()
 *     {
 *         $this->getImporter()->addLog('xyz', 'XyzImporter have been started');
 *         
 *         // importer logic goes here
 *     }
 * }
 * ```
 * 
 * @author nadar
 */
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
