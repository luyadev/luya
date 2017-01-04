<?php

namespace cmstests;

class BlockTestCase extends CmsFrontendTestCase
{
	public $blockClass = null;
	
	/**
	 * @var \luya\cms\base\PhpBlock
	 */
	public $block;

	public function setUp(){
		parent::setUp();
		
		$class = $this->blockClass;
		$this->block = new $class();
	}
	
	public function renderFrontend()
	{
		return $this->block->renderFrontend();
	}
		
	public function renderFrontendNoSpace()
	{
		$text = trim(preg_replace('/\s+/', ' ', $this->renderFrontend()));
		
		return str_replace(['> ', ' <'], ['>', '<'], $text);
	}
}