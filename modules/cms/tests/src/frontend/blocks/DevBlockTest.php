<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class DevBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\DevBlock';
    
    public function testRenderFrontend()
    {
        $this->assertNotEmpty($this->renderFrontend());
    }
}
