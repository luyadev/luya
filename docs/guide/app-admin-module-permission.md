# Admin permissions

LUYA provides an out of the box permission system. Menu entries are bound to the permission system but you can also define custom permissions. In order to update permissions run the `./vendor/bin/luya import` command which will restore all permissions in the database that you can allocate them to a user group.

Permissions are commonly part of the {{luya\admin\base\Module::getMenu()}} method but can also be defined in {{luya\admin\base\Module::extendPermissionApis()}} or {{luya\admin\base\Module::extendPermissionRoutes()}}.

## The menu

Each admin module does have a {{luya\admin\base\Module::getMenu()}} method where you can put your module navigation. The response must be an instance of {{luya\admin\components\AdminMenuBuilder}}.

![menu](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/admin-menu-structure.jpg "LUYA Menu")

+ ➀ node: Menu top level (root) entry.
+ ➀ nodeRoute: Top level node which directly redirects to a custom module route.
+ ➁ group: The group name of items.
+ ➂ itemRoute: An item inside a group to a custom route.
+ ➂ itemApi: An item inside a group to an NgRest API.

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
    ->node("My Admin Module", "material-icon")
        ->group("Group")
            ->itemRoute('Stats', 'myadminmodule/stats/index', 'material-icon') // An example for a custom route
            ->itemApi('Users', 'admin/user/index', 'material-icon', 'api-admin-user') // An example for en NgRest API
    ->nodeRoute('Root Custom URL', 'material-icon', 'module/controller/route');

}
```

> Here you can find the [all available Material Icons](https://material.io/icons/).

Please have a look at the {{luya\admin\components\AdminMenuBuilder}} API documentation for the full references what the method and arguments are doing.

## Route and API permissions without menu

You can also setup permissions which are not regulated trough {{luya\admin\base\Module::getMenu()}}, therefore configure the {{luya\admin\base\Module}} class and override the following methods:

```php
public function extendPermissionApis()
{
    return [
        ['api' => 'api-cms-moveblock', 'alias' => 'Move blocks'],
    ];
}
```

The above api `api-cms-moveblock` is now protected by the admin UI authorization system and you can allocate which user group roles are able to edit, create and delete.

```php
public function extendPermissionRoutes()
{
    return [
        ['route' => 'cmsadmin/page/create', 'alias' => 'Page Create'],
        ['route' => 'cmsadmin/page/update', 'alias' => 'Page Edit'],
    ];
}
```

The above *module/controller/action* route is now protected by admin UI authorization.


## Disable controller permission

Inside of each {{luya\web\Controller}} abstracted class you can disable/override the permission check be enabling the property {{luya\web\Controller::$disablePermissionCheck}}. This means all **logged in users** can access this controller but guest (not logged in users) are still not allowed to see this controller.

```php
class MyTestController extends \luya\admin\base\Controller
{
    public $disablePermissionCheck = true;
    
    public function actionIndex()
    {
        // This action can be performed by all logged in admin users but not guest users.
    }
}
```

## Internal permission calculation

There are 3 state of permissions each has it´ s own integer value.

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

