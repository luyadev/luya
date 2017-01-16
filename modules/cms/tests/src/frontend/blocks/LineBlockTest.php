<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class LineBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\LineBlock';
    
    public function testEmptyRender()
    {
        $this->assertSame('<hr style="border:0; border-bottom:1px solid #ccc;" />', $this->renderFrontendNoSpace());
    }
    
    public function testVars()
    {
        $this->block->setVarValues([
            'lineSpace' => '10px',
            'lineStyle' => 'dotted',
            'lineWidth' => '3px',
            'lineColor' => '#000',
        ]);
        
        $this->assertSame('<hr style="border:0; border-bottom:3px dotted #000; margin:10px 0px;" />', $this->renderFrontendNoSpace());
    }
}
