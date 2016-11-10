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
    
    public function testExtraVarsGetter()
    {
        $block = new PhpTestBlock();
        $this->assertArrayHasKey('foo', $block->extraVars());
    }
    
    public function testExtraVarsValueGetter()
    {
        $block = new PhpTestBlock();
        $this->assertSame('bar', $block->getExtraValue('foo'));
    }
    
    public function textExtraVarValuesGetter()
    {
        $block = new PhpTestBlock();
        $this->assertArrayHasKey('foo', $block->getExtraVarValues());
    }
}
