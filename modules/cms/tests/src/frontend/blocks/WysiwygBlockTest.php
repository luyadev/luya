<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class WysiwygBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\WysiwygBlock';

    public function testEmpty()
    {
        $this->assertSame('', $this->renderFrontendNoSpace());
    }

    public function testContent()
    {
        $this->block->setVarValues(['content' => 'content']);
        $this->assertSame('content', $this->renderFrontendNoSpace());
    }
}
