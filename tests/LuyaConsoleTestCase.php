<?php

namespace luyatests;

use Yii;


require 'vendor/autoload.php';
require 'data/env.php';

class LuyaConsoleTestCase extends \PHPUnit_Framework_TestCase implements LuyaTestCaseInterface
{
    public $app = null;

    public function setUp()
    {
        $this->mockApp();
    }
    
    public function getConfigFile()
    {
        return  __DIR__ .'/data/configs/console.php';
    }

    public function mockApp()
    {
        if ($this->app === null) {
            $this->app = new \luya\Boot();
            $this->app->configFile = $this->getConfigFile();
            $this->app->mockOnly = true;
            $this->app->setBaseYiiFile('vendor/yiisoft/yii2/Yii.php');
            $this->app->applicationConsole();
        }
    }

    public function getTrace()
    {
        return Yii::getLogger()->getProfiling();
    }
}
