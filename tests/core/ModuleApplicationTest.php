<?php

namespace luyatests\core;

use Yii;

class ModuleApplicationTest extends \luyatests\LuyaWebModuleAppTestCase
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

    public function testViewMap()
    {
        // Works only with disabled $useAppViewPath
        Yii::$app->getModule('unitmodule')->useAppViewPath = false;

        // Test ViewmapController
        $this->assertEquals('viewmap1', Yii::$app->runAction('unitmodule/viewmap/viewmap1'));
        $this->assertEquals('viewmap2', Yii::$app->runAction('unitmodule/viewmap/viewmap2'));
        $this->assertEquals('viewmap3', Yii::$app->runAction('unitmodule/viewmap/viewmap3'));

        // Test ViewmapAllController
        $this->assertEquals('viewmapAll', Yii::$app->runAction('unitmodule/viewmap-all'));
    }
}
