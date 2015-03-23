<?php

$config = [
    'components' => [
        'mail' => '\luya\components\Mailer',
        'errorHandler' => [
            'class' => '\luya\components\ErrorHandler',
        ],
        'urlManager' => 'luya\components\UrlManager',
        'view' => ['class' => 'luya\components\View'],
        'authManager' => [
            'class' => 'yii\rbaac\PhpManager',
        ],
        'request' => [
            'cookieValidationKey' => 'cookeivalidationkey',
            'enableCsrfValidation' => false,
        ],
        'collection' => 'luya\components\Collection',
        'luya' => 'luya\components\LuyaComponents',
    ],
    'bootstrap' => [
        'luya\components\Bootstrap',
    ],
];

return $config;
