<?php

namespace tests\core;

class ExceptionTest extends \tests\LuyaWebTestCase
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
        $this->assertEquals('Luya Exception', $e->getName());
    }
}