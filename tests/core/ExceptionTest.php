<?php

namespace luyatests\core;

class ExceptionTest extends \luyatests\LuyaWebTestCase
{
    public function testException()
    {
        $this->expectException('\luya\Exception');
        throw new \luya\Exception('fixme');
    }

    public function testNameException()
    {
        $e = new \luya\Exception('fixme');
        $this->assertEquals('LUYA Exception', $e->getName());
    }
}
