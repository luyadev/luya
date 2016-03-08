<?php

namespace tests\core;

use luya\Boot;

class BootTest extends \tests\LuyaWebTestCase
{
    public function testBaseObject()
    {
        $boot = new Boot();
        $this->assertEquals('cli', $boot->getSapiName());
    }
}
