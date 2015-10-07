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
    /**
     * @var mixed|array Read only property contains the importer object.
     */
    private $_importer = null;

    /**
     * Class constructor containing the importer object from where its called.
     * 
     * @param \luya\commands\ImportController $importer Import Object `\luya\commands\ImportController`.
     */
    public function __construct(\luya\commands\ImportController $importer)
    {
        $this->_importer = $importer;
    }

    /**
     * Returns the import object to use the importers methods.
     * 
     * @return object Import Object
     */
    public function getImporter()
    {
        return $this->_importer;
    }

    /**
     * Each Importer Class must contain a run method.
     * 
     * @return void
     */
    abstract public function run();
}
