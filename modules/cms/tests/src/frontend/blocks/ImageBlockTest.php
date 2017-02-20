<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;
use luya\cms\frontend\blocks\ImageBlock;

class ImageBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\ImageBlock';
    
    public function testRenderEmpty()
    {
        $this->assertSame('', $this->renderFrontend());
    }
    
    public function testImageId()
    {
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image"><figure><img class="img-responsive" src="luya.jpg" alt=""></figure></div>', $this->renderFrontendNoSpace());
    }
    
    public function testCaption()
    {
        $this->block->setVarValues(['caption' => 'cap']);
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image"><figure><img class="img-responsive" src="luya.jpg" alt="cap" title="cap"><figcaption><p>cap</p></figcaption></figure></div>', $this->renderFrontendNoSpace());
    }
    
    public function testNewlineCaption()
    {
        $this->block->setVarValues(['caption' => "cap
    	tion"]); // using \n or \r does not work within this context.
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image"><figure><img class="img-responsive" src="luya.jpg" alt="cap tion" title="cap tion"><figcaption><p>cap<br />tion</p></figcaption></figure></div>', $this->renderFrontendNoSpace());
    }
    
    public function testMarkdownCaption()
    {
        $this->block->setVarValues(['caption' => '##cap', 'textType' => 1]);
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image"><figure><img class="img-responsive" src="luya.jpg" alt="##cap" title="##cap"><figcaption><h2>cap</h2></figcaption></figure></div>', $this->renderFrontendNoSpace());
    }
    
    public function testWidthHeight()
    {
        $this->block->setCfgValues(['width' => 100, 'height' => 100]);
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image"><figure><img class="img-responsive" src="luya.jpg" width="100" height="100" alt=""></figure></div>', $this->renderFrontendNoSpace());
    }
    
    public function testInternalLink()
    {
        $this->block->setCfgValues(['internalLink' => 1]);
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image"><figure><a class="text-teaser" href="/luya/envs/dev/public_html/" target="_self"><img class="img-responsive" src="luya.jpg" alt=""></a></figure></div>', $this->renderFrontendNoSpace());
    }
    
    public function testExternalLink()
    {
        $this->block->setCfgValues(['externalLink' => 'https://luya.io']);
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image"><figure><a class="text-teaser" href="https://luya.io" target="_blank"><img class="img-responsive" src="luya.jpg" alt=""></a></figure></div>', $this->renderFrontendNoSpace());
    }
    
    public function testLinkPriority()
    {
        $this->block->setCfgValues(['externalLink' => 'https://luya.io', 'internalLink' => 1]);
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image"><figure><a class="text-teaser" href="https://luya.io" target="_blank"><img class="img-responsive" src="luya.jpg" alt=""></a></figure></div>', $this->renderFrontendNoSpace());
    }
    
    public function testDivClassClass()
    {
        $this->block->setCfgValues(['divCssClass' => 'foobar']);
        $this->block->addExtraVar('image', ['source' => 'luya.jpg']);
        $this->assertSame('<div class="image foobar"><figure><img class="img-responsive" src="luya.jpg" alt=""></figure></div>', $this->renderFrontendNoSpace());
    }
}
