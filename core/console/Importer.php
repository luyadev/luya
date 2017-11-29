<?php

namespace luya\console;

use luya\console\interfaces\ImportControllerInterface;
use yii\base\BaseObject;

/**
 * Base class for all Importer classes.
 *
 * Abstract importer class provides basic funcionality to access the
 * helper class via `getImporter()`. Each importer class must have run()
 * method where the basic logic of the class will be executed.
 *
 * ```php
 * class XyzImporter extends \luya\console\Importer
 * {
 *     public function run()
 *     {
 *         $this->addLog('XyzImporter have been started');
 *
 *         // importer logic goes here
 *     }
 * }
 * ```
 *
 * @property \luya\console\interfaces\ImportControllerInterface $importer Importer Object
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Importer extends BaseObject
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
    private $_importer;

    /**
     * Class constructor containing the importer object from where its called.
     *
     * @param \luya\console\interfaces\ImportControllerInterface $importer Import Object `\luya\commands\ImportController`.
     */
    public function __construct(ImportControllerInterface $importer, $config = [])
    {
        $this->_importer = $importer;
        parent::__construct($config);
    }

    /**
     * Returns the import object to use the importers methods.
     *
     * @return \luya\console\interfaces\ImportControllerInterface The importer object.
     */
    public function getImporter()
    {
        return $this->_importer;
    }

    /**
     * Add something to the output. Wrapper method from importer.
     *
     * ```php
     * $this->addLog('new block <ID> have been found and added to database');
     * ```
     *
     * @param string $value The value to be written for the log output.
     */
    public function addLog($value)
    {
        $this->getImporter()->addLog(get_called_class(), $value);
    }

    /**
     * Each Importer Class must contain a run method.
     */
    abstract public function run();
}
