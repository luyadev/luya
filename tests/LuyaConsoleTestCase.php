<?php

namespace luyatests;

use luya\testsuite\cases\ConsoleApplicationTestCase;

require 'vendor/autoload.php';
require 'data/env.php';

class LuyaConsoleTestCase extends ConsoleApplicationTestCase
{
    public function getConfigArray()
    {
        return include(__DIR__ .'/data/configs/console.php');
    }
}
