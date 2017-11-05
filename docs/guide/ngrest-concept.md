# Admin Modul NgRest CRUD

One of the most powerfull tools in *LUYA*, is the **ANGULAR CRUD** surface, it combines *Angular*, *RESTful*, *CRUD* and *Active Record* in a very elegant and powerfull way. So in a more understable sentence **Generate administration formulars to create, update, delete and list your data very fast and elegant**. It creates an API you can talk trough Angular and you can configure it like an ActiveRecord and also use it like an Active Record Model in your application. Here is an example of an NgRest Crud for Administration Users:

![ngrest-crud-example](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/ngrest-crud-example.jpg "NgRest Crud Example")

The word *NgRest* is explained as follows: A**Ng**ular**Rest** (Representational State Transfer)

![ngrest-crud](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/ngrest-crud.png "NgRest Image")

> **Quick NgRest CRUD setup instructions:**
> 1. Create an (admin) module `./vendor/bin/luya module/create`.
> 2. Add the module to your application config within the modules section (see the generated README.md file in the module).
> 3. Create a migration with a database table `./vendor/bin/luya migrate/create mytable modulename`.
> 4. After preparation the migration file (addTable, fields) run the migration command `./vendor/bin/luya migrate`.
> 5. Run `./vendor/bin/luya crud/create` and provide the needed informations (like module name, table name, etc.).
> 6. Copy the terminal output to the previous generated Module file: `<YOUR_MODULE>/admin/Module.php`.
> 7. Run the import command `./vendor/bin/luya import`
> 8. Set permission in Admin under System -> User groups -> permission

#### Steps to understand and create an NgRest Crud

Preparations:

+ [Create database table via migrations](luya-console.md)
+ [Create an Admin Module](app-admin-module.md) where you can put the NgRest Crud files.

Setup Crud:

1. Create the base model class (combination of Active Record and NgRest Crud defintion) which is used for the api and the controllers
2. Create the Controller and the Api
3. Define and Add the Api-Endpoint to your Module and enable the Authorizations
4. Import and Setup privileges.

## Creating the Model

We assume you have a made a table via the migrations (in your example below we assume you make a team module with members) and executue the migrations so you can no create an `ActiveRecord` model for the provided table. The model represents the datasource for the REST API, you can create the model with the gii module extension or you can also generate the model and the rest of the classes with the `admin/crud/create` cli command.

Lets have close look at what you model should look like, in our member example of the teammodule:

```php
<?php
namespace app\modules\team\models;

class Member extends \luya\admin\ngrest\base\NgRestModel
{
    /**
     * Enable which fields should automatically be available as multilingual fields. Make sure those are text types in db.
     */
    public $i18n = ['text'];
    
    /**
     * Database table name.
     */
    public static function tableName()
    {
        return 'teamadmin_member';
    }
    
    /**
     * Rules definition which are applied when perform insert/update calls.
     */
    public function rules()
    {
        return [
            [['name', 'title', 'text'], 'required'],
            [['name', 'text'], 'string'],
        ];
    }
    
    /**
     * Attribute labels to display form labels.
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'title' => 'Title',
            'text' => 'Text Message',   
        ];
    }
    
    /**
     * @return array An array define the field types of each field.
     */
    public function ngrestAttributeTypes()
    {
        return [
            'name' => 'text',
            'title' => ['selectArray', 'data' => ['Mr', 'Mrs']],
            'text' => 'textarea',
        ];
    }
    
    /**
     * This is the api endpoint for the ngrest implementation, so the ngrest config needs to know where should
     * all the angular calls go.
     */
     public static function ngRestApiEndpoint()
     {
        return 'api-team-member';
     }
     
     /**
      * @return array Returns an array with each scope containing which fields.
      */
     public function ngRestScopes()
     {
         return [
             ['list', ['title', 'name']],
             [['create', 'update'], ['title', 'name', 'text']],
             ['delete', false],
         ];
     }
}
```

You can read more about the configuration of the [[ngrest-model.md]].

