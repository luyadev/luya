LUYA
======================

**Table of contents**

1. [Boot](#boot)
2. [Routing](#routing)
3. [Module Abstracting](#module-abstracting)
4. [SQL Migration](#sql-migration)
5. [Configuration](#configuration)
6. [View](#view)
7. [Bootstrapping](#bootstraping)
8. [Standards](#standards)
9. [Required Components](#required-components)
10. [Module Assets](#module-assets)
11. [Admin User Login](#admin-user-login)
12. [Admin Active Rest API](#admin-active-rest-api)
13. [Admin Rest API](#admin-rest-api)
14. [Admin API Controllers](#admin-api-controllers)
15. [Admin Get Menu Array](#admin-get-menu-array)
16. [Rest Model](#rest-model)



BOOT
----

### The Problem

1. The console/cli application requires a configuration which is most likely a copy of the web configuration. You will endup in copy pasting stuff between two files.
  1. You could sepearte global config parts into a single file and include this on each configuration file - this will end up in a mess if you have different configurations for different servers (example: local config, prep config, production config, other developers local config, etc.)
2. add additional funcionality to the index.php when the "product" is delivered to multiple customers would end in copy pasting code parts from repository to other repositorys

### The Solution

A Wrapping class called \luya\base\Boot which wrappes the (1.) boot/startup functionality for both web and cli modes. A wrapping class to extend functionality (2.) in later point in time.

This is what a index.php should like like

```php
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

use \luya\base\Boot;

$config = include('../configs/prep.php');

$boot = new Boot();
$boot->setConfig(Boot::SAPI_WEB, $config);
$boot->setConfig(Boot::SAPI_CLI, $config);
$boot->run();
```

all the luya configuration parts (see CONFIGURATION) are already loaded for each boot mode. So the configuration file (in this case config/prep.php) does only contain customer related informations like: modules, id, basePath, defaultRoute, components, etc..


ROUTING
--------------------

### The Problem

A module can not provide a routing rule for itself, all the routing informations has to be done in the configuration file. So you will end up in copy pasting module rules to other projects. UGLY!

### The Solution

The cyzm\base\UrlRule (which is included by default when booting which (\luya\base\Boot) (see [Boot](#boot)) will take care of all the routing infomrations. If a module is loaded which exists, it will extend the UrlRule (if exists) of this module.

What happends during the load cycle of luya?

1. We have a request [http://www.example.com/de/page/subpage]
2. The luya UrlManger verifys if the first parameter (between the first //) is a module. If its a module, skip step 2a.
  1. Its not a Module, so we load the default module from the config defaultRoute
3. Lets see if this Module does have a routing file (components/UrlRule.php).
  1. Yes: We load the module specific Routing rules. (defined controller/action with parameters)
  2. No: We proceed with the default Yii module/controller/action shema, which is: <module>/DefaultController/actionIndex
4. Load controller and render view



MODULE ABSTRACTING
------------------------

### The Problem

1. Not able to get the namespace BASE of a module (like: \app\modules\news or via composer loaded \admin).
2. Providing additional functionality on modules later on when already lot of modules are developed.

### The Solution

We have added a wrapper class for \yii\base\Module which is (2.) \luya\base\Module which provides the newly added getModuleNamespace() (1.) to resolve the module namespace BASE path.

To declare if an application is an Admin Module, we have to extend the "luya\base\Module" class. The Module class of this example news module would look like this:

```php
namespace news;

class Module extends \luya\base\Module
{
	...
}
```



SQL MIGRATION
-------------------------

### The Problem

Each module can have its own migration scripts, but by default of Yii2 the migration scripts can only be created into the application folder (@app/migrations), and also only be loaded (migration/up) from this location.

### The Solution

We changed the controllerNamespace in the console config to point into the "luya/commands" folder. There we have a migrate command which overwrites the Yii2 migrationController to support migrations for each modul.
Now all modules can contain their own migrations scripts inside the module folder structure (ex. <ModuleName>/migrations).

### Run migrations
```php
/*
 * will create a migration script into the application folder
 */
./vendor/bin/luya migrate/create fooMigration

/*
 * will create a migration script into the module "news" 
 * (only for dev usage. Modules are loaded via composer into the vendor folder. It does not make sense to create a migration script into the vendor/zephir/<module>/migrations)
 */
./vendor/bin/luya migrate/create fooMigration news

/*
 * will run the all the migration scripts over all the assigned modules
 */
./vendor/bin/luya migrate/up
```



CONFIGURATION
-------------------------

Those configuration informations are automatically set by \luya\base\Boot

Automaticaly informations set for mode: web

```php
	...
	'components' => [
		'urlManager' => 'luya\components\UrlManager'
	]
	...
```

Automaticaly informations set for mode: console/cli

```php
	...
	'controllerNamespace' => 'luya\commands'
	....
```

Your project configuration does only contain customer related informations, but you have to load first the luya module.

Example project/customer:

```php
	'id' => '<CUSTOMER_PROJECT_ID>',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'cms', // your default module
    'modules' => [
        'luya' => 'luya\Module',
        'admin' => 'admin\Module',
        'cms' => 'cms\Module',
        'news' => 'app\modules\news\Module'
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2-test',
            'username' => 'root',
            'password' => '...',
            'charset' => 'utf8'
        ]
    ]
	...
```



VIEW
--------------------

### The Problem

If you register a new module which is going to be used in the front (e.g. news), the templates associated to this module should be defined in the customer repository (at least if you want to). Because the view files could be different between projects.

### The Solution

By adding a wrapper class (luya\base\Controller) for the yii controller (yii\web\Controller) we can provided an overwritten getViewPath() method which always targets to @app/views/<module>/<controller>/, all the template will be located in there.
At the other side we can still go back to use yii default controller behaviour with adding the public method "public $useModuleViewPath = true;"

### Example

Module with templates in @web directory

```php
namespace cms\controllers;

class DefaultController extends \luya\base\Controller
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
```

Module with templates inside the modules (default Yii solution)

```php
namespace capsulated\controllers;

class DefaultController extends \luya\base\Controller
{
	public $useModuleViewPath = true;

	public function actionIndex()
	{
		return $this->render("index");
	}
}
```

BOOTSTRAPPING
---------------------

### The Problem

Accessing the modules is not easy, because some modules where loaded via composer, some directly from the @web root. Missing alias informations for paths.

### The Solution

(not finished yet) Using a Bootstrap class loaded directly in the config (via luyae\Boot\config\web.php) can list all modules, create an instance and return the basePath. (!!! not the best approach yet, cause its ending in preloading all the modules. speed issue?)

STANDARDS
----------

see -> [CONVENTIONS](CONVENTION_LANGUAGE.md)


REQUIRED COMPONENTS
--------------------

each module can have required components which will be checked while loading the application.

Example

```php
class Module extends \luya\base\Module
{
	...
	public requiredComponenets = ['db', 'foo', 'bar'];
	...
}
```

MODULE ASSETS
--------------

Each modul can have its own asset bundles. To define them use the $assets array inside the Module. E.g News module with asset Bundle in the module root directory Asset.php.

```php
class Module extends \luya\base\Module
{
	...
	public $assets = [
		'\news\Asset'
	];
}
```

The Asset files itself (.../module/news/Asset.php) could look something like this (where the files are stored in .../module/news/asset/<FILES>):

```php
class Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@news/assets';
    
    public $css = [
        "css/style.css",
        "//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"
    ];
    
    public $js = [
        "//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js",
        "//ajax.googleapis.com/ajax/libs/angularjs/1.2.3/angular.min.js",
        "js/data.js"
    ];
    
    public $publishOptions = ['forceCopy' => true]; // debugging purpose only
}
```

***Admin Module assets

If an asset is defined in an admin context (example the cmsadmin does have an Asset.php ans is defined in Module.php), we automaticcaly add those files into the admin\base\controller. This is becuase the page will only be loaded once at the beginning (angular admin).

ADMIN USER LOGIN
----------------

### The Problem

If you want to use the yii way of user authentification, all the informations are stored in the user component \yii::$app->user. This variable is reserved for frontend authentification, we gona use another component.

### The Solution

We have a user object for all the admin (backend) authentifications. 

The User Class (like yii::$app->user)

```php
<?php
namespace admin\components;

class User extends \yii\web\User
{
    public $identityClass = '\admin\models\User';
    
    public  $loginUrl = ["admin/login"];
    
    public $identityCookie = ['name' => '_adminIdentity', 'httpOnly' => true];
}
```

to use this class we have to provide the class information in the behaviour settings

```php
public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user' => '\admin\components\User',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ]
                ]
            ]
        ];
    }
```
@Todo: remove code which will be copied into all the other controllers (put into controll abstraction or build own access class)

To Access the user component like in the yii way \yii::$app->user we have created a public variable in the admin abstract controller called $adminUser. 

Example request for permission
```php
	if (!$this->adminUser->isGuest) { ... }
```

Example soting login informations
```php
	if (($userObject = $model->login()) !== false) {
        $this->adminUser->login($userObject);
    } else {
    	...
	}
```

ADMIN ACTIVE REST API
--------------

### The Problem

There is not really a problem, but the integration of access_tokens which the Yii ActiveRestcontroller deliver is built into the system over the \yii::$app->user variable.

### The Solution

We have no build a yii ActiveRestController wrapper which takes the admin modules user authentification.

The Wrappting RestController (\admin\base\RestController) with extended user class:
```php
class RestActiveController extends \yii\rest\ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'user' => new \admin\components\User()
        ];
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'user' => new \admin\components\User()
        ];
        return $behaviors;
    }
}
```

Example of a Controller:
```php
<?php

namespace admin\controllers;

class UserController extends \admin\ngrest\base\Api
{
    public $modelClass = 'admin\models\User';
}
```

ADMIN REST API
--------------

Same like ADMIN ACTIVE REST API but not based on a model. Its based on any array data.

```php
namespace admin\apis;

use yii;

class MenuController extends \admin\base\RestController
{
    public function actionIndex()
    {
        return [
        	['foo' => 'bar'],
        	['foo' => 'baz']
        ];
    }
}
```


ADMIN API CONTROLLERS MAPPING
-----------------------------

All the rest api controllers are located in "<module_name>/apis/". For example the category api inside a news module would be placed into: "newsadmin/apis/CategoryController.php".
To let the module know where we have put the Controller we make an entry in the modules apis() array. All api mappings must be prefixed with "api-{module}-", otherwise we can not have a unique routing.
Admin Api pluralizining is disabled. The location to open this controlle would be:
```
http://domain.com/admin/api-news-category
```

It means all the APIs needs to be called with <SERVER>admin/api-<module>-<modelname>. 

***Why are all apis access via the admin module but are "physically" located in theyr modules?***

Cause all apis nots an access-token, otherwise we can not guarantee all the needed security. So all the apis does require the admin module (which alos provides the functionaly abstraction classes). Another point of decision to have all apis accessed via the admin module url is to have an unique access point otherwise you would have a mess of urls.


$controllerMap inside the Module.php:
```php
    public $controllerMap = [
        'api-news-category' => 'newsadmin\apis\CategoryController'
    ];
```

ADMIN GET MENU ARRAY
--------------------

All administration modules does have a public function getmMenu(). The encoded version (just for understanding purpose)
```php
$menu = [
    'admin' => [
        'alias' => 'Administration',
        // Gruppe 1
        [
            'name' => 'Gruppe 1',
            'items' => [
                'menu1' => [
                    'alias' => 'Menu Punkt 1'
                ],
                'menu2' => [
                    'alias' => 'Menu Punkt 2'
                ]
            ]
        ],
        // Gruppe 2
        [
            'name' => 'Gruppe 2'
        ]
    ]
];
return $menu;
```

The menu should be genearted with the available menu methods, like:
```php
public function getMenu()
{
    // create menu node
    $node = $this->menu->createNode('admin', 'Administration', 'fa-gear');
    // create menu group
    $this->menu->createGroup($node, 'Verwalten', [
        // insert group items
        $this->menu->createItem("user", "Benutzer", "admin:user:index", "fa-user"),
        $this->menu->createItem("group", "Gruppen", "admin:group:index", "fa-users")
    ]);
    
    return $this->menu->get();
}
```


REST MODEL
----------------------

All the rest models does need to have two scenarios: ***restcreate*** and ***restupdate***.

example scenario
```php
public function scenarios()
{
    return [
        'restcreate' => ['title', 'firstname', 'lastname', 'email', 'password'],
        'restupdate' => ['title', 'firstname', 'lastname', 'email'],
        'login' => ['email', 'password']
    ];
}
```

example rules
```php
public function rules()
{
    return [
        [['title', 'fristname', 'lastname', 'email', 'password'], 'required', 'on' => 'restcreate'],
        [['title', 'firstname', 'lastname', 'email'], 'required', 'on' => 'restupdate'],
        [['email', 'password'], 'required', 'on' => 'login'],
        ['password', 'verifyPassword']
    ];
}
```

creating an event in the initializer of the model to observe BEFORE/AFTER INSERT/UPDATE methods

```php
$this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
```

Performing a specific database where request for the REST MODEL item foreach, just override find()
```php
public static function find()
{
    return parent::find()->where(['is_deleted' => 0]);
}
```

expendable datainformations
```php
public function getGroups() {
    return $this->hasMany(\admin\models\Group::className(), ['id' => 'group_id'])
    ->viaTable('admin_user_group', ['user_id' => 'id']);
}

public function extraFields()
{
    return ['groups'];
}
```