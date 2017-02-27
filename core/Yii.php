<?php

/**
 * LUYA YII Wrapper.
 * 
 * It extends from [[\yii\BaseYii]] which provides the actual implementation. 
 *
 * This is the Yii.php wrapper file in order to provide luya specific application IDE auto complet.
 * 
 * @property \luya\console\Application|\luya\web\Application $app The application 
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var \luya\console\Application|\luya\web\Application Luya Application instance.
     */
    public static $app;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = require(LUYA_YII_VENDOR . '/classes.php');
Yii::$container = new yii\di\Container();