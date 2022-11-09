<?php

namespace luyatests\core\tag;

use luya\tag\BaseTag;
use luyatests\LuyaWebTestCase;

class MockTag extends BaseTag
{
    public function example()
    {
        return 'example';
    }

    public function readme()
    {
        return 'readme';
    }

    public function parse($value, $sub)
    {
        return null;
    }
}

class BaseTagTest extends LuyaWebTestCase
{
    public function testGetView()
    {
        $mock = new MockTag();
        $this->assertInstanceOf('luya\web\View', $mock->getView());
    }
}
