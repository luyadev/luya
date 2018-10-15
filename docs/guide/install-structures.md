# Structures

## Example project folder hierarchy

This is how a standard LUYA kickstarter application hierarchy should look and where files, configs, modules and views should be located.

```
.
├── public_html
│   ├── storage
│   └── css
├── assets
├── blocks
├── filters
├── configs
├── migrations
├── modules
│   ├── <APP-MODULE>
│   │   ├── assets
│   │   └── controllers
│   └── <APP-ADMIN-MODULE>
│       ├── assets
│       └── controllers
├── runtime
└── views
    ├── <APP-MODULE>
    │   └── default
    ├── cmslayouts
    └── layouts
```

## Example configuration

This is how a default config file (e.g. `configs/env-local.php` or `configs/env-prod.php`) would look like:

```php

define('YII_DEBUG', true);
define('YII_ENV', 'prep');

return [
    
    /*
     * For best interoperability it is recommend to use only alphanumeric characters when specifying an application ID
     */
    'id' => 'myproject',
    
    /*
     * The name of your site, will be display on the login screen
     */
    'siteTitle' => 'My Project',
    
    /*
     * Let the application know which module should be executed by default (if no url is set). This module must be included 
     * in the modules section. In the most cases you are using the cms as default handler for your website. But the concept
     * of LUYA is also that you can use a website without the CMS module! 
     */
    'defaultRoute' => 'cms',
    
    /*
     * Define the basePath of the project (Yii Configration Setup)
     */
    'basePath' => dirname(__DIR__),
    
    'modules' => [
        
        /*
         * If you have other administration module (e.g. cmsadmin) then you going to need this module. The Admin UI module provides
         * a lot of functionalitiy like storage system etc. But the basic concept of LUYA is also that you can use LUYA without the
         * admin module.
         * 
         * @secureLogin: (boolean) This will activated a two-way authentification method where u get a token sent by mail, for this feature
         * you have to make sure the mail component is configured correctly, you can test with console command `./vendor/bin/luya health/mailer`.
         */
        'admin' => [
            'class' => 'luya\admin\Module',
            'secureLogin' => false, // when enabling secure login, the mail component must be proper configured otherwise the auth token mail will not send.
            'interfaceLanguage' => 'en', // Set the administration area language. 
        ],
        
        /*
         * You can use the cms module if you like.
         */
        'cms' => [
            'class' => 'luya\cms\frontend\Module',
            'contentCompression' => true, // compressing the cms output (removing white spaces and newlines)
        ],
        
        /*
         * This is the administration module for the `cms` module.
         */
        'cmsadmin' => 'luya\cms\admin\Module',
        
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
         * - $_GET, $_POST
         * - Exception Object (inlcuding stack trace, line, linenr, message, file)
         *
         * You can also create your own errorapi (zehir/luya-modul-errorapi) module to get notification
         * about the errors from your projects.
         */
        'errorHandler' => [
            'transferException' => false,
        ],
        
        /*
         * The composition component handles your languages and they way your urls will look like. The composition components will
         * automatically add the language prefix wich is defined in `default` to your url (the language part in the url, f.e. "yourdomain.com/en/homepage").
         * 
         * hidden: (boolean) If this website is not multi lingual you can hide the composition, other whise you have to enable this.
         */
        'composition' => [
            'hidden' => true, // no language in your url (most case for pages which are not multilingual)
            'default' => ['langShortCode' => 'en'], // the default language for the composition should match your default language shortCode in the langauge table.
        ],
        
        /*
         * If cache is enabled LUYA will cache cms blocks and speed up the system in different ways. In the prep config
         * we use the DummyCache to imitate the caching behavior, but actually nothing gets cached. In production you should change to
         * use caching which matches your hosting environment. In most cases yii\caching\FileCache will result in fast website.
         * 
         * http://www.yiiframework.com/doc-2.0/guide-caching-data.html#cache-apis
         */
        'cache' => [
            'class' => 'yii\caching\DummyCache', // use: yii\caching\FileCache
        ],
    ],
    'bootstrap' => [
        'cms',
    ],
];
```

## Production config

In production we try to keep the configs as small as possible, there fore an example.

> Notice that YII_DEBUG and YII_ENV is removed, as this by default the production ready setting, this allows us to keep the config small and clean.

