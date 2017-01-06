<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class HtmlBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\HtmlBlock';

    public function testRenderFrontend()
    {
        $this->assertEquals('', $this->renderFrontend());
    }
    
    public function testInputHtml()
    {
        $this->block->setVarValues([
            'html' => '<div class="foo">Hello World</div>',
        ]);
        
        $this->assertSame('<div class="foo">Hello World</div>', $this->renderFrontendNoSpace());
    }
}
