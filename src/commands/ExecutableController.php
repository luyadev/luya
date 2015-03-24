<?php

namespace luya\commands;

/**
 * Find all files inside all modules to the specific action type (example auth() = auth.php files), include them
 * and do something with the response array inside of the files.
 *
 * @todo rename later on to configurables? or sth. else.
 *
 * @author nadar
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
                    'folderPath' => $folder.DIRECTORY_SEPARATOR,
                    'files' => scandir($folder),
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
                    $files[] = $item['folderPath'].$file;
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
     * find all auth.php files, invoke them and return to \yii::$app->luya->auth->addRule.
     * 
     * before: 
     * ```
     * foreach ($this->getFiles('auth.php') as $source) {
     *     include($source);
     * }
     * ```
     */
    public function actionAuth()
    {
        $modules = \yii::$app->getModules();
        foreach ($modules as $id => $item) {
            $object = \yii::$app->getModule($id);
            if (method_exists($object, 'getAuthApis')) {
                foreach ($object->getAuthApis() as $item) {
                    \yii::$app->luya->auth->addApi($object->id, $item['api'], $item['alias']);
                }
            }
            
            if (method_exists($object, 'getAuthRoutes')) {
                foreach ($object->getAuthRoutes() as $item) {
                    \yii::$app->luya->auth->addRoute($object->id, $item['route'], $item['alias']);
                }
            }
        }
    }
}
