<?php

namespace tests\src\moduleapp;

use Yii;


class BaseTest extends \tests\moduleapp\Base
{
    public function testApp()
    {
        // index controller with default route 'index' in module
        $this->assertEquals('foo', Yii::$app->runAction('', []));
        $this->assertEquals('foo', Yii::$app->runAction('unitmodule', []));
        $this->assertEquals('foo', Yii::$app->runAction('unitmodule/', []));
        $this->assertEquals('foo', Yii::$app->runAction('unitmodule/test', []));
        $this->assertEquals('foo', Yii::$app->runAction('unitmodule/test/', []));
        $this->assertEquals('foo', Yii::$app->runAction('unitmodule/test/index', []));
        $this->assertEquals('foo', Yii::$app->runAction('unitmodule/test/index/', []));
        $this->assertEquals('bar', Yii::$app->runAction('unitmodule/test/bar', []));
        $this->assertEquals('bar', Yii::$app->runAction('unitmodule/test/bar/', []));
        // other controller
        $this->assertEquals('index', Yii::$app->runAction('unitmodule/other', []));
        $this->assertEquals('index', Yii::$app->runAction('unitmodule/other/', []));
        $this->assertEquals('index', Yii::$app->runAction('unitmodule/other/index', []));
        $this->assertEquals('index', Yii::$app->runAction('unitmodule/other/index/', []));
        $this->assertEquals('baz', Yii::$app->runAction('unitmodule/other/baz', []));
        $this->assertEquals('baz', Yii::$app->runAction('unitmodule/other/baz/', []));
    }   
}