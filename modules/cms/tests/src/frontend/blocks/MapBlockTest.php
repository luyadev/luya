<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class MapBlockTest extends BlockTestCase
{
	public $blockClass = 'luya\cms\frontend\blocks\MapBlock';

	public function testEmptyRender()
	{
		$this->assertSame('', $this->renderFrontendNoSpace());
	}
}