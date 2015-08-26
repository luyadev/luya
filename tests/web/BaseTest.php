<?php

namespace tests\web;

use Yii;

class BaseTest extends \tests\web\Base
{
    public function testApp()
    {
        $this->assertInstanceOf('luya\web\Application', Yii::$app);
        $this->assertEquals('Luya Tests', Yii::$app->siteTitle);
        $this->assertEquals('testtoken', Yii::$app->remoteToken);
    }
}