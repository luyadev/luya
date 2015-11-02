<?php

namespace tests\web\luya;

use luya\Boot;

class BootTest extends \tests\web\Base
{
    public function testBaseObject()
    {
        $boot = new Boot();
        $this->assertEquals('cli', $boot->getSapiName());
    }
}
