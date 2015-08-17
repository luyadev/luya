<?php

namespace tests\src\cli;

use Yii;

class AppTest extends \tests\BaseCliTest
{
    public function testApp()
    {
        $this->assertInstanceOf('luya\cli\Application', Yii::$app);
    }
}