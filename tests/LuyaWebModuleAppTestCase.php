<?php

namespace luyatests;

use luya\base\Boot;
use luya\testsuite\cases\BaseTestSuite;

require 'vendor/autoload.php';
require 'data/env.php';

class LuyaWebModuleAppTestCase extends BaseTestSuite
{
    public function getConfigArray()
    {
        return include(__DIR__ .'/data/configs/webmoduleapp.php');
    }

    public function bootApplication(Boot $boot)
    {
        $boot->applicationWeb();
    }
}
