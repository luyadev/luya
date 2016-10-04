<?php

namespace luya\console;

use Yii;

/**
 * Luya CLI Bootsrap.
 *
 * @author nadar
 */
class Bootstrap extends \luya\base\Bootstrap
{
    /**
     * Add missing alias names @web and @webroot.
     *
     * @param object $app Luya CLI Application Object
     *
     * @see \luya\base\Bootstrap::beforeRun()
     */
    public function beforeRun($app)
    {
        Yii::setAlias('@web', $app->basePath);
        Yii::setAlias('@webroot', $app->webroot);
    }

    /**
     * The run method must be implemented by defintion.
     *
     * @see \luya\base\Bootstrap::run()
     */
    public function run($app)
    {
        // no application behavior
    }
}
