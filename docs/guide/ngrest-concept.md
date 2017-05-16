# Admin Modul NgRest CRUD

One of the most powerfull tools in *LUYA*, is the **ANGULAR CRUD** surface, it combines *Angular*, *RESTful*, *CRUD* and *Active Record* in a very elegant and powerfull way. So in a more understable sentence **Generate administration formulars to create, update, delete and list your data very fast and elegant**. It creates an API you can talk trough Angular and you can configure it like an ActiveRecord and also use it like an Active Record Model in your application. Here is an example of an NgRest Crud for Administration Users:

![ngrest-crud-example](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/ngrest-crud-example.jpg "NgRest Crud Example")

The word *NgRest* is explained as follows: A**Ng**ular**Rest** (Representational State Transfer)

> In order to create a NgRest CRUD setup: Create an admin module (`./vendor/bin/luya module/create`), create a migration  with a database table (`./vendor/bin/luya migrate/create mytable modulename`) and the run `./vendor/bin/luya admin/crud/create`.

![ngrest-crud](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/ngrest-crud.png "NgRest Image")

#### Steps to understand and create an NgRest Crud

Preparations:

+ [Create database table via migrations](luya-console.md)
+ [Create an Admin Module](app-admin-module.md) where you can put the NgRest Crud files.

Setup Crud:

1. Create the base model class (combination of Active Record and NgRest Crud defintion) which is used for the api and the controllers
2. Create the Controller and the Api
3. Define and Add the Api-Endpoint to your Module and enable the Authorizations
4. Import and Setup privileges.

## 1. The Model

We assume you have a made a table via the migrations (in your example below we assume you make a team module with members) and executue the migrations so you can no creat an `ActiveRecord` model for the provided table. The model represents the datasource for the REST API, you can create the model with the gii module extension or you can also generate the model and the rest of the classes with the `admin/crud/create` cli command.

Lets have close look at what you model should look like, in our member example of the teammodule:

> In order to read more about configuration and other abilitys to customize your CRUD read the [NgRest Model Config Section](ngrest-model.md).

```php
<?php
namespace teamadmin\models;

class Member extends \luya\admin\ngrest\base\NgRestModel
{
    /**
     * Yii2 related ActiveRecord code
     */
    public static function tableName()
    {
        return 'teamadmin_member';
    }
    
    /**
     * Yii2 related ActiveRecord code
     */
    public function rules()
    {
        return [
            [['name', 'title', 'text'], 'required'],
        ];
    }
    
    /**
     * Yii related ActiveRecord code
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'title' => 'Title',
            'text' => 'Text Message',   
        ];
    }
    
    /* NGREST SPECIFIC CONFIGURATIONS */
    
    /**
     * Enable which fields should automaticcally be available as multilingual fields!
     */
    public $i18n = ['text'];
    
    /**
     * @return array An array define the field types of each field
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
      *
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

You can read more about the configuration of the NgRest in [NgRest Model Guide](ngrest-model.md).

## 2. Controller and API

Each NgRest Crud needs an API (to make the rest call, create, update, list which are provided trough [Yii 2 RESTful](http://www.yiiframework.com/doc-2.0/guide-rest-quick-start.html)) and a controller which contains the angular template for your configure `ngRestConfig()`. The API and the Controller are basically only Gateways for the Output and do relate to the ngrest model:

### NgRest Controller

Example of an ngrest controller (which are located in `<module>/controllers`):

```php
<?php
namespace teamadmin\controllers;

class MemberController extends \luya\admin\ngrest\base\Controller
{
    public $modelClass = 'teamadmin\models\Member';
}
```

### NgRest Api

Example of an api controller (which are located in `<module>/apis`):

```php
<?php
namespace news\apis;

class MemberController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'teamadmin\models\Member';
}
```

By default the pagination (pager) will be enabled if the count of rows is more then 250. You can disabled this behavior by turning of the `$autoEnablePagination`

```php
public $autoEnablePagination = false;
```

and you can also force the api to always generate a pagination by setting `$pagination` property as followed:

```php
public $pagination = ['pageSize' => 100];
```

## 3. Api-Endpoint & Authorization

The last part of the ngrest process is the let your application know where your api is located (Yii2 controller namespace) and to make permission entries for the ngrest (who can create, update, delete and see the crud).

### Endpoint

To let your application know what apis are registered you have to open the Module class of the module where the ngrest crud is located and add a linkin entry into the `$apis` propertie.

```php
<?php
namespace teamadmin;

class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-team-member' => 'teamadmin\apis\MemberController',
    ];
}
```

There are a few rules while defining the api endpoint name:

+ An Endpoint is always build like `api-<module>-<model>` where *<module>* is always the frontend module.
+ API Endpoints does never have an admin prefix in the module, by defintion. So event when you have only one module `foobaradmin` the choosen module name for the endpoint would be `foobar`.
+ APIs are alaways **singular** described, its not ~~members~~ its *member*.

### Menu

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

## 4. Import and Priviliges

Run `./vendor/bin/luya import`, open the administration area and allocate the new menu items to a group. 

> Don't forget to set the correct privileges in `System > User > Authorizations` otherwise you won't see the created menu items!
