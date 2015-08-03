<?php

namespace tests;

class AppTest extends \PHPUnit_Framework_TestCase
{
    public $app = null;
    
    public function setUp()
    {
        // use the luya boot wrapping class
        $this->app = new \luya\base\Boot();
        $this->app->configPath = 'tests';
        $this->app->configName = 'config.php';
        $this->app->setYiiPath(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        $this->app->run();
    }
    
    public function testBuild()
    {
        $this->app;
    }
}