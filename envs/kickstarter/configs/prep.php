<?php

/**
 * the project specific configurations, your working host specific configurations must be located in the local.php config.
 */

$config = [
    'id' => 'myproject', // For best interoperability it is recommended that you use only alphanumeric characters when specifying an application ID
    'siteTitle' => 'My Project', // The name of your site, will be display on the login screen
    'basePath' => dirname(__DIR__),
    'luyaLanguage' => 'en', // set the administration area language (currently available en, de)
    'defaultRoute' => 'cms', // set the default module
	'modules' => [
        'luya' => 'luya\Module',
        'cms' => [
            'class' => 'cms\Module',
            'assets' => [
                'app\assets\ResourcesAsset'
            ],
            'enableCompression' => true, // compressing the cms output (removing white spaces and newlines)
        ],
        'cmsadmin' => 'cmsadmin\Module',
        'admin' => [
            'class' => 'admin\Module',
            'secureLogin' => false, // when enabling secure login, the mail component must be proper configured otherwise the auth token mail will not send.
        ]
    ],
    'components' => [
    	'mail' => [
    		'host' => null,
    		'username' => null,
    		'password' => null,
    		'from' => null,
    		'fromName' => null,
    	],
    	'errorHandler' => [
    		/*
    		 * ATTENTION:
    		 * To help us improve our Software you can enable this property to send all Exceptions directly to the luya developer team. The follwing informations will be transfered:
    		 * - $_GET, $_POST, $_SESSION & $_SERVER
    		 * - Exception Object (inlcuding stack trace, line, linenr, message, file)
    		 */
            'transferException' => false,
        ]
    ]
];


// enable or disable the debugging
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// if you want to use the debug and gii modules of yii, add them to your composer.json in the require section:
// "yiisoft/yii2-gii" : "*"
// "yiisoft/yii2-debug" : "*"
if (YII_DEBUG) {
	/*
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
    */
}

return \yii\helpers\ArrayHelper::merge($config, require('local.php'));