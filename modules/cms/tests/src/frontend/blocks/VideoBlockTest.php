<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class VideoBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\VideoBlock';
    
    public function testEmpty()
    {
        $this->assertSame('', $this->renderFrontendNoSpace());
    }
    
    public function testYouTubeUrl()
    {
        $this->block->setVarValues(['url' => 'https://www.youtube.com/watch?v=sA2EdjiLSlk']);
        $this->assertSame('https://www.youtube.com/embed/sA2EdjiLSlk?rel=0', $this->block->constructUrl());
        
        $this->block->setVarValues(['url' => 'https://youtube.com/watch?v=sA2EdjiLSlk']);
        $this->assertSame('https://www.youtube.com/embed/sA2EdjiLSlk?rel=0', $this->block->constructUrl());
        
        $this->block->setVarValues(['url' => 'http://www.youtube.com/watch?v=sA2EdjiLSlk']);
        $this->assertSame('https://www.youtube.com/embed/sA2EdjiLSlk?rel=0', $this->block->constructUrl());
         
        $this->block->setVarValues(['url' => 'http://youtube.com/watch?v=sA2EdjiLSlk']);
        $this->assertSame('https://www.youtube.com/embed/sA2EdjiLSlk?rel=0', $this->block->constructUrl());
        
        
        $this->block->setVarValues(['url' => 'http://youtube.com/watch?v=sA2EdjiLSlk']);
        $this->block->setCfgValues(['controls' => 1]);
        $this->assertSame('https://www.youtube.com/embed/sA2EdjiLSlk?rel=0&controls=0', $this->block->constructUrl());
        
        $this->assertSame('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/sA2EdjiLSlk?rel=0&controls=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>', $this->renderFrontendNoSpace());
    }
    
    public function testVimeoUrl()
    {
        $this->block->setVarValues(['url' => 'https://vimeo.com/60735314']);
        $this->assertContains('https://player.vimeo.com/video/60735314', $this->block->constructUrl());
        
        $this->block->setVarValues(['url' => 'http://vimeo.com/60735314']);
        $this->assertContains('https://player.vimeo.com/video/60735314', $this->block->constructUrl());
        
        $this->block->setVarValues(['url' => 'http://vimeo.com/60735314']);
        $this->assertContains('https://player.vimeo.com/video/60735314', $this->block->constructUrl());
        
        $this->block->setVarValues(['url' => 'http://www.vimeo.com/60735314']);
        $this->assertContains('https://player.vimeo.com/video/60735314', $this->block->constructUrl());
        
        $this->assertSame('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/60735314" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>', $this->renderFrontendNoSpace());
    }
    
    public function testWidthAndControls()
    {
        $this->block->setVarValues(['url' => 'http://youtube.com/watch?v=sA2EdjiLSlk']);
        $this->block->setCfgValues(['controls' => 1, 'width' => 600]);
        $this->assertSame('https://www.youtube.com/embed/sA2EdjiLSlk?rel=0&controls=0', $this->block->constructUrl());
         
        $this->assertSame('<div style="width:600px"><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/sA2EdjiLSlk?rel=0&controls=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div></div>', $this->renderFrontendNoSpace());
    }
}
