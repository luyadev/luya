<?php

namespace cmstests\src\frontend\blocks;

use cmstests\CmsFrontendTestCase;
use luya\cms\frontend\blocks\DevBlock;

class DevBlockTest extends CmsFrontendTestCase
{
	public function testRenderFrontend()
	{
		$block = new DevBlock();
		$this->assertNotEmpty($block->renderFrontend());
	}
}