<?php

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'cms',
    'modules' => [
        'admin' => 'luya\admin\Module',
        'cms' => [
            'class' => '\luya\cms\frontend\Module'
        ],
        'cmsadmin' => 'luya\cms\admin\Module',
        'CmsUnitModule' => '\cmstests\data\modules\CmsUnitModule',
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
