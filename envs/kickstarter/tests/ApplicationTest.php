<?php

namespace app\tests;

use luya\testsuite\cases\ServerTestCase;

class ApplicationTest extends ServerTestCase
{
    public function getConfigArray()
    {
        return [
            'id' => 'myapp',
            'basePath' => dirname(__DIR__),
        ];
    }

    public function testSites()
    {
        $this->assertUrlHomepageIsOk();
    }
}
