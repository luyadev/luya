<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class QuoteBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\QuoteBlock';
    
    public function testEmptyRender()
    {
        $this->assertSame('', $this->renderFrontendNoSpace());
    }
    
    public function testcContentRender()
    {
        $this->block->setVarValues(['content' => 'quote text!']);
        $this->assertSame('<blockquote>quote text!</blockquote>', $this->renderFrontendNoSpace());
    }
}
