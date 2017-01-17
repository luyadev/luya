<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class LayoutBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\LayoutBlock';
    
    public function testEmptyRender()
    {
        $this->assertSame('<div class="row"><div class="col-md-6"></div><div class="col-md-6"></div></div>', $this->renderFrontendNoSpace());
    }
    
    public function testWidthCol()
    {
        $this->block->setVarValues(['width' => 8]);
        $this->assertSame('<div class="row"><div class="col-md-8"></div><div class="col-md-4"></div></div>', $this->renderFrontendNoSpace());
    }
    
    public function testCssClassInput()
    {
        $this->block->setCfgValues([
            'leftColumnClasses' => 'leftclass',
            'rightColumnClasses' => 'rightclass',
            'rowDivClass' => 'rowclass',
        ]);
        $this->assertSame('<div class="row rowclass"><div class="col-md-6 leftclass"></div><div class="col-md-6 rightclass"></div></div>', $this->renderFrontendNoSpace());
    }
    
    public function testPlaceholderValues()
    {
        $this->block->setPlaceholderValues([
            'left' => 'left content',
            'right' => 'right content',
        ]);
        $this->assertSame('<div class="row"><div class="col-md-6">left content</div><div class="col-md-6">right content</div></div>', $this->renderFrontendNoSpace());
    }
}
