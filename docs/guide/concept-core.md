# LUYA Core concept

What is LUYA core? Why do i need it, and what can i do with?

The LUYA Core extends the [Yii 2 Framework](https://github.com/yiisoft/yii2) by helpers and a structured way to run your application. There is clear vision of how to use configuration files, how directories are arranged, small configuration files, components are already set by the core and a DRY concept for your application.

In other words it means you can also use LUYA to build an application without administration or cms but it still allows you to maintain the same code base over different projects, sometimes with just an MVC provided by YII via the LUYA CORE sometimes you just need an administration area where you can manage data of your application and sometimes you also need a cms to manager the content.

## LUYA CORE as MVC

In order to run a LUYA core application without modules just create a applicatin with the following structure:

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

The content for the `composer.json` would be:

```json
{
    "require": {
        "luyadev/luya-core" : "^1.0@dev"
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

The content for the `index.php`:

```php
<?php
// composer autoload include
require(__DIR__ . '/../vendor/autoload.php');
// use the luya boot wrapping class
$boot = new \luya\Boot();
$boot->setBaseYiiFile(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
$boot->run();
```

The content for the `.htaccess` file:

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

An example for a configuration file `configs/env.php` (which env.php is the default value used from the {{luya\Boot}} class):

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
            'hidden' => true,
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

Example content for the `SiteController.php`:

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

Example content for the layout file `views/layouts/main.php`:

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
