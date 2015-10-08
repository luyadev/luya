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
abstract class Importer extends \yii\base\Object
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
     * Add something to the output. Wrapper method from importer.
     * 
     * ```php
     * $this->addLog('block', 'new block <ID> have been found and added to database');
     * ```
     * 
     * @param string $section
     * @param string $value
     */
    public function addLog($section, $value)
    {
        $this->importer->addLog($section, $value);
    }

    /**
     * Each Importer Class must contain a run method.
     */
    abstract public function run();
}
