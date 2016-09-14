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
    'modules' => [
        'admin' => [
            'class' => 'luya\admin\Module',
        ],
    ],
    'components' => [
        'request' => [
            'forceWebRequest' => true,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
        ]
    ],
];
