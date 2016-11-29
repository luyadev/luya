<?php

namespace luyatests\core;

class ExceptionTest extends \luyatests\LuyaWebTestCase
{
    /**
     * @expectedException \luya\Exception
     */
    public function testException()
    {
        throw new \luya\Exception('fixme');
    }
    
    public function testNameException()
    {
        $e = new \luya\Exception('fixme');
        $this->assertEquals('LUYA Exception', $e->getName());
    }
}
