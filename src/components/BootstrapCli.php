<?php
namespace luya\components;

use Yii;

/**
 * @todo rename to WebBootstrap and inherite the base Bootstrap class and add the web specific bootstrap stuff (like url manager)
 * @author nadar
 *
 */
class BootstrapCli extends \luya\base\Bootstrap
{   
    public function beforeRun()
    {
        Yii::setAlias('@web', yii::$app->basePath);
        Yii::setAlias('@webroot', dirname(getcwd()));
    }
    
    public function run($app)
    {
        
    }
}
