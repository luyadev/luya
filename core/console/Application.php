<?php

namespace luya\console;

use Yii;
use yii\helpers\Console;
use yii\console\Exception;
use luya\traits\ApplicationTrait;

/**
 * Console/CLI Application.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Application extends \yii\console\Application
{
    use ApplicationTrait;

    /**
     * @var bool Mute the Applications ouput, this is used to make application
     * cli tests with no output. The `luya\console\Controller` output/print methods are listening
     * to this property.
     */
    public $mute = false;

    /**
     * Provides an array with all LUYA core commands.
     *
     * Instead of overriding the core command application and merged the value we directly copied them.
     *
     * @see \yii\console\Application::coreCommands()
     */
    public function coreCommands()
    {
        return [
            // yii default commands
            'asset' => 'yii\console\controllers\AssetController',
            'cache' => 'yii\console\controllers\CacheController',
            'fixture' => 'yii\console\controllers\FixtureController',
            'help' => 'yii\console\controllers\HelpController',
            'message' => 'yii\console\controllers\MessageController',
            'serve' => 'yii\console\controllers\ServeController',
            // luya default commands
            'migrate' => 'luya\console\commands\MigrateController',
            'crud' => 'luya\console\commands\CrudController',
            'module' => 'luya\console\commands\ModuleController',
            'import' => 'luya\console\commands\ImportController',
            'health' => 'luya\console\commands\HealthController',
            'block' => 'luya\console\commands\BlockController',
            'aw' => 'luya\console\commands\ActiveWindowController',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function coreComponents()
    {
        return array_merge($this->luyaCoreComponents(), [
            'errorHandler' => ['class' => 'luya\console\ErrorHandler'],
        ]);
    }

    /**
     * In addition to the default behavior of runAction, the console command
     * will strip the first element of the route and threat it as a module
     * changed the controller namespace to run the commands.
     *
     * ```
     * ./vendor/bin/luya <module>/<commandController>/<commandAction>
     * ```
     *
     * Will run all controllers located in the `commands` folder of a module.
     *
     * {@inheritDoc}
     *
     * @see \yii\console\Application::runAction()
     * @since 1.0.0-beta6
     */
    public function runAction($route, $params = [])
    {
        // In addition to the default behavior of runAction, the console command
        // will strip the first element of the route and threat it as a module
        // changed the controller namespace to run the commands
        if (!empty($route)) {
            $partial = explode("/", $route);
            // if there is a first key in the splitted array
            if (isset($partial[0]) && (count($partial) > 1) && ($module = Yii::$app->getModule($partial[0]))) {
                try {
                    // change the controller namespace of this module to make usage of `commands`.
                    $module->controllerNamespace = $module->namespace . '\commands';
                    unset($partial[0]);
                    // action response
                    return $module->runAction(implode("/", $partial), $params);
                } catch (\Exception $e) {
                    throw new Exception("Exception in route \"$route\": \"{$e->getMessage()}\" in file \"{$e->getFile()}\" on line {$e->getLine()}.", 0, $e);
                }
            }
        }
        // call parent action
        return parent::runAction($route, $params);
    }
}
