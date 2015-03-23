<?php

namespace luya\commands;

/**
 * Find all files inside all modules to the specific action type (example auth() = auth.php files), include them 
 * and do something with the response array inside of the files.
 * 
 * @todo rename later on to configurables? or sth. else.
 * @author nadar
 *
 */
class ExecutableController extends \yii\console\Controller
{
    private $_dirs = [];
    
    public function init()
    {
        foreach (\yii::$app->modules as $key => $item) {
            $module = \Yii::$app->getModule($key);
            $folder = $module->getBasePath().DIRECTORY_SEPARATOR.'executables';
            if (file_exists($folder)) {
                $this->_dirs[] = [
                    'module' => $module->id,
                    'folderPath' => $folder . DIRECTORY_SEPARATOR,
                    'files' => scandir($folder)
                ];
            }
        }
    }
    
    public function getFiles($fileName)
    {
        $files = [];
        foreach ($this->_dirs as $item) {
            foreach ($item['files'] as $file) {
                if ($file == $fileName) {
                    $files[] = $item['folderPath'] . $file;
                }
            }
        }
        
        return $files;
    }
    
    public function actionIndex()
    {
        $this->stdout("use: exec/auth\n");
    }
    
    /**
     * find all auth.php files, invoke them and return to \yii::$app->luya->auth->addRule
     */
    public function actionAuth()
    {
        $f = $this->getFiles('auth.php');   
        var_dump($f);
    }
    
    
}