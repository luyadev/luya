<?php

$config = [
    'components' => [
        'mail' => [
            'class' => '\luya\components\Mail',
        ],
        'twig' => '\luya\components\Twig',
        'errorHandler' => [
            'class' => '\luya\base\web\ErrorHandler',
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
        'luya\base\web\Bootstrap',
    ],
    'timezone' => 'Europe/Berlin',
];

return $config;
