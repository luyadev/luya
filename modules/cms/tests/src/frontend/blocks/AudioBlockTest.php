<?php

namespace cmstests\src\frontend\blocks;

use luya\cms\frontend\blocks\AudioBlock;
use cmstests\BlockTestCase;

class AudioBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\AudioBlock';
    
    public function testEmpty()
    {
        $this->assertSame('', $this->block->renderFrontend());
    }
    
    public function testContent()
    {
        $this->block->setVarValues(['soundUrl' => 'embed']);
        $this->assertContains('<div>embed</div>', $this->block->renderFrontend());
    }
}
