<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Console;
use luya\helpers\FileHelper;
use yii\helpers\Inflector;

/**
 * Command to create a new LUYA Module.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ModuleController extends \luya\console\Command
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';
    
    /**
     * Humanize the class name
     *
     * @return string The humanized name.
     */
    public function humanizeName($name)
    {
        return $name = Inflector::humanize(Inflector::camel2words($name));
    }
    
    /**
     * Render the readme template.
     *
     * @param array $folders
     * @param string $name
     * @param string $ns
     * @return string
     */
    public function renderReadme($folders, $name, $ns)
    {
        return $this->view->render('@luya/console/commands/views/module/readme.php', [
            'folders' => $folders,
            'name' => $name,
            'humanName' => $this->humanizeName($name),
            'ns' => $ns,
            'luyaText' => $this->getGeneratorText('module/create'),
        ]);
    }
    
    /**
     * Render the admin template.
     *
     * @param array $folders
     * @param string $name
     * @param string $ns
     * @return string
     */
    public function renderAdmin($folders, $name, $ns)
    {
        return $this->view->render('@luya/console/commands/views/module/adminmodule.php', [
            'folders' => $folders,
            'name' => $this->humanizeName($name),
            'ns' => $ns,
            'luyaText' => $this->getGeneratorText('module/create'),
        ]);
    }
    
    /**
     * Render the frontend template.
     *
     * @param array $folders
     * @param string $name
     * @param string $ns
     * @return string
     */
    public function renderFrontend($folders, $name, $ns)
    {
        return $this->view->render('@luya/console/commands/views/module/frontendmodule.php', [
            'folders' => $folders,
            'name' => $this->humanizeName($name),
            'ns' => $ns,
            'luyaText' => $this->getGeneratorText('module/create'),
        ]);
    }
    
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
            'adminAwsPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'aws',
            'adminMigrationPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'migrations',
            'frontendPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'frontend',
            'frontendBlocksPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'blocks',
            'frontendControllersPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'controllers',
            'frontendViewsPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'views',
            'modelsPath' => $moduleFolder . DIRECTORY_SEPARATOR . 'models',
        ];

        $ns = 'app\\modules\\'.$moduleName;
        
        foreach ($folders as $folder) {
            FileHelper::createDirectory($folder);
        }
        
        $contents = [
            $moduleFolder. DIRECTORY_SEPARATOR . 'README.md' => $this->renderReadme($folders, $moduleName, $ns),
            $moduleFolder. DIRECTORY_SEPARATOR . 'admin/Module.php' => $this->renderAdmin($folders, $moduleName, $ns),
            $moduleFolder. DIRECTORY_SEPARATOR . 'frontend/Module.php' => $this->renderFrontend($folders, $moduleName, $ns),
        ];
        
        foreach ($contents as $fileName => $content) {
            FileHelper::writeFile($fileName, $content);
        }
        
        return $this->outputSuccess("Module files has been created successfull. Check the README file to understand how to added the module to your config.");
    }
}