```php

return [
    'id' => 'myproject',
    'siteTitle' => 'My Project',
    'defaultRoute' => 'cms',
    'basePath' => dirname(__DIR__),
    'modules' => [
        'admin' => [
            'class' => 'luya\admin\Module',
            'secureLogin' => true,
            'interfaceLanguage' => 'en',
        ],
        'cms' => [
            'class' => 'luya\cms\frontend\Module',
        ],
        'cmsadmin' => 'luya\cms\admin\Module',
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
            'transferException' => true,
        ],
        'composition' => [
            'hidden' => true, 
            'default' => ['langShortCode' => 'en'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache', // use: yii\caching\FileCache
        ],
    ],
    'bootstrap' => [
        'cms',
    ],
];
```

## Create company wide config

Its very common that you like to share configuration values over different projects, therefore we encourage you to create your own LUYA DI repo, create a private repository on your VCS Platform (example Github) add a Bootstrap file like:

```php
<?php
namespace mycompanyvendor\luya\di;

use Yii;
use yii\base\BootstrapInterface;
use luya\web\Application;

/**
 *
 */
class Bootstrap implements BootstrapInterface
{
	public function bootstrap($app)
	{
		Yii::$container->set('luya\components\Mail', [
			'from' => '***',
			'fromName' => '**',
			'isSMTP' => true,
			'host' => '***',
			'username' => '***',
			'password' => '***',
			'port' => 587,
			'smtpSecure' => 'tls',
			'smtpAuth' => true,
		]);
		
		if (YII_ENV_PROD) {
		    
		    /**
		     * As the error handler is already registered before the bootstraping sequence, we can not configure properties via 
		     * DI container and have to override the application component properties.
		     */
		    if ($app instanceof Application) {
		        $app->set('errorHandler', [
		            'class' => 'luya\web\ErrorHandler',
		            'api' => 'https://copmany/luya-master-admin/errorapi',
		            'transferException' => true,
		        ]);
		    } else {
		        $app->set('errorHandler', [
		            'class' => 'luya\console\ErrorHandler',
		            'api' => 'https://copmany/luya-master-admin/errorapi',
		            'transferException' => true,
		        ]);
		    }
		    
		    // as the error handler is already registered on preInit() stage, we have to
		    // unregister the existing handler, and re-register the handler with new settings from above.
		    $app->errorHandler->unregister();
		    $app->errorHandler->register();
		}
	}
}
```

Create a composer.json

```json
{
    "name": "mycompanyvendor/luya-di",
    "description": "LUYA DI",
    "type" : "luya-extension",
    "autoload" : {
        "psr-4" : {
            "mycompanyvendor\\luya\\di\\" : "src/"
        }
    },
    "require-dev" : {
        "luyadev/luya-core" : "~1.0.0"
    },
    "extra" : {
        "luya" : {
            "bootstrap": [
                "mycompanyvendor\\luya\\di\\Bootstrap"
            ]
        },
        "branch-alias": {
            "dev-master": "1.0.x-dev"
        }
    }
}
```

Now you can include the private LUYA DI package into your projects:

```
"require" : {
    "mycompanyvendor/luya-di" : "~1.0.0",
},
"repositories": [
    {
        "type": "vcs",
        "url":  "https://zephirbot:__TOKEN__@github.com/mycompanyvendor/luya-di.git"
    }
]
```

So now there is no need to configure `errorHandler` or `mail` component, as its done by default whenever the application is running (due to luya bootstrap file).

## Changing the root directory

The `public_html` folder is the root directory. It contains the application bootstrap file. If you want to reflect your web server directory structure, you can rename the `public_html` folder to whatever you want to. For example: `www` or `web`. You just need to update your configuration by adding the `webrootDirectory` config, f.e. it should look like this: `'webrootDirectory' => 'www'`

## Composer - get latest development version

In order to get latest development build (dev-master) for the LUYA modules and core your `composer.json` could look like this:

```json
 {
    "require": {
        "luyadev/luya-core" : "^1.0@dev",
        "luyadev/luya-module-admin" : "^1.0@dev",
        "luyadev/luya-module-cms" : "^1.0@dev",
        "luyadev/luya-module-crawler" : "^1.0@dev",
        "luyadev/luya-module-payment" : "^1.0@dev",
        "luyadev/luya-module-exporter" : "^1.0@dev",
        "luyadev/luya-deployer" : "^1.0@dev"
    },
    "require-dev" : {
        "yiisoft/yii2-debug" : "^2.0",
        "yiisoft/yii2-gii" : "^2.0"
    },
    "extra": {
        "asset-installer-paths": {
            "bower-asset-library": "vendor/bower"
        }
    }
}
```
