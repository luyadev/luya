<?php

namespace luya\console;

use Yii;
use yii\helpers\Console;
use yii\base\ExitException;

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
        //return Console::ansiFormat('[LUYA:]'.$e->getMessage(), [Console::FG_RED]) . PHP_EOL;
        // In addition to the default behavior of runAction, the console command
        // will strip the first element of the route and threat it as a module
        // changed the controller namespace to run the commands
        if (!empty($route)) {
	        $partial = explode("/", $route);
	        // if there is a first key in the splitted array
	        if (isset($partial[0]) && (count($partial) > 1) && ($module = Yii::$app->getModule($partial[0]))) {
	            // change the controller namespace of this module to make usage of `commands`.
	            $module->controllerNamespace = $module->namespace . '\commands';
	            unset($partial[0]);
	            // action response
	            try {
	            	return $module->runAction(implode("/", $partial), $params);
	            } catch (\Exception $e) {
	            	throw new ExitException("[LUYA]" . $e->getMessage());
	            }
	        }
        }
        return parent::runAction($route, $params);
    }
}
