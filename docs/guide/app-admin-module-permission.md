# Admin Permissions

LUYA provides an out of the box permission system. Menu entries are bound to the permission system, but you can also define custom permissions. In order to update permissions run the `import`console command, then all permissions will be stored in the database and you can allocat them to a user group.

Permissions are commonly part of the {{luya\admin\base\Module::getMenu}} method but can also be defined in {{luya\admin\base\Module::extendPermissionApis}} or {{luya\admin\base\Module::extendPermissionRoutes}}.

## The Menu

Each Admin modules does have {{luya\admin\base\Module::getMenu()}} method where you can put your Module Navigation into. The response must be an instance of {{luya\admin\components\AdminMenuBuilder}}.

![menu](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/admin-menu-structure.jpg "LUYA Menu")

+ (1) node: Menu top level (root) entry.
+ (1) nodeRoute: Top level node which directly redirects to a custom module route.
+ (2) group: The group name of items.
+ (3) itemRoute: An item inside a group to a custom route.
+ (3) itemApi: An item inside a group to an ngrest API.

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
    ->node("My Admin Module", "materialize-css-icon")
        ->group("Group")
            ->itemRoute("Stats", "myadminmodule/stats/index", "materialize-css-icon") // An example for a custom route
            ->itemApi('Users', 'admin/user/index', 'materialize-css-icon', 'api-admin-user') // An example for en NgRest Api
    ->nodeRoute('Root Custom URL', 'materialize-css-icon', 'admin/templates/mytemplate', 'module/controller/route');

}
```

> Here you can find the [All available Material Icons](https://material.io/icons/).

Please see the {{luya\admin\components\AdminMenuiBuilder api documentation for full reference on what the method arguments does.

## Route and Api permssions without Menu

You can also setup permissions which are not regulated trough {{luya\admin\base\Module::getMenu}}, therefore configurate the {{luya\admin\base\Module}} class and override the following methods:

```php
public function extendPermissionApis()
{
    return [
        ['api' => 'api-cms-moveblock', 'alias' => 'Move blocks'],
    ];
}
```

The above api `api-cms-moveblock` is now protected by the administration authorization system and you can allocate who is able to edit, create and delete performing.

```php
public function extendPermissionRoutes()
{
    return [
        ['route' => 'cmsadmin/page/create', 'alias' => 'Page Create'],
        ['route' => 'cmsadmin/page/update', 'alias' => 'Page Edit'],
    ];
}
```

The above *module/controller/action* route is now protected by administration authorization.


## Disable controller permission

Inside of each {{luya\web\Controller}} abstracted class you can disable the permission check be enabling(overriding) the property {{luya\web\Controller::$disablePermissionCheck}}. This means all **logged in users** can access this controller, but guest (nog logged in users) are still not allowed to see this controller.

```php
class MyTestController extends \luya\admin\base\Controller
{
    public $disablePermissionCheck = true;
    
    public function actionIndex()
    {
        // This action can be performed by all logged in admin users, but not guest users.
    }
}
```

## Internal permission calculation

There are 3 state of permssions, each has its integer value.

|Name          |Value
|------        |----
|crud_create   |1
|crud_update   |3
|crud_delete   |5

The following table shows you the different permission state and combinations:

|create    |update    |delete    |Value         |Description
|---       |---       |---       |---           |----
|☐         |☐         |☐         |0             |No permission
|☑         |☐         |☐         |1             |create
|☐         |☑         |☐         |3             |update
|☑         |☑         |☐         |4             |create, update
|☐         |☐         |☑         |5             |delete
|☑         |☐         |☑         |6             |create, delete
|☐         |☑         |☑         |8             |update, delete
|☑         |☑         |☑         |9             |create, update, delete

