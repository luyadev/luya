<?php

namespace luya\console\commands;

use Yii;
use Exception;
use luya\admin\models\Config;
use luya\console\Command;
use luya\console\interfaces\ImportControllerInterface;

/**
 * Import controller runs the module defined importer classes.
 *
 * The importer classes are defined inthe modules `import()` methods which inherits this class. To run
 * the importer class you have execute:
 *
 * ```
 * ./vendor/bin/luya import
 * ```
 *
 * Each of the importer classes must extend the luya\console\Importer class.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ImportController extends Command implements ImportControllerInterface
{
    private $_dirs = [];

    private $_log = [];

    private $_scanFolders = ['blocks', 'filters', 'properties', 'blockgroups'];

    /**
     * Initializer
     */
    public function init()
    {
        parent::init();
        
        // foreach scanFolders of all modules
        foreach (Yii::$app->modules as $id => $module) {
            if ($module instanceof \luya\base\Module) {
                foreach ($this->_scanFolders as $folderName) {
                    $this->addToDirectory($module->getBasePath().DIRECTORY_SEPARATOR.$folderName, $folderName, '\\'.$module->getNamespace().'\\'.$folderName, $module->id);
                }
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
        // create array
        $files = [];
        if (array_key_exists($folderName, $this->_dirs)) {
            foreach ($this->_dirs[$folderName] as $folder) {
                foreach ($folder['files'] as $file) {
                    $files[] = $file;
                }
            }
        }
        // return files
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
     * Return the log array data.
     *
     * @return array
     */
    private function getLog()
    {
        return $this->_log;
    }

    /**
     * Run the import process.
     *
     * @return number
     */
    public function actionIndex()
    {
        try {
            $queue = [];
            $this->verbosePrint('Run import index', __METHOD__);
            foreach (Yii::$app->getModules() as $id => $module) {
                if ($module instanceof \luya\base\Module) {
                    $this->verbosePrint('collect module importers from module: ' . $id, __METHOD__);
                    $response = $module->import($this);
                    if (is_array($response)) { // importer returns an array with class names
                        foreach ($response as $class) {
                            $this->verbosePrint("add object '$class' to queue list", __METHOD__);
                            $obj = new $class($this);
                            $prio = $obj->queueListPosition;
                            while (true) {
                                if (!array_key_exists($prio, $queue)) {
                                    break;
                                }
                                ++$prio;
                            }
                            $queue[$prio] = $obj;
                        }
                    }
                }
            }
    
            ksort($queue);
    
            foreach ($queue as $pos => $object) {
                $this->verbosePrint("run object '" .$object->className() . " on pos $pos.", __METHOD__);
                $objectResponse = $object->run();
                $this->verbosePrint("run object response: " . var_export($objectResponse, true), __METHOD__);
            }
    
            if (Yii::$app->hasModule('admin')) {
                Config::set('last_import_timestamp', time());
                Yii::$app->db->createCommand()->update('admin_user', ['force_reload' => 1])->execute();
            }
    
            $this->verbosePrint('importer finished, get log output: ' . var_export($this->getLog(), true), __METHOD__);
            
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
        } catch (Exception $err) {
            return $this->outputError(sprintf("Exception while importing: '%s' in file '%s' on line '%s'.", $err->getMessage(), $err->getFile(), $err->getLine()));
        }
    }
}
