<?php

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Test App',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'unitmodule',
    'modules' => [
        'unitmodule' => [
            'class' => 'luyatest\data\modules\unitmodule\Module',
        ],
    ],
];