<?php

namespace luya\commands;

use Yii;

/**
 * @author nadar
 */
class CommandController extends \luya\base\Command
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

        if ($response) {
            exit(0);
        }

        exit(1);
    }
}
