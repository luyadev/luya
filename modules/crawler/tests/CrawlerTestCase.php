<?php

namespace crawlerests;

use luya\Boot;

define('YII_DEBUG', true);
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['DOCUMENT_ROOT'] = '/var/www';
$_SERVER['REQUEST_URI'] = '/luya/envs/dev/public_html/';
$_SERVER['SCRIPT_NAME'] = '/luya/envs/dev/public_html/index.php';
$_SERVER['PHP_SELF'] = '/luya/envs/dev/public_html/index.php';
$_SERVER['SCRIPT_FILENAME'] = '/var/www/luya/envs/dev/public_html/index.php';


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
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => DB_DSN,
                    'username' => DB_USER,
                    'password' => DB_PASS,
                    'charset' => 'utf8',
                ],
                'request' => [
                    'forceWebRequest' => true,
                ],
            ],
            'modules' => [
                'crawleradmin' => 'luya\crawler\admin\Module',
            ]
        ]);
        $boot->mockOnly = true;
        $boot->setBaseYiiFile(__DIR__.'/../vendor/yiisoft/yii2/Yii.php');
        $boot->applicationWeb();
    }
}
