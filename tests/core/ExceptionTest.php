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
}