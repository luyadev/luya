<?php

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'unitmodule',
    'modules' => [
        'unitmodule' => [
            'class' => '\luyatest\data\modules\unitmodule\Module',
        ],
        'urlmodule' => [
            'class' => '\luyatest\data\modules\urlmodule\Module',
        ],
        'viewmodule' => [
            'class' => '\luyatest\data\modules\viewmodule\Module',
        ],
        'ctrlmodule' => [
            'class' => '\luyatest\data\modules\ctrlmodule\Module',
        ],
    ],
    'components' => [
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