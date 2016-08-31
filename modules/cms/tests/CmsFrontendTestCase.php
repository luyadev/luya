<?php

namespace cmstests;

require 'vendor/autoload.php';
require 'data/env.php';

class CmsFrontendTestCase extends \PHPUnit_Framework_TestCase
{
    public $app = null;
    
    public function setUp()
    {
        $this->mockApp();
    }
    
    public function mockApp()
    {
        if ($this->app === null) {
            $this->app = new \luya\Boot();
            $this->app->configFile = __DIR__ .'/data/configs/cms.php';
            $this->app->mockOnly = true;
            $this->app->setYiiPath(__DIR__.'/../vendor/yiisoft/yii2/Yii.php');
            $this->app->applicationWeb();
        }
    }
}
