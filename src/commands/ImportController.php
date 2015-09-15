<?php

namespace luya\commands;

use Yii;

class ImportController extends \luya\base\Command implements \luya\interfaces\ImportCommand
{
    private $_dirs = [];

    private $_log = [];

    private $_scanFolders = ['blocks', 'filters'];

    public function init()
    {
        // foreach scanFolders of all modules
        foreach (Yii::$app->modules as $id => $module) {
            foreach ($this->_scanFolders as $folderName) {
                $this->addToDirectory($module->getBasePath().DIRECTORY_SEPARATOR.$folderName, $folderName, '\\'.$module->getNamespace().'\\'.$folderName, $module->id);
            }
        }
        // foreach scanFolder inside the app namespace
        foreach ($this->_scanFolders as $folderName) {
            $this->addToDirectory(Yii::getAlias("@app/$folderName"), $folderName, '\\app\\'.$folderName, '@app');
        }
    }

    private function scanDirectoryFiles($path, $ns)
    {
        $files = [];
        foreach (scandir($path) as $file) {
            if (substr($file, 1) !== '.') {
                $files[] = [
                    'file' => $file,
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
                'files' => $this->scanDirectoryFiles($path, $ns),
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
        foreach (Yii::$app->getModules() as $id => $module) {
            if ($module instanceof \luya\base\Module) {
                $response = $module->import($this);
                if (is_array($response)) { // importer returns an array with class names
                    foreach ($response as $class) {
                        $obj = new $class($this);
                        $obj->run();
                    }
                }
            }
        }

        \admin\models\Config::set('last_import_timestamp', time());

        return $this->outputSuccess(print_r($this->_log, true));
    }
}
