<?php

namespace tests\web\luya\base;

use Yii;

class ExceptionTest extends \tests\web\Base
{
    /**
     * @expectedException \luya\Exception
     */
    public function testException()
    {
        throw new \luya\Exception('fixme');
    }
}