# Admin module NgRest CRUD

One of the most powerful tools in *LUYA*, is the **AngularJS C** surface. It combines *AngularJS*, *RESTful*, *CRUD* and *Active Record* in a very elegant and powerful way.
So in a more understandable sentence **Generate administration forms to create, update, delete and list your data very fast and elegant**. It creates an API you can talk trough via AngularJS and you can configure it like an ActiveRecord and also use it like an Active Record Model in your application. Here is an example of an NgRest Crud for admin UI users:

![ngrest-crud-example](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/ngrest-crud-example.jpg "NgRest Crud Example")

The word *NgRest* is explained as follows: A**Ng**ular**Rest** (Representational state transfer)

![ngrest-crud](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/ngrest-crud.png "NgRest Image")

> **Quick NgRest CRUD setup instructions:**
> 1. Create a (admin) module `./vendor/bin/luya module/create`.
> 2. Add the module to your application config within the modules section (see the generated README.md file in the module).
> 3. Create a migration with a database table `./vendor/bin/luya migrate/create mytable modulename`.
> 4. After preparation of the migration file (adding table and fields) run the migration command `./vendor/bin/luya migrate`.
> 5. Run `./vendor/bin/luya admin/crud/create` and provide the needed information (like module name, table name, etc.).
> 6. Copy the terminal output to the previous generated module file: `<YOUR_MODULE>/admin/Module.php`.
> 7. Run the import command `./vendor/bin/luya import`
> 8. Set permission in admin UI under `System -> User groups -> Permission`

#### Steps to understand and create an NgRest CRUD

Preparations:

+ [Create database table via migrations](luya-console.md)
+ [Create an Admin Module](app-admin-module.md) where you can put the NgRest CRUD files.

Setup CRUD:

1. Create the base model class (combination of Active Record and NgRest CRUD definition) which is used for the api and the controllers
2. Create the controller and the API
3. Define and add the API endpoint to your module and enable the authorizations
4. Import and setup privileges.

## Creating the model

We assume you have a made a table via the migrations (in your example below we assume you make a team module with members) and execute the migrations. Now you can create an `ActiveRecord` model for the provided table. The model represents the data source for the REST API, you can create the model with the gii module extension or you can also generate the model and the rest of the classes with the `admin/crud/create` cli command.

Lets have a closer look how your model should look like, in our member example of the team module:

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
     * This is the api endpoint for the NgRest implementation, so the NgRest config needs to know where should
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

## Creating controller and API

Each NgRest CRUD needs an API (to make the REST call, create, update, list which are provided trough [Yii 2 RESTful](http://www.yiiframework.com/doc-2.0/guide-rest-quick-start.html)) and a controller which contains the AngularJS template for your `ngRestConfig()`. The API and the controller are basically only gateways for the output and do relate to the NgRest model:

### NgRest Controller

The NgRest controller will prepare and render the forms based on your model. Therefore define the {{luya\admin\ngrest\base\Controller::$modelClass}} property with fresh created {{luya\admin\ngrest\base\NgRestModel}}.

```php
<?php
namespace app\modules\team\admin\controllers;

class MemberController extends \luya\admin\ngrest\base\Controller
{
    public $modelClass = 'app\modules\team\models\Member';
}
```

In order to extend the settings dropdown menu on right top corner you can define {{luya\admin\ngrest\base\Controller::$globalButtons}} which can interact with AngularJS or a controller action.

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

### NgRest API

The API controller will return the REST formatted data from your model.

The API controller needs to know from which configuration of the API it should be build from, therefore define the {{luya\admin\ngrest\base\Api::$modelClass}} property with your defined {{luya\admin\ngrest\base\NgRestModel}}.

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

You can also force the API to always generate a pagination by setting {{luya\admin\ngrest\base\Api::$pagination}} property as followed:

```php
public $pagination = ['pageSize' => 100];
```

## API endpoint, menu and privileges

The last part of the NgRest process is to let your application know where your API is located. Add them to the admin UI menu and establish the permission privileges in order to manage how can create, delete, update or see the CRUD.

### API endpoint

To let your application know which API´s are registered and where to find them. You have to open the admin module class of the module where the NgRest CRUD is located and add a linking entry into the {luya\admin\base\Module::$apis}} property.

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

There are a few rules in how to choose the correct API endpoint name:

+ They always contain the **prefix api**, a **module name** and the **model name**, like `api-<module>-<model>`.
+ They never have an admin prefix in the module name, e.g. even when you have only a `foobaradmin` module use the name `foobar` for the module like `api-foobar-<model>`.
+ Always use the **singular** word variation because it is not members it is a **member**, e.g. like `api-<module->member`.

### Add to menu

To store the permission information of your newly created NgRest CRUD you have to override the `getMenu()` method of your module class where the NgRest CRUD belongs to.

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
    ->node("Team Admin", "account")
        ->group("Manager")
            ->itemApi("Members", "teamadmin/member/index", "extension", "api-teamadmin-member");
}
```

The icons `account` and `extension` have been chosen from the google material icons: https://design.google.com/icons/. You can add as much nodes, groups and items as you want. The first argument of `node`, `group` and `itemApi` as the navigation button display in the admin UI. You can wrap them with Yii::t in order to make internalisation available.

### Import and privileges

Run the `./vendor/bin/luya import` command in order to add new permissions and menu entries. After the import process is finished, log into your admin UI and set the correct privileges in **System > User > Authorizations** otherwise you won't see the created menu items.
