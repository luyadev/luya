<?php

namespace luya\console;

use Yii;
use luya\base\BaseBootstrap;

/**
 * Luya CLI Bootsrap.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Bootstrap extends BaseBootstrap
{
    /**
     * Add missing alias names @web and @webroot.
     *
     * @param object $app Luya CLI Application Object
     *
     * @see \luya\base\BaseBootstrap::beforeRun()
     */
    public function beforeRun($app)
    {
        Yii::setAlias('@web', $app->basePath);
        Yii::setAlias('@webroot', $app->webroot);
    }

    /**
     * The run method must be implemented by defintion.
     *
     * @see \luya\base\BaseBootstrap::run()
     */
    public function run($app)
    {
        // no application behavior
    }
}
