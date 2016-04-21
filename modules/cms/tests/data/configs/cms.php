<?php

return [
    'id' => 'testenv',
    'siteTitle' => 'Luya Tests',
    'remoteToken' => 'testtoken',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'cms',
    'modules' => [
        'cms' => 'cms\Module',
    ],
    'components' => [
        'request' => [
            'forceWebRequest' => true,
        ],
    ],
];
