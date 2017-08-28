<?php

namespace luya\console\commands;

use Yii;

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
    private $_dirs = [];

    private $_log = [];

    private $_scanFolders = ['blocks', 'filters', 'properties', 'blockgroups'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        // foreach scanFolders of all modules
        foreach (Yii::$app->getApplicationModules() as $id => $module) {
            foreach ($this->_scanFolders as $folderName) {
                $this->addToDirectory($module->getBasePath().DIRECTORY_SEPARATOR.$folderName, $folderName, '\\'.$module->getNamespace().'\\'.$folderName, $module->id);
            }
        }
        // foreach scanFolder inside the app namespace
        foreach ($this->_scanFolders as $folderName) {
            $this->addToDirectory(Yii::getAlias("@app/$folderName"), $folderName, '\\app\\'.$folderName, '@app');
        }
    }

    private function scanDirectoryFiles($path, $ns, $module)
    {
        $files = [];
        foreach (scandir($path) as $file) {
            if (substr($file, 0, 1) !== '.') {
                $files[] = [
                    'file' => $file,
                    'module' => $module,
                    'ns' => $ns.'\\'.pathinfo($file, PATHINFO_FILENAME),
                ];
            }
        }

        return $files;
    }

    private function addToDirectory($path, $folderName, $ns, $module)
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
                    $object = new $class($this);
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
            $object->run();
        }

        if (Yii::$app->hasModule('admin')) {
            Config::set(Config::CONFIG_LAST_IMPORT_TIMESTAMP, time());
            Config::set(Config::CONFIG_INSTALLER_VENDOR_TIMESTAMP, Yii::$app->packageInstaller->timestamp);
            Yii::$app->db->createCommand()->update('admin_user', ['force_reload' => 1])->execute();
        }
        
        foreach ($this->getLog() as $section => $value) {
            $this->outputInfo(PHP_EOL . $section . ":");
            foreach ($value as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $kk => $kv) {
                        if (is_array($kv)) {
                            $this->output(" - {$kk}: " . print_r($kv, true));
                        } else {
                            $this->output(" - {$kk}: {$kv}");
                        }
                    }
                } else {
                    $this->output(" - " . $v);
                }
            }
        }
        
        return $this->outputSuccess("Importer run successfull.");
    }
}
