<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Console;
use luya\helpers\FileHelper;
use yii\console\Exception;

/**
 * Extended Yii2 Migration-Tool to run Database migrations.
 *
 * @see https://github.com/yiisoft/yii2/issues/384
 * @author nadar
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @var array Directory where the migrations should be looked up
     */
    public $migrationFileDirs = array();

    /**
     * @var array Module migration directories
     */
    public $moduleMigrationDirectories = array();

    /**
     * initModuleMigrationDirectories beforing runing the action.
     *
     * @see \yii\console\controllers\MigrateController::beforeAction()
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->initModuleMigrationDirectories();

            return true;
        } else {
            return false;
        }
    }

    private function initModuleMigrationDirectories()
    {
        foreach (Yii::$app->modules as $key => $item) {
            $module = Yii::$app->getModule($key);
            $this->moduleMigrationDirectories[$key] = $module->getBasePath().DIRECTORY_SEPARATOR.'migrations';
        }
    }

    private function getModuleMigrationDirectorie($module)
    {
        if (!array_key_exists($module, $this->moduleMigrationDirectories)) {
            return false;
        }

        return $this->moduleMigrationDirectories[$module];
    }

    /**
     * Create a migration based on its class name.
     *
     * @see \yii\console\controllers\MigrateController::createMigration()
     */
    protected function createMigration($class)
    {
        $orig = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
        
        if (file_exists($orig)) {
            require_once $orig;
            return new $class();
        } else {
            if (isset($this->migrationFileDirs[$class])) {
                $file = $this->migrationFileDirs[$class].DIRECTORY_SEPARATOR.$class.'.php';
                if (file_exists($file)) {
                    require_once $file;
                    return new $class();
                }
            }
        }
        
        
        $module = $this->prompt("Could not find migration class. Please enter the module name who belongs to '$class.':");
        $dir = $this->getModuleMigrationDirectorie($module);
        $file = $dir . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return new $class();
        }
        
        throw new Exception("Unable to find migration for provided module $file.");
    }

    /**
     * Create new migration, first param the name, second param the module where the migration should be put in.
     *
     * @param string $name The name of the migration
     * @param string|boolean $module The module name where the migration should be placed in.
     * @todo replace module param with user teminal selection.
     * @see \yii\console\controllers\BaseMigrateController::actionCreate()
     */
    public function actionCreate($name, $module = false)
    {
        if (!preg_match('/^\w+$/', $name)) {
            throw new Exception('The migration name should contain letters, digits and/or underscore characters only.');
        }

        $name = 'm'.gmdate('ymd_His').'_'.$name;
        $folder = false;
        
        if (!$module) {
            $file = $this->migrationPath.DIRECTORY_SEPARATOR.$name.'.php';
        } else {
            if (($folder = $this->getModuleMigrationDirectorie($module)) === false) {
                $this->stdout("\nModule '$module' does not exist.\n", Console::FG_RED);

                return self::EXIT_CODE_ERROR;
            }
            $file = $folder.DIRECTORY_SEPARATOR.$name.'.php';
        }

        if ($this->confirm("Create new migration '$file'?")) {
            $content = $this->renderFile(Yii::getAlias($this->templateFile), ['className' => $name]);
            
            if ($folder !== false && !file_exists($folder)) {
                FileHelper::createDirectory($folder, 0775, false);
            }
            
            file_put_contents($file, $content);
            $this->stdout("\nMigration created successfully.\n", Console::FG_GREEN);

            return self::EXIT_CODE_NORMAL;
        }
    }

    /**
     * Returns the migrations that are not applied.
     *
     * @return array list of new migrations
     */
    protected function getNewMigrations()
    {
        $applied = [];

        foreach ($this->getMigrationHistory(null) as $version => $time) {
            $applied[substr($version, 1, 13)] = true;
        }

        $moduleMigrationDirs = array();

        if (count($this->moduleMigrationDirectories) > 0) {
            foreach ($this->moduleMigrationDirectories as $name => $dir) {
                $moduleMigrationDirs[] = $dir;
            }
        }

        $moduleMigrationDirs[] = $this->migrationPath;

        $migrations = [];

        foreach ($moduleMigrationDirs as $moduleMigrationPath) {
            if (!file_exists($moduleMigrationPath)) {
                continue;
            }

            $handle = opendir($moduleMigrationPath);

            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && is_file($moduleMigrationPath.DIRECTORY_SEPARATOR.$file) && !isset($applied[$matches[2]])) {
                    $migrations[] = $matches[1];
                    $this->migrationFileDirs[$matches[1]] = $moduleMigrationPath;
                }
            }

            closedir($handle);
        }

        sort($migrations);

        return $migrations;
    }
}
