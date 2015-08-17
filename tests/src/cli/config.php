<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$config = [
    'id' => 'testenv',
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'cms',
	'modules' => [
        'luya' => 'luya\Module',
	    'admin' => [
	        'class' => 'admin\Module',
	    ],
	    'news' => 'news\Module',
	    'newsadmin' => 'newsadmin\Module',
	    'cms' => [
	        'class' => 'cms\Module',
	        'assets' => [
	            'app\assets\ResourcesAsset'
	        ]
	    ],
	    'cmsadmin' => 'cmsadmin\Module',
	    'moduletest' => 'moduletest\Module',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=' . DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => 'utf8'
        ],
    ]
];

return $config;