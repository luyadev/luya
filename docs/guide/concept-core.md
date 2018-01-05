# Core

The LUYA core extends the [Yii 2 Framework](https://github.com/yiisoft/yii2) by helpers and a structured way to run and build any web application you can think of. 

There is a clear vision of the structure for modern web applications, in particluar:

+ How to use configuration files and keep them small
+ Arrangement and structure of directories 
+ Components wich are already set by the core 
+ Bulletproof DRY concept for secure and fast development

In other words it means you can also use LUYA to build an application without administration or cms but it still allows you to maintain the same code base over different projects, e.g. with just an MVC provided by Yii via the LUYA core or if you just need an admin UI where you can manage data of your application or as well if you also need a cms to manage the content.

## Setup core application

To run a LUYA core application without modules just create a project with the following structure:

```
.
├── composer.json
├── public_html
│   ├── assets
│   ├── index.php
│   └── .htaccess
├── configs
│   └── env.php
├── controllers
│   └── SiteController.php
├── runtime
└── views
    └── layouts
```

The content for `composer.json` would be:

```json
{
    "require": {
        "luyadev/luya-core" : "~1.0.0"
    },
    "config": {
        "fxp-asset" : {
            "pattern-skip-version": "(-build|-patch)",
             "installer-paths": {
                "bower-asset-library": "vendor/bower"
            }
        }   
    }
}
```

The content for `index.php`:

```php
<?php
// composer autoload include
require(__DIR__ . '/../vendor/autoload.php');
// use the luya boot wrapping class
$boot = new \luya\Boot();
$boot->setBaseYiiFile(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
$boot->run();
```

The content for `.htaccess` file:

```
Options +FollowSymLinks
IndexIgnore */*
RewriteEngine on

SetEnvIf Authorization .+ HTTP_AUTHORIZATION=$0

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php

<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType image/gif "access plus 1 months"
    ExpiresByType image/png "access plus 1 months"
    ExpiresByType image/jpg "access plus 1 months"
    ExpiresByType image/jpeg "access plus 1 months"
    ExpiresByType text/javascript "access plus 1 months"
    ExpiresByType application/x-javascript "access plus 1 months"
    ExpiresByType text/css "access plus 1 months"
    ExpiresDefault "access plus 7 days"
</IfModule>
```

Example for a configuration file `configs/env.php` could look like this:

```php
<?php
return [
    'id' => 'myapp',
    'siteTitle' => 'My Application',
    'basePath' => dirname(__DIR__),
    'components' => [
        'mail' => [
            'password' => '*********',
        ],
        'composition' => [
            'default' => [
                'langShortCode' => 'en'
            ],
        ],
        'urlManager' => [
            'rules' => [
                'home' => 'site/default/index',
                'contact' => 'site/default/contact',
            ],
        ],
    ],
];
```

Note: `env.php` is the default value used from the {{luya\Boot}} class.

Example for the `controllers/SiteController.php`:

```php
<?php
namespace app\controllers;

use luya\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionContact()
    {
        return $this->render('contact');
    }
}
```

Example content for layout file `views/layouts/main.php`:

```php
<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody(); ?>
    <?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
```

## Using core kickstarter project

There is a composer package to start a LUYA core application project very quickly by using the `composer create-project` command.

```
composer create-project luyadev/luya-kickstarter-core:^1.0@dev
```

This will generate a folder `luya-kickstarter-core` containg all required controllers, views and configs based on the description from above.
