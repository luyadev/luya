<?php

namespace luya\console\commands;

use Yii;
use Exception;
use admin\models\Config;

class ImportController extends \luya\console\Command implements \luya\console\interfaces\ImportController
{
    private $_dirs = [];

    private $_log = [];

    private $_scanFolders = ['blocks', 'filters', 'properties', 'blockgroups'];

    public function init()
    {
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
     * Get all files from a directory (direcotry must be in _scanFolders map). An array will be returnd with the keys
     * - file => the Filename
     * - ns => the absolut namepsace to this file.
     * 
     * ```php
     * $this->getDirectoryFiles('blocks');
     * ```
     * 
     * If there are no files found getDirectoryFiles will return an empty array.
     * 
     * @param stirng $folderName
     *
     * @return array
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
     * Add something to the output.
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
        $this->_log[$section][] = $value;
    }

    public function actionIndex()
    {
        try {
            $queue = [];
    		$this->verbosePrint('Run import index', __METHOD__);
            foreach (Yii::$app->getModules() as $id => $module) {
                if ($module instanceof \luya\base\Module) {
                	$this->verbosePrint('collect module import data:' . $id, __METHOD__);
                    $response = $module->import($this);
                    if (is_array($response)) { // importer returns an array with class names
                        foreach ($response as $class) {
                        	$this->verbosePrint("add '$class' to queue list", __METHOD__);
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
                $this->verbosePrint("run response: " . var_export($objectResponse, true), __METHOD__);
            }
    
            if (Yii::$app->hasModule('admin')) {
                Config::set('last_import_timestamp', time());
                Yii::$app->db->createCommand()->update('admin_user', ['force_reload' => 1])->execute();
            }
    
            $this->verbosePrint('importer finish, log outpu: ' . var_export($this->_log, true), __METHOD__);
            return $this->outputSuccess(print_r($this->_log, true));
        } catch (Exception $err) {
            return $this->outputError(sprintf("Exception while importing: '%s' in file '%s' on line '%s'.", $err->getMessage(), $err->getFile(), $err->getLine()));
        }
    }
}
