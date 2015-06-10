<?php

$config = [
    'controllerMap' => [
        'presql' => '\luya\commands\PresqlController',
        'exec' => '\luya\commands\ExecutableController',
        'crud' => '\luya\commands\CrudController',
        'command' => '\luya\commands\CommandController',
    ],
    'components' => [
        'collection' => 'luya\components\Collection',
        'luya' => 'luya\components\LuyaComponents',
        'mail' => [
            'class' => '\luya\components\Mail',
        ],
    ],
    'bootstrap' => [
        'luya\components\BootstrapCli',
    ],
];

return $config;
