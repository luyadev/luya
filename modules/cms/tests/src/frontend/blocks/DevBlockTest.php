<?php

namespace cmstests\src\frontend\blocks;

use luya\cms\frontend\blocks\DevBlock;
use cmstests\BlockTestCase;

class DevBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\DevBlock';
    
    public function testRenderFrontend()
    {
        $this->assertNotEmpty($this->renderFrontend());
    }
}
