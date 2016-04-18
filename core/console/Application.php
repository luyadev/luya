<?php

namespace luya\console;

use Yii;
use yii\base\InvalidRouteException;
use yii\helpers\Console;

/**
 * Luya CLI Application.
 * 
 * @author nadar
 */
class Application extends \yii\console\Application
{
    /*
     * Use the application trait, providing shared methods and properties.
     */
    use \luya\traits\Application;

    /**
     * @var bool Mute the Applications ouput, this is used to make application
     * cli tests with no output. The `luya\console\Controller` output/print methods are listening
     * to this property.
     */
    public $mute = false;

    public $controllerMap = [
        'migrate' => '\luya\console\commands\MigrateController',
        'crud' => '\luya\console\commands\CrudController',
        'module' => '\luya\console\commands\ModuleController',
        'command' => '\luya\console\commands\CommandController',
        'import' => '\luya\console\commands\ImportController',
        'setup' => '\luya\console\commands\SetupController',
        'health' => '\luya\console\commands\HealthController',
        'block' => '\luya\console\commands\BlockController',
        'storage' => '\luya\console\commands\StorageController',
        'aw' => '\luya\console\commands\ActiveWindowController',
    ];

    /**
     * {@inheritdoc}
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
     * ./vendor/bin/luya <module>/<commandController><commandAction>
     * ```
     * 
     * Will run all controllers located in the `commands` folder of a module.
     * 
     * {@inheritDoc}
     * @see \yii\console\Application::runAction()
     * @since 1.0.0-beta6
     */
    public function runAction($route, $params = [])
    {
        try {
            return parent::runAction($route, $params);
        } catch (\Exception $e) {
            try {
                // In addition to the default behavior of runAction, the console command
                // will strip the first element of the route and threat it as a module
                // changed the controller namespace to run the commands
                $partial = explode("/", $route);
                
                // if there is a first key in the splitted array
                if (isset($partial[0])) {
                    
                    $moduleName = $partial[0];
                    $module = Yii::$app->getModule($moduleName);
                    
                    // verify if the module exists in the list of modules
                    if (!$module) {
                        throw new InvalidRouteException("Could not find Module '$moduleName', add the Module to your configuration file.");
                    }
                    
                    $module->controllerNamespace = $module->namespace . '\commands';
                    unset($partial[0]);
                    // action response
                    $response = $module->runAction(implode("/", $partial), $params);
                    
                    if (!$this->mute) {
                        return $response;
                    }
                    
                    return null;
                }
            } catch (\Exception $e) {
                return Console::ansiFormat($e->getMessage(), [Console::FG_RED]) . PHP_EOL;
            }
        }
    }
}
