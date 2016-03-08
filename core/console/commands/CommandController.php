<?php

namespace luya\console\commands;

use Yii;

/**
 * @author nadar
 */
class CommandController extends \luya\console\Command
{
    public function actionIndex($module, $route = 'default')
    {
        $moduleObject = Yii::$app->getModule($module);
        if (!$moduleObject) {
            return $this->outputError("Module '$module' does not exist in module list, add the Module to your configuration.");
        }

        $ns = $moduleObject->getNamespace();

        $moduleObject->controllerNamespace = $ns.'\commands';

        $response = $moduleObject->runAction($route);

        if ($this->isMuted()) {
            return $response;
        }

        return $response;
    }

    public function actionHelp()
    {
        $this->output('Luya Help Guide');
        $this->output('- import');
        $this->output('- setup');
        $this->output('- setup/user');
        $this->output('- migrate');
        $this->output('- migrate/create');
        $this->output('- crud/create');
        $this->output('- module/create');
        $this->output('- block/create');
        $this->output('- health');
        $this->output('- storage/cleanup');

        return 0;
    }
}
