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

    public function getConfigArray()
    {
        return include(__DIR__ .'/data/configs/admin.php');
    }
    
    public function mockApp()
    {
        if ($this->app === null) {
            $this->app = new \luya\Boot();
            $this->app->setConfigArray($this->getConfigArray());
            $this->app->mockOnly = true;
            $this->app->setBaseYiiFile(__DIR__.'/../vendor/yiisoft/yii2/Yii.php');
            $this->app->applicationWeb();
        }
    }
    
    protected function removeNewline($text)
    {
        $text = trim(preg_replace('/\s+/', ' ', $text));
        
        return str_replace(['> ', ' <'], ['>', '<'], $text);
    }
}
