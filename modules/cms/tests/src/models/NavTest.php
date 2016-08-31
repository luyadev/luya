<?php

namespace tests\web\cmsadmin\models;

use cmstests\CmsFrontendTestCase;
use luya\cms\models\Nav;

class NavTest extends CmsFrontendTestCase
{
    public function testFindContent()
    {
        $nav = Nav::findOne(1);
        
        /* @var $item \luya\cms\models\NavItem */
        $item = $nav->activeLanguageItem;

        $this->assertSame('Homepage', $item->title);
        $this->assertSame('homepage', $item->alias);
    }
}
