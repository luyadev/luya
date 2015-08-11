<?php

namespace tests\src;

use Yii;

class AppTest extends \tests\BaseTest
{
    public function testApp()
    {
        $this->assertEquals('Luya Tests', Yii::$app->siteTitle);
        $this->assertEquals('testtoken', Yii::$app->remoteToken);
    }
}