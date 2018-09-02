<?php

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Test App',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'unitmodule',
    'aliases' => [
        '@runtime' => dirname(__DIR__) . '/runtime',
        '@luyatests' => dirname(__DIR__) . '/../',
    ],
    'modules' => [
        'unitmodule' => [
            'class' => 'luyatests\data\modules\unitmodule\Module',
        ],
    ],
];
