<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$config = [
    'id' => 'testenv',
    'siteTitle' => 'Luya Test App',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'moduletest',
	'modules' => [
	    'moduletest' => [
	        'class' => '\tests\src\moduleapp\module\Module'
	    ],
    ],
];

return $config;