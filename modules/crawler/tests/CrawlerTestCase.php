<?php

namespace crawlerests;

use luya\Boot;

class CrawlerTestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $boot = new Boot();
        $boot->setConfigArray([
            'id' => 'testenv',
            'siteTitle' => 'Luya Tests',
            'remoteToken' => 'testtoken',
            'basePath' => dirname(__DIR__),
            'components' => [
                
            ]
        ]);
        $boot->mockOnly = true;
        $boot->setBaseYiiFile(__DIR__.'/../vendor/yiisoft/yii2/Yii.php');
        $boot->applicationWeb();
    }
}
