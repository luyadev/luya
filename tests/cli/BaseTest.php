<?php

namespace tests\cli;

use Yii;

class BaseTest extends \tests\cli\Base
{
    public function testApp()
    {
        $this->assertInstanceOf('luya\cli\Application', Yii::$app);
    }
}
