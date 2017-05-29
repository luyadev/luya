<?php

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'admin',
    'aliases' => [
        '@runtime' => dirname(__DIR__) . '/runtime',
        '@data' => dirname(__DIR__),
    ],
    'language' => 'en',
    'modules' => [
        'admin' => [
            'class' => 'luya\admin\Module',
        ],
        'crudmodulefolderadmin' => [
            'class' => 'admintests\data\modules\crudmodulefolder\admin\Module',
        ]
    ],
    'components' => [
        'request' => [
            'forceWebRequest' => true,
            'isAdmin' => true,
            'isConsoleRequest' => false
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => DB_DSN,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => 'utf8',
        ],
    ],
];
