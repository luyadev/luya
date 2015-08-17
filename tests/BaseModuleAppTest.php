<?php

namespace tests;

use Yii;

require(__DIR__ . '/../vendor/autoload.php');

class BaseModuleAppTest extends \PHPUnit_Framework_TestCase
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
            $this->app->configPath = 'tests';
            $this->app->configName = 'src/moduleapp/config.php';
            $this->app->mockOnly = true;
            $this->app->setYiiPath(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
            $this->app->applicationWeb();
        }
    }
    
    public function getTrace()
    {
        return Yii::getLogger()->getProfiling();
    }
}