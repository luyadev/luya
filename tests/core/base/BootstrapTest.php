<?php

namespace luyatest\core\base;

use Yii;
use luya\base\Bootstrap;

class CustomBootstrap extends Bootstrap
{
    public function beforeRun($app)
    {}
    
    public function run($app)
    {}
}

class BootstrapTest extends \luyatest\LuyaWebTestCase
{
    public function testCustomBootstrapHasModule()
    {
        $bs = new CustomBootstrap();
        $bs->bootstrap(Yii::$app);
        $this->assertTrue($bs->hasModule('unitmodule'));
        $this->assertFalse($bs->hasModule('notexistingmodule'));
    }
}