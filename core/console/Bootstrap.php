<?php

namespace luya\console;

use Yii;
use luya\base\BaseBootstrap;
use luya\helpers\FileHelper;
use yii\helpers\Inflector;

/**
 * Luya CLI Bootsrap.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Bootstrap extends BaseBootstrap
{
    /**
     * Add missing alias names @web and @webroot.
     *
     * @param object $app Luya CLI Application Object
     *
     * @see \luya\base\BaseBootstrap::beforeRun()
     */
    public function beforeRun($app)
    {
        Yii::setAlias('@web', $app->basePath);
        Yii::setAlias('@webroot', $app->webroot);
    }

    /**
     * The run method must be implemented by defintion.
     *
     * @see \luya\base\BaseBootstrap::run()
     */
    public function run($app)
    {
        foreach ($app->getApplicationModules() as $id => $module) {
            $folder = $module->basePath . DIRECTORY_SEPARATOR . 'commands';
            if (file_exists($folder) && is_dir($folder)) {
                foreach (FileHelper::findFiles($folder) as $file) {
                    $module->controllerNamespace = $module->namespace . '\commands';
                    
                    $className = '\\'.$module->getNamespace().'\\commands\\' . pathinfo($file, PATHINFO_FILENAME);

                    $command = str_replace('-controller', '', $module->id . '/' . Inflector::camel2id(pathinfo($file, PATHINFO_FILENAME)));
                    
                    Yii::$app->controllerMap[$command] = ['class' => $className];
                }
            }
        }
    }
}
