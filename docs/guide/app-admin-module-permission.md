# Admin Permissions

LUYA provides an out of the box permission system. Menu entries are bound to the permission system, but you can also define custom permissions. In order to update permissions run the `import`console command, then all permissions will be stored in the database and you can allocat them to a user group.

Permissions are commonly part of the {{luya\admin\base\Module::getMenu}} method but can also be defined in {{luya\admin\base\Module::extendPermissionApis}} or {{luya\admin\base\Module::extendPermissionRoutes}}.

### Custom Menu-Route

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
    ->node("My Admin Module", "materialize-css-icon")
        ->group("Verwalten")
            ->itemRoute("Stats", "myadminmodule/stats/index", "materialize-css-icon")
            ->itemRoute("Export", "myadminmodule/stats/export", "materialize-css-icon");
}
```

Menu-Api
-------

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
    ->node('Administration', 'materialize-css-icon')
        ->group('Zugriff')
            ->itemApi('Users', 'admin/user/index', 'materialize-css-icon', 'api-admin-user')
            ->itemApi('Groups', 'admin/group/index', 'materialize-css-icon', 'api-admin-group')
        ->group('System')
            ->itemApi('Languages', 'admin/lang/index', 'materialize-css-icon', 'api-admin-lang');
}
```

Disable controller permission
-----------------------------

Inside of each `luya\web\Controller` abstracted class you can disable the permission check be enabling(overriding) the property `public $disablePermissionCheck = true;`. This means all **logged in users** can access this controller, but guest (nog logged in users) are still not allowed to see this controller.

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

Route and Api permssions without Menu
------------------------------------

You can also setup permissions which are not regulated trough `getMenu()`, to do so you open the Module class and override the following methods:

```php
public function extendPermissionApis()
{
    return [
        ['api' => 'api-cms-moveblock', 'alias' => 'Move blocks'],
    ];
}
```

The above api `api-cms-moveblock` is now protected by the administration authorization system and you can allocate who is able to edit,create and delete performing.

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

Internal permission calculation
--------------------------------

There are 3 state of permssions who got their assign values:

| Name          | Value
| ------        | ----
| crud_create   | 1
| crud_update   | 3
| crud_delete   | 5


In order to combine thos values you will get those values:

| create    | update    | delete    | Value          | Description
| ---       | ---       | ---       | ---           | ----
| ☐         | ☐         | ☐         | 0             | No permission
| ☑         | ☐         | ☐         | 1             | create
| ☐         | ☑         | ☐         | 3             | update
| ☑         | ☑         | ☐         | 4             | create, update
| ☐         | ☐         | ☑         | 5             | delete
| ☑         | ☐         | ☑         | 6             | create, delete
| ☐         | ☑         | ☑         | 8             | update, delete
| ☑         | ☑         | ☑         | 9             | create, update, delete

