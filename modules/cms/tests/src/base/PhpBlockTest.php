<?php

namespace cmstests\src\blocks;

use cmstests\CmsFrontendTestCase;
use cmstests\data\blocks\PhpTestBlock;

class PhpBlockTest extends CmsFrontendTestCase
{
    public function testAdminResponse()
    {
        $block = new PhpTestBlock();
        return $this->assertSame('admin', $block->renderAdmin());
    }
    
    public function testFrontendResponse()
    {
        $block = new PhpTestBlock();
        return $this->assertSame('frontend', $block->renderFrontend());
    }
}