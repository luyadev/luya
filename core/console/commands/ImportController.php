<?php

namespace luya\console\commands;

use Yii;
use yii\console\widgets\Table;
use luya\Boot;
use luya\admin\models\Config;
use luya\console\Command;
use luya\console\interfaces\ImportControllerInterface;

/**
 * Import controller runs the module defined importer classes.
 *
 * The importer classes are defined inthe modules `import()` methods which inherits this class.
 *
 * ```sh
 * ./vendor/bin/luya import
 * ```
 *
 * Each of the importer classes must extend the {{\luya\console\Importer}} class.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ImportController extends Command implements ImportControllerInterface
{
    /**
     * @var array An array with all folder names inside an application/module to scan for files.
     */
    protected $scanFolders = ['themes', 'blocks', 'filters', 'properties', 'blockgroups'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        // foreach scanFolders of all modules
        foreach (Yii::$app->getApplicationModules() as $id => $module) {
            foreach ($this->scanFolders as $folderName) {
                $this->addToDirectory($module->getBasePath().DIRECTORY_SEPARATOR.$folderName, $folderName, '\\'.$module->getNamespace().'\\'.$folderName, $module->id);
            }
        }
        // foreach scanFolder inside the app namespace
        foreach ($this->scanFolders as $folderName) {
            $this->addToDirectory(Yii::getAlias("@app/$folderName"), $folderName, '\\app\\'.$folderName, 'app');
        }
    }

    private $_dirs = [];
    
    /**
     * Add a given directory to the list of folders.
     *
     * @param string $path
     * @param string $folderName
     * @param string $ns
     * @param string $module The name/id of the module.
     */
    protected function addToDirectory($path, $folderName, $ns, $module)
    {
        if (file_exists($path)) {
            $this->_dirs[$folderName][] = [
                'ns' => $ns,
                'module' => $module,
                'folderPath' => $path.DIRECTORY_SEPARATOR,
                'files' => $this->scanDirectoryFiles($path, $ns, $module),
            ];
        }
    
    }
    
    /**
     * Scan a given directory path and return an array with namespace, module and file.
     *
     * @param string $path
     * @param string $ns
     * @param string $module The name/id of the module.
     * @return array
     */
    protected function scanDirectoryFiles($path, $ns, $module)
    {
        $files = [];
        foreach (scandir($path) as $file) {
            if (substr($file, 0, 1) !== '.') {
                $files[] = [
                    'file' => $file,
                    'filePath' => $path.DIRECTORY_SEPARATOR.$file,
                    'module' => $module,
                    'ns' => $ns.'\\'.pathinfo($file, PATHINFO_FILENAME),
                ];
            }
        }
        
        return $files;
    }
    
    /**
     * @inheritdoc
     */
    public function getDirectoryFiles($folderName)
    {
        $files = [];
        if (array_key_exists($folderName, $this->_dirs)) {
            foreach ($this->_dirs[$folderName] as $folder) {
                foreach ($folder['files'] as $file) {
                    $files[] = $file;
                }
            }
        }
        
        return $files;
    }
    
    private $_log = [];

    /**
     * @inheritdoc
     */
    public function addLog($section, $value)
    {
        $this->_log[$section][] = $value;
    }
    
    /**
     * Get all log data.
     *
     * @return array
     */
    public function getLog()
    {
        return $this->_log;
    }

    /**
     * Get all importer objects with the assigned queue position.
     *
     * @return array If no importer objects are provided the array will is returned empty.
     */
    public function buildImporterQueue()
    {
        $queue = [];
        foreach (Yii::$app->getApplicationModules() as $id => $module) {
            $response = $module->import($this);
            // if there response is an array, the it will be added to the queue
            if (is_array($response)) {
                foreach ($response as $class) {
                    $object = Yii::createObject($class, [$this, $module]);
                    $position = $object->queueListPosition;
                    while (true) {
                        if (!array_key_exists($position, $queue)) {
                            break;
                        }
                        ++$position;
                    }
                    $queue[$position] = $object;
                }
            }
        }
        
        ksort($queue);
        return $queue;
    }
    
    /**
     * Run the import process.
     *
     * @return number
     */
    public function actionIndex()
    {
        $queue = $this->buildImporterQueue();

        foreach ($queue as $pos => $object) {
            $this->verbosePrint("Run importer object '{$object->className()}' on position '{$pos}'.", __METHOD__);
            $this->verbosePrint('Module context id: ' . $object->module->id);
            $object->run();
        }

        if (Yii::$app->hasModule('admin')) {
            Config::set(Config::CONFIG_LAST_IMPORT_TIMESTAMP, time());
            Config::set(Config::CONFIG_INSTALLER_VENDOR_TIMESTAMP, Yii::$app->packageInstaller->timestamp);
            Yii::$app->db->createCommand()->update('admin_user', ['force_reload' => 1])->execute();
        }
        
        $this->output('LUYA import command (based on LUYA ' . Boot::VERSION . ')');
        
        foreach ($this->getLog() as $section => $value) {
            $this->outputInfo(PHP_EOL . $section . ":");
            $this->logValueToTable($value);
        }
        
        return $this->outputSuccess("Importer run successful.");
    }
    
    /**
     * Print the log values as a table.
     *
     * @param array $logs
     * @since 1.0.8
     */
    private function logValueToTable(array $logs)
    {
        $table = new Table();
        $table->setHeaders(['Key', 'Value']);
        $rows = [];
     
        foreach ($logs as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $kk => $kv) {
                    $rows[] = [$kk, $kv];
                }
            } else {
                $rows[] = [$key, $value];
            }
        }
        $table->setRows($rows);
        echo $table->run();
    }
}