## Creating Controller and API

Each NgRest Crud needs an API (to make the rest call, create, update, list which are provided trough [Yii 2 RESTful](http://www.yiiframework.com/doc-2.0/guide-rest-quick-start.html)) and a controller which contains the angular template for your configure `ngRestConfig()`. The API and the Controller are basically only Gateways for the Output and do relate to the ngrest model:

### NgRest Controller

The NgRest Controller will prepare and render the forms based on your model. Therefore define the {{luya\admin\ngrest\base\Controller::$modelClass}} property with fresh created {{luya\admin\ngrest\base\NgRestModel}}.

```php
<?php
namespace app\modules\team\admin\controllers;

class MemberController extends \luya\admin\ngrest\base\Controller
{
    public $modelClass = 'app\modules\team\models\Member';
}
```

In order to extend the settings dropdown menu on right top corner you can define {{luya\admin\ngrest\base\Controller::$globalButtons}} which can interact with angular or a controller action.

```php
public $globalButtons = [
    [
        'icon' => 'extension', 
        'label' => 'Say Hello', 
        'ui-sref' => "default.route({moduleRouteId:'teamadmin', controllerId:'member', actionId:'hello-world'})",
    ]
];
     
public function actionHelloWorld()
{
    return $this->render('hello-world');
}
```

This would generate a new button in the settings dropdown which would call the actionHelloWorld() render and return the output.

### NgRest Api

The API Controller will return the REST formated data from your model.

The API Controller needs to know from what configuration the API should be build from, there fore define the {{luya\admin\ngrest\base\Api::$modelClass}} property with your defined {{luya\admin\ngrest\base\NgRestModel}}.

```php
<?php
namespace app\modules\team\admin\apis;

class MemberController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'app\modules\team\models\Member';
}
```

By default the pagination (pager) will be enabled if the count of rows is more then 250. You can disabled this behavior by turning of the {{luya\admin\ngrest\base\Api::$autoEnablePagination}}.

```php
public $autoEnablePagination = false;
```

and you can also force the api to always generate a pagination by setting {{luya\admin\ngrest\base\Api::$pagination}} property as followed:

```php
public $pagination = ['pageSize' => 100];
```

## Api-Endpoint, Menu & Priviliges

The last part of the ngrest process is to let your application know where your API is located, add them to the admin UI menu and establish permission priviliges in order to manage how can create, delete, update or see the CRUD.

### API Endpoint

To let your application know what apis are registered and where to find them, you have to open the admin module class of the module where the ngrest crud is located and add a linkin entry into the {luya\admin\base\Module::$apis}} property.

```php
<?php
namespace app\modules\team\admin;

class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-team-member' => 'app\modules\team\admin\apis\MemberController',
    ];
}
```

There are a few rules in how to choose the correct API Endpoint name:

+ They always contain the **prefix api**, a **module name** and the **model name**, like `api-<module>-<model>`.
+ They never have an admin prefix in the module name. So even when you have only a `foobaradmin` module, use the name `foobar` for the module, like `api-foobar-<model>`.
+ Always use the **singular** word variation, its not members its **member**, like `api-<module->member`.

### Add to Menu

The store the permission informations of your newly created ngrest crud you have to override the `getMenu()` method of your Module class where the ngrest crud belongs to.

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
    ->node("Team Admin", "account")
        ->group("Manager")
            ->itemApi("Members", "teamadmin/member/index", "extension", "api-teamadmin-member");
}
```

The Icons `account` and `extension` are choosem from the google material icons: https://design.google.com/icons/. You can add as much nodes, groups and items as you want. The first argument of `node`, `group` and `itemApi` as the navigation button display in the administration area, you can wrapp them with Yii::t in order to make internalisations.

### Import and Priviliges

Run the `./vendor/bin/luya import` command in order to add new permissions and menu entries. After the import process is finished, log into your admin interface and set the correct privileges in **System > User > Authorizations** otherwise you won't see the created menu items.
