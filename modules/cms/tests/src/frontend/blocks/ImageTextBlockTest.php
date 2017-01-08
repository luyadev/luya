<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class ImageTextBlockTest extends BlockTestCase
{
	public $blockClass = 'luya\cms\frontend\blocks\ImageTextBlock';
	
	public function testEmpty()
	{
		$this->assertSame('', $this->renderFrontend());
	}
	
	public function testImageSource()
	{
		$this->block->setVarValues(['text' => 'Text']);
		$this->block->addExtraVar('imageSource', 'image.jpg');
		
		$this->assertSame('<div><img class="pull-left img-responsive" src="image.jpg" style="margin-right:20px;margin-bottom:20px; max-width: 50%;"><div><p>Text</p></div></div><div style="clear:both"></div>', $this->renderFrontendNoSpace());
	}
	
	
	public function testButton()
	{
		$this->block->setVarValues(['text' => 'Text']);
		$this->block->setCfgValues(['btnHref' => 'https://luya.io', 'btnLabel' => 'Button']);
		$this->block->addExtraVar('imageSource', 'image.jpg');
	
		$this->assertSame('<div><img class="pull-left img-responsive" src="image.jpg" style="margin-right:20px;margin-bottom:20px; max-width: 50%;"><div><p>Text</p><br><a class="button" href="https://luya.io">Button</a></div></div><div style="clear:both"></div>', $this->renderFrontendNoSpace());
	}
}