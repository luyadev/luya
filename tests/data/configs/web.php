<?php

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
    ],
    'components' => [
    	'composition' => [
    		'hidden' => false,
    	],
        'request' => [
            'forceWebRequest' => true,
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
