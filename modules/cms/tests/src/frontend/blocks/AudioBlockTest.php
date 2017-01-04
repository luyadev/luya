<?php

namespace cmstests\src\frontend\blocks;

use cmstests\CmsFrontendTestCase;
use luya\cms\frontend\blocks\AudioBlock;

class AudioBlockTest extends CmsFrontendTestCase
{
	public function testRenderFrontend()
	{
		$block = new AudioBlock();
		//$block->setVarValues(['soundUrl' => 'text']);
		$this->assertSame('', $block->renderFrontend());
		
		$block = new AudioBlock();
		$block->setVarValues(['soundUrl' => 'embed']);
		$this->assertContains('<div>embed</div>', $block->renderFrontend());
	}
}