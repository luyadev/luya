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

## Configurtion Files and Config Builder

This is how a default config file (e.g. `configs/env-local.php` or `configs/env-prod.php`) would look like:

> since version 1.0.21 of LUYA core the {{luya\Config}} is used to generate configs:

```php
define('YII_DEBUG', true);
define('YII_ENV', 'prep');

$config = \luya\Config('myproject', dirname(__DIR__), [
    'siteTitle' => 'My Project',
    'defaultRoute' => 'cms',
]);

// modules
$config->module('admin', [
    'class' => 'luya\admin\Module',
    'secureLogin' => false, // when enabling secure login, the mail component must be proper configured otherwise the auth token mail will not send.
    'interfaceLanguage' => 'en', // Set the administration area language. 
]);
$config->module('cms', [
    'class' => 'luya\cms\frontend\Module',
    'contentCompression' => true, // compressing the cms output (removing white spaces and newlines)
]);
$config->module('cmsadmin', 'luya\cms\admin\Module');

// components
$config->component('mail', [
    'isSMTP' => false, // use phps mail() function
    'from' => 'hello@luya.io',
    'fromName' => 'hello@luya.io',
]);
$config->component('composition', [
    'hidden' => true, // no language in your url (most case for pages which are not multilingual)
    'default' => ['langShortCode' => 'en'], // the default language for the composition should match your default language shortCode in the langauge table.
])

// tell the application to bootstrap the cms module
$config->bootstrap(['cms']);

return $config;
```

As the `env.php` now recieves the Config object and won't be stored in git the enviroment to return can be choosen there:

example content of `env.php`:

```php
$config = require 'config.php'; 

return $config->toArray(\luya\Config::ENV_PROD);
```

The above created configuration would produce something like this an Yii array configuration style:


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
            'isSMTP' => false,
            'from' => 'hello@luya.io',
            'fromName' => 'hello@luya.io',
        ],
        'composition' => [
            'hidden' => true, 
            'default' => ['langShortCode' => 'en'],
        ],
    ],
    'bootstrap' => [
        'cms',
    ],
];
```

## Configuration File for Console and Web

Since the introduction of {{luya\Config}} its possible to set components for either console or web runtime, assuming you have `cookieValidationKey` in `request` component which is only valid on web runtime you can use {{luya\Config::webComponent()}} to register the component:

```php
$config->webComponent('request', [
    'cookieValidationKey' => 'XYZ',
]);
```

The same also works for console components:

```php
$config->consoleComponent('request', [
    'params' => ['foo' => 'bar'],
]);
```

You can even merge data from the component which works on both runtime systems:

```php
$config->component('request', [
    'isConsoleRequest' => false,
]);
$config->webComponent('request', [
    'cookieValidationKey' => 'XYZ',
]);
$config->consoleComponent('request', [
    'params' => ['foo' => 'bar'],
]);
```

// depending on console or web request would resolve:
```php
// on web runtime:
'request' => [
    'isConsoleRequest' => false,
    'cookieValidationKey' => 'XYZ',
];

// while on console runtime:
'request' => [
    'isConsoleRequest' => false,
    'params' => ['foo' => 'bar'],
];
```

## Configuration for different Environments

As a key concept of LUYA is to Dont repeat yourself with {{luya\Config}} a configuration file for differnt hosts can be done in a single file using `env()`. Assuming a database connection which has different connection details on different hosts (prep and prod) define the {{yii\db\Connection}} as followed:

```php
 $config->component('db', [
     'class' => 'yii\db\Connection',
     'dsn' => 'mysql:host=localhost;dbname=prod_db',
    'username' => 'foo',
    'password' => 'bar',
])->env(Config::ENV_PREP);

$config->component('db', [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=prod_db',
    'username' => 'foo',
    'password' => 'bar',
])->env(Config::ENV_PROD);
```

The `env.php` will recieve the `$config` object and is then therefore responsible to correctly return the given env:

```php
$config = require 'config.php'; 

return $config->toArray(\luya\Config::ENV_PROD);

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
        "luyadev/luya-core" : "^1.0"
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
    "mycompanyvendor/luya-di" : "^1.0",
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

## Composer latest LUYA development version

In order to get latest development build (dev-master) for the LUYA modules and core your `composer.json` could look like this:

```json
 {
    "require": {
        "luyadev/luya-core" : "^1.0@dev",
        "luyadev/luya-module-admin" : "^1.0@dev",
        "luyadev/luya-module-cms" : "^1.0@dev",
        "luyadev/luya-module-crawler" : "^1.0@dev",
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
