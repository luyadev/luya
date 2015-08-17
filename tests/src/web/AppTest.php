<?php

namespace tests\src\web;

use Yii;

class AppTest extends \tests\BaseWebTest
{
    public function testApp()
    {
        $this->assertInstanceOf('luya\web\Application', Yii::$app);
        $this->assertEquals('Luya Tests', Yii::$app->siteTitle);
        $this->assertEquals('testtoken', Yii::$app->remoteToken);
    }
}