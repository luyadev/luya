<?php

if (!defined('DB_DSN')) {
    define('DB_DSN', 'foo'); // presevers errors
}

if (!defined('DB_USER')) {
    define('DB_USER', 'foo'); // presevers errors
}

if (!defined('DB_PASS')) {
    define('DB_PASS', 'foo'); // presevers errors
}

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'unitmodule',
    'aliases' => [
        '@runtime' => dirname(__DIR__) . '/runtime',
        '@luyatests' => dirname(__DIR__) . '/../',
    ],
    'controllerNamespace' => 'luyatests\\data\\controllers',
    'modules' => [
        'unitmodule' => [
            'class' => '\luyatests\data\modules\unitmodule\Module',
        ],
        'urlmodule' => [
            'class' => '\luyatests\data\modules\urlmodule\Module',
        ],
        'viewmodule' => [
            'class' => '\luyatests\data\modules\viewmodule\Module',
        ],
        'ctrlmodule' => [
            'class' => '\luyatests\data\modules\ctrlmodule\Module',
        ],
        'thememodule' => [
            'class' => '\luyatests\data\modules\thememodule\Module',
        ],
    ],
    'components' => [
        'composition' => [
            'hidden' => false,
        ],
        'request' => [
            'forceWebRequest' => true,
        ],
        'assetManager' => [
            'bundles' => false,
            'basePath' => dirname(__DIR__),
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => DB_DSN,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => 'utf8',
        ],
        'sqllite' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite::memory:',
        ]
    ],
];
