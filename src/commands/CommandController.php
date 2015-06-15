<?php

namespace luya\commands;

use Yii;

/**
 * @author nadar
 */
class CommandController extends \yii\console\Controller
{
    public function actionIndex($module, $route = 'default')
    {
        $moduleObject = Yii::$app->getModule($module);
        if (!$moduleObject) {
            echo "The module '$module' does not exist.";
            exit(0);
        }
        $moduleObject->controllerNamespace = $module .'\commands';
        echo $moduleObject->runAction($route);
        echo PHP_EOL;
    }
}
