<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class SpacingBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\SpacingBlock';
    
    public function testEmptyRender()
    {
        $this->assertSame('<p class="spacing-block spacing-block--1"><br></p>', $this->renderFrontendNoSpace());
    }

    public function testSetSpace1()
    {
        $this->block->setVarValues(['spacing' => 1]);
        $this->assertSame('<p class="spacing-block spacing-block--1"><br></p>', $this->renderFrontendNoSpace());
    }
    
    public function testSetSpace2()
    {
        $this->block->setVarValues(['spacing' => 2]);
        $this->assertSame('<p class="spacing-block spacing-block--2"><br><br></p>', $this->renderFrontendNoSpace());
    }
    
    public function testSetSpace3()
    {
        $this->block->setVarValues(['spacing' => 3]);
        $this->assertSame('<p class="spacing-block spacing-block--3"><br><br><br></p>', $this->renderFrontendNoSpace());
    }
}
