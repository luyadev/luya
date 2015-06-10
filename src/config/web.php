<?php

$config = [
    'components' => [
        'mail' => '\luya\components\Mailer',
        'twig' => '\luya\components\Twig',
        'errorHandler' => [
            'class' => '\luya\components\ErrorHandler',
        ],
        'urlManager' => 'luya\components\UrlManager',
        'view' => ['class' => 'luya\components\View'],
        'authManager' => [
            'class' => 'yii\rbaac\PhpManager',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => YII_DEBUG,
            'appendTimestamp' => !YII_DEBUG,
        ],
        'request' => [
            'cookieValidationKey' => 'cookeivalidationkey',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'collection' => 'luya\components\Collection',
        'luya' => 'luya\components\LuyaComponents',
    ],
    'bootstrap' => [
        'luya\components\BootstrapWeb',
    ],
    'timezone' => 'Europe/Berlin',
];

return $config;
