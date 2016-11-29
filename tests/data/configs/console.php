<?php

return [
    'id' => 'testenv',
    'mute' => true,
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'unitmodule',
    'modules' => [
        'unitmodule' => [
            'class' => 'luyatests\data\modules\unitmodule\Module',
        ],
        'consolemodule' => [
            'class' => 'luyatests\data\modules\consolemodule\Module',
        ],
        'crudmodulefolderadmin' => 'luyatests\data\modules\crudmodulefolder\admin\Module',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => DB_DSN,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => 'utf8',
        ],
    ],
];
