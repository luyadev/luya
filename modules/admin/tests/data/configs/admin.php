<?php

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'admin',
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
