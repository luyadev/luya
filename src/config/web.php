<?php

$config = [
    'components' => [
        /*
        'mail' => [
            'class' => '\luya\components\Mail',
        ],
        'twig' => '\luya\components\Twig',

        'composition' => [
            'class' => '\luya\components\Composition',
        ],
        'element' => [
            'class' => '\luya\components\Element',
        ],
        */
        /*
        'errorHandler' => [
            'class' => '\luya\web\ErrorHandler',
            'memoryReserveSize' => 0,
        ],
        
        'urlManager' => 'luya\components\UrlManager',
        */
        //'view' => ['class' => 'luya\components\View'],
        /*
        'authManager' => [
            'class' => 'yii\rbaac\PhpManager',
        ],
        */
        /*
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => YII_DEBUG,
            'appendTimestamp' => !YII_DEBUG,
        ],
        */
        /*
        'request' => [
            'class' => 'luya\components\Request',
            'cookieValidationKey' => 'cookeivalidationkey',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        */
    ],
    'bootstrap' => [
        'luya\web\Bootstrap',
    ],
    //'timezone' => 'Europe/Berlin',
];

return $config;
