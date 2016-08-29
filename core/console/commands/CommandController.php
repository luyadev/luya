<?php

namespace luya\console\commands;

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
 * @todo remove/delete in beta7
 * @author nadar
 */
class CommandController extends \luya\console\Command
{
    /**
     * Run the module route
     *
     * @param string $module The name of the module where the command is found
     * @param string $route The route based on controller/action to run inside the above provided module.
     * @return integer Exit response
     */
    public function actionIndex($module, $route = 'default')
    {
        echo $this->outputInfo("This method is deprecated since 1.0.0-beta6");
        
        return $this->outputError("Instead us: ./vendor/bin/luya {$module}/{$route}");
    }

    /**
     * Display all commands
     *
     * @todo remove/delete in rc1
     * @return number
     */
    public function actionHelp()
    {
        return $this->outputInfo('Use ./vendor/bin/luya instead. This action will be deleted soon.');
    }
}
