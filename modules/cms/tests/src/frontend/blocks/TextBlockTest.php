<?php

namespace cmstests\src\frontend\blocks;

use cmstests\CmsFrontendTestCase;
use luya\cms\frontend\blocks\TextBlock;

class TextBlockTest extends CmsFrontendTestCase
{
	public function testRenderFrontend()
	{
		$block = new TextBlock();
		$block->setVarValues(['content' => 'text']);
		$this->assertContains('<p>text</p>', $block->renderFrontend());
		
		$block = new TextBlock();
		$block->setVarValues(['content' => 'text
test']);
		$this->assertContains('<p>text<br />
test</p>', $block->renderFrontend());
		
		$block = new TextBlock();
		$block->setVarValues(['content' => '##text', 'textType' => 0]);
		$this->assertContains('<p>##text</p>', $block->renderFrontend());
		
		$block = new TextBlock();
		$block->setVarValues(['content' => '##text', 'textType' => 1]);
		$this->assertContains('<h2>text</h2>', trim($block->renderFrontend()));
		
		// cfgs
		$block = new TextBlock();
		$block->setVarValues(['content' => 'text']);
		$block->setCfgValues(['cssClass' => 'test']);
		$this->assertContains('<p class="test">text</p>', $block->renderFrontend());
		
		$block = new TextBlock();
		$block->setVarValues(['content' => '##text', 'textType' => 0]);
		$block->setCfgValues(['cssClass' => 'test']);
		$this->assertContains('<p class="test">##text</p>', $block->renderFrontend());
		
		$block = new TextBlock();
		$block->setVarValues(['content' => '##text', 'textType' => 1]);
		$block->setCfgValues(['cssClass' => 'test']);
		$this->assertContains('<h2>text</h2>', trim($block->renderFrontend()));
	}
}