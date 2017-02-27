<?php
/**
 * LUYA YII Wrapper.
 * 
 * Thank you Yii Team!
 * 
 * @property \luya\console\Application|\luya\web\Application $app The application 
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var \luya\console\Application|\luya\web\Application the application instance
     */
    public static $app;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = require(LUYA_YII_VENDOR . '/classes.php');
Yii::$container = new yii\di\Container();