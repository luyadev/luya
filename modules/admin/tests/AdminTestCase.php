<?php

namespace admintests;

use luyatests\LuyaWebTestCase;

require 'vendor/autoload.php';

class AdminTestCase extends LuyaWebTestCase
{
    public function getConfigFile()
    {
        return __DIR__ . '/data/configs/admin.php';
    }
}
