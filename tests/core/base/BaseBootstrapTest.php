<?php

namespace luyatests\core\base;

use Yii;
use luya\base\BaseBootstrap;
use luya\web\Application;

class CustomBootstrap extends BaseBootstrap
{
    public function beforeRun($app)
    {
    }
    
    public function run($app)
    {
    }
}

class BaseBootstrapTest extends \luyatests\LuyaWebTestCase
{
    public function testCustomBootstrapHasModule()
    {
        $bs = new CustomBootstrap();
        $bs->bootstrap(Yii::$app);
        $this->assertTrue($bs->hasModule('unitmodule'));
        $this->assertFalse($bs->hasModule('notexistingmodule'));
    }
    
    public function testEmptyModules()
    {
        $app = new Application(['id' => '123', 'basePath' => '']);
        $boot = new CustomBootstrap();
        $boot->bootstrap($app);
        $this->assertSame([], $boot->getModules());
    }
}
