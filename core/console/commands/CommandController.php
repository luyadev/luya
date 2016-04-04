<?php

namespace luya\console\commands;

use Yii;

/**
 * Run a LUYA command, this is a very quick implementation for console commands.
 * 
 * To run a command use the following code in your console:
 * 
 * ```
 * ./vendor/bin/luya command <module> <route>
 * ```
 * 
 * where the route is part of the controller/action as Yii2 routes concept.
 * 
 * @author nadar
 */
class CommandController extends \luya\console\Command
{
    public $verbose = false;
    
    public function options($actionID)
    {
        return ['verbose'];
    }
    
    /**
     * Run the module route
     * 
     * @param string $module The name of the module where the command is found
     * @param string $route The route based on controller/action to run inside the above provided module.
     * @return integer Exit response
     */
    public function actionIndex($module, $route = 'default')
    {
        $module = Yii::$app->getModule($module);
        
        if (!$module) {
            return $this->outputError("Module '$module' does not exist in module list, add the Module to your configuration.");
        }

        // change the namespace where the controller should be lookuped up in
        $module->controllerNamespace = $module->namespace . '\commands';
        
        // action response
        $response = $module->runAction($route, ['verbose' => $this->verbose]);

        if ($this->isMuted()) {
            return $response;
        }

        return $response;
    }

    /**
     * @todo remove in rc1
     * @return number
     */
    public function actionHelp()
    {
        return $this->outputInfo('Use ./vendor/bin/luya instead of this help aciton, will be removed in rc1');
    }
}
