<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Console;
use luya\helpers\FileHelper;

/**
 * Command to create LUYA modules.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ModuleController extends \luya\console\Command
{
    /**
     * Create a new frontend/admin module.
     *
     * @return number
     */
    public function actionCreate()
    {
        Console::clearScreenBeforeCursor();
        
        $moduleName = $this->prompt("Enter the name of the module you like to generate:");

        $newName = preg_replace("/[^a-z]/", "", strtolower($moduleName));
        
        if ($newName !== $moduleName) {
            if (!$this->confirm("We have changed the name to '{$newName}'. Do you want to proceed with this name?")) {
                return $this->outputError('Abort by user.');
            } else {
                $moduleName = $newName;
            }
        }
        
        $appModulesFolder = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'modules';
        $moduleFolder = $appModulesFolder . DIRECTORY_SEPARATOR . $moduleName;
        
        if (file_exists($moduleFolder)) {
            return $this->outputError("The folder " . $moduleFolder . " exists already.");
        }
        
        $folders = [
            'basePath' => $moduleFolder,
            'adminPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'admin',
            'frontendPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'frontend',
            'blocksPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'blocks',
            'blocksPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'controllers',
            'blocksPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'views',
            'modelsPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'models',
        ];

        $vars = ['folders' => $folders, 'name' => $moduleName, 'ns' => 'app\\modules\\'.$moduleName];
        
        foreach ($folders as $folder) {
            FileHelper::createDirectory($folder);
        }
        
        $contents = [
            $moduleFolder. DIRECTORY_SEPARATOR . 'README.md' => $this->view->render('@luya/console/commands/views/module/readme.php', $vars),
            $moduleFolder. DIRECTORY_SEPARATOR . 'admin/Module.php' => $this->view->render('@luya/console/commands/views/module/adminmodule.php', $vars),
            $moduleFolder. DIRECTORY_SEPARATOR . 'frontend/Module.php' => $this->view->render('@luya/console/commands/views/module/frontendmodule.php', $vars),
        ];
        
        foreach ($contents as $fileName => $content) {
            FileHelper::writeFile($fileName, $content);
        }
        
        return $this->outputSuccess("Module files has been created successfull. Check the README file to understand how to added the module to your config.");
    }
}
