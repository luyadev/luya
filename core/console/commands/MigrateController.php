<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Console;
use luya\helpers\FileHelper;
use yii\console\Exception;

/**
 * Database Migration Too.
 *
 * This extends the original yii migration tool by the ability to specify a module name within the create section.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        foreach (Yii::$app->modules as $key => $item) {
            $module = Yii::$app->getModule($key);
            $this->migrationPath[$key] = $module->getBasePath().DIRECTORY_SEPARATOR.'migrations';
        }
    }
    
    /**
     * @inheritDoc
     *
     * @see https://github.com/yiisoft/yii2/issues/384
     * @see \yii\console\controllers\BaseMigrateController::actionCreate()
     */
    public function actionCreate($name, $module = false)
    {
        if (empty($module)) {
            return parent::actionCreate($name);
        }
        
        if (!isset($this->migrationPath[$module])) {
            throw new Exception("The module \"$module\" does not exist in the application modules configuration.");
        }
        
        // apply custom migration code to generate new migrations for a module specific path
        if (!preg_match('/^[\w\\\\]+$/', $name)) {
            throw new Exception('The migration name should contain letters, digits, underscore and/or backslash characters only.');
        }
        
        $className = 'm'.gmdate('ymd_His').'_'.$name;
        
       
        $migrationPath = $this->migrationPath[$module];
        
        $file = $migrationPath . DIRECTORY_SEPARATOR . $className . '.php';
        if ($this->confirm("Create new migration '$file'?")) {
            $content = $this->generateMigrationSourceCode([
                'name' => $name,
                'className' => $className,
                'namespace' => null,
            ]);
            FileHelper::createDirectory($migrationPath);
            file_put_contents($file, $content);
            $this->stdout("New migration created successfully.\n", Console::FG_GREEN);
        }
    }
}
