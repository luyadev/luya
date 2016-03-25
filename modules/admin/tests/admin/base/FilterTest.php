<?php

namespace admintests\admin\base;

use admintests\AdminTestCase;
use admin\base\Filter;

class DummyFilter extends Filter
{
	public function identifier()
	{
		return 'dummytestfilter';
	}
	
	public function name()
	{
		return 'dummy test filter';
	}
	
	public function chain()
	{
		return [];
	}
}

class FilterTest extends AdminTestCase
{
	public function testFilterObject()
	{
		$o = new DummyFilter();
		$this->assertEmpty($o->getChain());
	}
}