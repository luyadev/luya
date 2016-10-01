<?php

namespace cmstests\src\blocks;

use cmstests\CmsFrontendTestCase;
use luya\cms\frontend\blocks\ImageBlock;

class ImageBlockTest extends CmsFrontendTestCase
{
    public function testRender()
    {
        $block = new ImageBlock();
        $this->assertSame('', $block->renderFrontend());
    }
}
