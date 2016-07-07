<?php

namespace admintests;

require 'vendor/autoload.php';
require 'data/env.php';

class AdminTestCase extends \PHPUnit_Framework_TestCase
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
            $this->app->configFile = __DIR__ .'/data/configs/admin.php';
            $this->app->mockOnly = true;
            $this->app->setYiiPath(__DIR__.'/../vendor/yiisoft/yii2/Yii.php');
            $this->app->applicationWeb();
        }
    }
}
