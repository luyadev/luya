<?php

namespace tests\src\moduleapp;

use Yii;


class RunTest extends \tests\BaseModuleAppTest
{
    public function testApp()
    {
        // index controller with default route 'index' in module
        $this->assertEquals('foo', Yii::$app->runAction('', []));
        $this->assertEquals('foo', Yii::$app->runAction('moduletest', []));
        $this->assertEquals('foo', Yii::$app->runAction('moduletest/', []));
        $this->assertEquals('foo', Yii::$app->runAction('moduletest/test', []));
        $this->assertEquals('foo', Yii::$app->runAction('moduletest/test/', []));
        $this->assertEquals('foo', Yii::$app->runAction('moduletest/test/index', []));
        $this->assertEquals('foo', Yii::$app->runAction('moduletest/test/index/', []));
        $this->assertEquals('bar', Yii::$app->runAction('moduletest/test/bar', []));
        $this->assertEquals('bar', Yii::$app->runAction('moduletest/test/bar/', []));
        // other controller
        $this->assertEquals('index', Yii::$app->runAction('moduletest/other', []));
        $this->assertEquals('index', Yii::$app->runAction('moduletest/other/', []));
        $this->assertEquals('index', Yii::$app->runAction('moduletest/other/index', []));
        $this->assertEquals('index', Yii::$app->runAction('moduletest/other/index/', []));
        $this->assertEquals('baz', Yii::$app->runAction('moduletest/other/baz', []));
        $this->assertEquals('baz', Yii::$app->runAction('moduletest/other/baz/', []));
    }   
}