<?php

/**
 * This is the base config. It doesn't hold any informations about the database and is only used for local development.
 * Use localdb.php to configure you database.
 */

/*
 * Enable or disable the debugging, if those values are deleted YII_DEBUG is false and YII_ENV is prod.
 * The YII_ENV value will also be used to load assets based on enviroment (see assets/ResourcesAsset.php)
 */
defined('YII_ENV') or define('YII_ENV', 'local');
defined('YII_DEBUG') or define('YII_DEBUG', true);

$config = [
    
    /*
     * For best interoperability it is recommended that you use only alphanumeric characters when specifying an application ID
     */
    'id' => 'myproject',
    
    /*
     * The name of your site, will be display on the login screen
     */
    'siteTitle' => 'My Project',
    
    /*
     * Set the administration area language. Available language short codes: "en", "de" and "ru"
     */
    'luyaLanguage' => 'en',
    
    /*
     * Let the application know which module should be executed by default (if no url is set). This module must be included 
     * in the modules section. In the most cases you are using the cms as default handler for your website. But the concept
     * of LUYA is also that you can use the Website without the CMS module! 
     */
    'defaultRoute' => 'cms',
    
    /*
     * Define the basePath of the project (Yii Configration Setup
     */
    'basePath' => dirname(__DIR__),
    
    'modules' => [

        /*
         * If you have other administration module (like cmsadmin) then you going to need this module. The Admin module provides
         * a lot of functionalitiy like storage system etc. But the basic concept of LUYA is also that you can use LUYA without the
         * admin module.
         * 
         * @secureLogin: (boolean) This will activated a two-way authentification method where u get a token sent by mail, for this feature
         * you have to make sure the mail component is configured correctly, you can test with console command `./vendor/bin/luya health/mailer`.
         */
        'admin' => [
            'class' => 'admin\Module',
            'secureLogin' => false, // when enabling secure login, the mail component must be proper configured otherwise the auth token mail will not send.
        ],
        
        /*
         * You can use the cms module if you like.
         */
        'cms' => [
            'class' => 'cms\Module',
            'assets' => [
                'app\assets\ResourcesAsset'
            ],
            'enableCompression' => true, // compressing the cms output (removing white spaces and newlines)
        ],

        /*
         * This is the administration module for the `cms` module.
         */
        'cmsadmin' => 'cmsadmin\Module',
    ],
    'components' => [
        
        /*
         * Add your smtp connection to the mail component to send mails (which is required for secure login), you can test your
         * mail component with the luya console command ./vendor/bin/luya health/mailer.
         */
        'mail' => [
            'host' => null,
            'username' => null,
            'password' => null,
            'from' => null,
            'fromName' => null,
        ],

        /*
         * ATTENTION:
         * To help us improve our Software you can enable (true) this property to send all Exceptions directly to the luya developer team. The follwing informations will be transfered:
         * - $_GET, $_POST, $_SERVER and $_SESSION data
         * - Exception Object (inlcuding stack trace, line, linenr, message, file)
         *
         * You can also create your own errorapi (zehir/luya-modul-errorapi) module to get notification
         * about the errors from your projects.
         */
        'errorHandler' => [
            'transferException' => false,
        ],
        
        /*
         * The composition component handles your languages and they way your urls will look like. The composition componentn will
         * automatically add the language prefix you have defined in `default` to your url (the language part in the url "example.com/EN/homepage").
         * 
         * hidden: (boolean) If this website is not multilingual you can hidde the composition, other whise you have to enable this.
         */
        'composition' => [
            'hidden' => true, // you will not have languages in your url (most case for pages which are not multi lingual)
            'default' => ['langShortCode' => 'en'], // the default language for the composition should match your default language shortCode in the langauge table.
        ],
        
        /*
         * When you are enabling the cache, luya will cache cms blocks and speed up the system in different ways. In the prep config
         * we use the DummyCache to "fake" the caching behavior, but actually nothing gets cached, when your in production you should
         * use caching which matches your hosting environment. In most cases yii\caching\FileCache will result in fast website.
         * 
         * http://www.yiiframework.com/doc-2.0/guide-caching-data.html#cache-apis
         */
        'cache' => [
            'class' => 'yii\caching\DummyCache', // use: yii\caching\FileCache
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
    ],
    'bootstrap' => [
        'cms',
    ],
];

/**
 * if you want to use the debug and gii modules of yii, add them to your composer.json in the require section:
 * "yiisoft/yii2-gii" : "*"
 * "yiisoft/yii2-debug" : "*"
 */

/*if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}*/


return \yii\helpers\ArrayHelper::merge($config, require('localdb.php'));
