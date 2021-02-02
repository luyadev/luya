<?php

namespace luyatests\core;

use luyatests\LuyaWebTestCase;
use luya\base\Widget;

class WidgetTest extends LuyaWebTestCase
{
    public function testOriginalViewPath()
    {
        $this->assertStringContainsString('core/base/views', (new Widget())->getViewPath());
    }
    
    public function testUseAppViewsPath()
    {
        $this->assertStringContainsString('@app/views/widgets', (new Widget(['useAppViewPath' => true]))->getViewPath());
    }
}
