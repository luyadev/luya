<?php

namespace luyatests;

use luya\base\Boot;
use luya\testsuite\cases\BaseTestSuite;

require 'vendor/autoload.php';
require 'data/env.php';

class LuyaWebTestCase extends BaseTestSuite
{
    public function getConfigArray()
    {
        return include(__DIR__ .'/data/configs/web.php');
    }

    public function bootApplication(Boot $boot)
    {
        $boot->applicationWeb();
    }
}
