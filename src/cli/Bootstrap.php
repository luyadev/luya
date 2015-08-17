<?php

namespace luya\cli;

use Yii;

/**
 * @todo rename to WebBootstrap and inherite the base Bootstrap class and add the web specific bootstrap stuff (like url manager)
 *
 * @author nadar
 */
class Bootstrap extends \luya\base\Bootstrap
{
    public function beforeRun($app)
    {
        Yii::setAlias('@web', $app->basePath);
        Yii::setAlias('@webroot', dirname(getcwd()));
    }

    public function run($app)
    {
        // empty
    }
}
