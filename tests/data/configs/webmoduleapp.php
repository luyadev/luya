<?php

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Test App',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'unitmodule',
    'modules' => [
        'unitmodule' => [
            'class' => 'tests\data\modules\unitmodule\Module',
        ],
    ],
];