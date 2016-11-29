<?php

namespace luyatests\core\base;

use Yii;
use luya\base\BaseBootstrap;

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
}
