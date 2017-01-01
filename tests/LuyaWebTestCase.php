<?php

namespace luyatests;

use Yii;
use luyatests\LuyaTestCaseInterface;

require 'vendor/autoload.php';
require 'data/env.php';

class LuyaWebTestCase extends \PHPUnit_Framework_TestCase implements LuyaTestCaseInterface
{
    public $app = null;

    public function setUp()
    {
        $this->mockApp();
    }
    
    public function getConfigFile()
    {
        return __DIR__ .'/data/configs/web.php';
    }

    public function mockApp()
    {
        if ($this->app === null) {
            $this->app = new \luya\Boot();
            $this->app->configFile = $this->getConfigFile();
            $this->app->mockOnly = true;
            $this->app->setBaseYiiFile('vendor/yiisoft/yii2/Yii.php');
            $this->app->applicationWeb();
        }
    }

    public function getTrace()
    {
        return Yii::getLogger()->getProfiling();
    }
}
