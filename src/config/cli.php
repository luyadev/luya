<?php

$config = [
    //'controllerNamespace' => 'commands',
    'controllerMap' => [
        'presql' => '\luya\commands\PresqlController',
    ],
    'components' => [
        'collection' => 'luya\components\Collection',
        'luya' => 'luya\components\Luya',
    ]
];

return $config;
