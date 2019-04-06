<?php

namespace luyatests\core\base;

use luya\Boot;

class BootTest extends \luyatests\LuyaWebTestCase
{
    public function testBaseObject()
    {
        $boot = new Boot();
        $this->assertEquals('cli', $boot->getSapiName());
        $this->assertTrue($boot->isCli());
    }

    /**
     * @expectedException Exception
     */
    public function testUnableToFindConfigFile()
    {
        $boot = new Boot();
        $boot->run();
    }
    
    /**
     * @expectedException Exception
     */
    public function testWrongConfigFile()
    {
        $boot = new Boot();
        $boot->configFile = __DIR__ . '/../../data/configs/wrongconfig.php';
        $boot->run();
    }
    
    /**
     * @expectedException Exception
     */
    public function testYiiNotFound()
    {
        $boot = new Boot();
        $boot->configFile = __DIR__ . '/../../data/configs/console.php';
        $boot->setBaseYiiFile('wrongPathToYii.php');
        $boot->mockOnly = true;
        $boot->applicationConsole();
    }
    
    public function testSetterGetterConfig()
    {
        $boot = new Boot();
        $boot->setConfigArray(['foo' => 'bar']);
        $this->assertSame(['foo' => 'bar'], $boot->getConfigArray());
    }
    
    public function testConsoleHostInfo()
    {
        $boot = new Boot();
        $boot->setBaseYiiFile('vendor/yiisoft/yii2/Yii.php');
        $boot->setConfigArray(['id' => 'test', 'basePath' => dirname(__DIR__), 'consoleHostInfo' => 'https://luya.io']);
        $boot->mockOnly = true;
        $boot->applicationConsole();
        
        $this->assertSame('https://luya.io', $boot->app->urlManager->hostInfo);
        $this->assertSame('', $boot->app->urlManager->baseUrl); // as the baseUrl setter method will ltrim
    }
    
    public function testConsoleHostInfoAndBasePath()
    {
        $boot = new Boot();
        $boot->setBaseYiiFile('vendor/yiisoft/yii2/Yii.php');
        $boot->setConfigArray(['id' => 'test', 'basePath' => dirname(__DIR__), 'consoleHostInfo' => 'https://luya.io', 'consoleBaseUrl' => '/luya-kickstarter']);
        $boot->mockOnly = true;
        $boot->applicationConsole();
        
        $this->assertSame('https://luya.io', $boot->app->urlManager->hostInfo);
        $this->assertSame('/luya-kickstarter', $boot->app->urlManager->baseUrl); // as the baseUrl setter method will ltrim
    }

    public function testPrependConfig()
    {
        $boot = new CustomBoot();
        $this->assertArrayHasKey('foo', $boot->getConfigArray());
        $this->assertSame('bar', $boot->getConfigArray()['foo']);
    }
}

// custom boot config with prepend configs

class CustomBoot extends \luya\base\Boot
{
    public function prependConfigArray()
    {
        return ['foo' => 'bar'];
    }
}
