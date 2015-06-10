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
        $moduleObject->controllerNamespace = $module .'\commands';
        echo $moduleObject->runAction($route);
        echo PHP_EOL;
    }
}
