<?php

namespace cmstests\src\helpers;

use cmstests\CmsFrontendTestCase;
use luya\cms\helpers\Url;

class UrlTest extends CmsFrontendTestCase
{
    public function testToModule()
    {
        $this->assertSame('foobar', Url::toModule('foobar'));
    }
    
    public function testToModuleRoute()
    {
        $this->expectException('luya\cms\Exception');
        Url::toModuleRoute('foobar', ['/module/controller/action']);
    }

    public function testToMenuItem()
    {
        $this->assertContains('en/module/controller/action', Url::toMenuItem(1, ['/module/controller/action']));
    }
}
