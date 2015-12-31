<?php

// enable or disable the debugging, if thos values are deleted YII_DEBUG is false and YII_ENV is prod.
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

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
        // add your smtp connection to the mail component to send mails (which is required for secure login), you can test your
        // mail component with the luya console command ./vendor/bin/luya health/mailer.
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
    		 * To help us improve our Software you can enable (true) this property to send all Exceptions directly to the luya developer team. The follwing informations will be transfered:
    		 * - $_GET, $_POST
    		 * - Exception Object (inlcuding stack trace, line, linenr, message, file)
    		 * 
    		 * You can also create your own errorapi (zehir/luya-modul-errorapi) module to get notification
    		 * about the errors from your projects.
    		 */
            'transferException' => false,
        ],
        // composition component handles all language issues
        'composition' => [
            'hidden' => true, // you will not have languages in your url (most case for pages which are not multi lingual)
            'default' => ['langShortCode' => 'en'], // the default language for the composition should match your default language shortCode in the langauge table.
        ],
        // when you are enabling the cache, luya will cache cms blocks and speed up the system in different arrays
        // this should only be activated in the prod.php (productive) config.
        /*
        'cache' => [
            'class' => 'yii\caching\FileCache', // choose between different caching systems, see yii2 documentation.
        ],
        */
    ]
];

/**
 * if you want to use the debug and gii modules of yii, add them to your composer.json in the require section:
 * "yiisoft/yii2-gii" : "*"
 * "yiisoft/yii2-debug" : "*"
 */
/*
if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
*/

return \yii\helpers\ArrayHelper::merge($config, require('local.php'));