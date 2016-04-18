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
 * @property \luya\console\commands\ImportController $importer Importer Object
 * @author nadar
 */
abstract class Importer extends \yii\base\Object
{
    const QUEUE_POSITION_FIRST = 0;

    const QUEUE_POSITION_MIDDLE = 50;

    const QUEUE_POSITION_LAST = 100;

    /**
     * @var int The priority between 0 and 100 where to Import command should be queued.
     * + 0 = First
     * + 100 = Last
     */
    public $queueListPosition = self::QUEUE_POSITION_MIDDLE;

    /**
     * @var mixed|array Read only property contains the importer object.
     */
    private $_importer = null;

    /**
     * Class constructor containing the importer object from where its called.
     * 
     * @param \luya\console\commands\ImportController $importer Import Object `\luya\commands\ImportController`.
     */
    public function __construct(\luya\console\interfaces\ImportController $importer, $config = [])
    {
        $this->_importer = $importer;
        parent::__construct($config);
    }

    /**
     * Returns the import object to use the importers methods.
     * 
     * @return object Import \luya\console\commands\ImportController
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
	 * @todo trigger deprecated section call
     */
    public function addLog($section, $value)
    {
        $this->getImporter()->addLog(get_called_class(), $value);
    }

    /**
     * Each Importer Class must contain a run method.
     */
    abstract public function run();
}
