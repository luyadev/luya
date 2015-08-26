<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$config = [
    'id' => 'testenv',
    'mute' => true,
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'unitmodule',
	'modules' => [
        'luya' => 'luya\Module',
	    'admin' => [
	        'class' => 'admin\Module',
	    ],
	    'unitmodule' => [
	        'class' => 'tests\data\modules\unitmodule\Module'
	    ],
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