Admin Permission
---------------

The permissions are handled in `getMenu()` method inside your `Module.php`:

Example with custom  routes
```php
public function getMenu()
{
    return $this
    ->node("My Admin Module", "materialize-css-icon")
        ->group("Verwalten")
            ->itemRoute("Stats", "myadminmodule/stats/index", "materialize-css-icon")
            ->itemRoute("Export)", "myadminmodule/stats/export", "materialize-css-icon")
    ->menu();
}
```

Example with apis
```php
public function getMenu()
{
    return $this
    ->node('Administration', 'mdi-navigation-apps')
        ->group('Zugriff')
            ->itemApi('Benutzer', 'admin-user-index', 'mdi-action-account-circle', 'api-admin-user')
            ->itemApi('Gruppen', 'admin-group-index', 'mdi-action-account-child', 'api-admin-group')
        ->group('System')
            ->itemApi('Sprachen', 'admin-lang-index', 'mdi-action-language', 'api-admin-lang')
    ->menu();
}
```

you can also also set `disablePermissionCheck` to true inside your admin controller to avoid rights managmenet:
```php
namespace myadmin\controllers;

class MyTestController extends \admin\base\Controller
{
	
	public $disablePermissionCheck = true;
	
	public function actionIndex()
	{
		// this method will not be checked by permission, but will check if a logged in user request the action.
	}
}
```

extend permission inside your Module.php

```php
public function extendPermissionApis()
{
    return [
        ['api' => 'api-cms-navitempageblockitem', 'alias' => 'Create and Move blocks'],
    ];
}

public function extendPermissionRoutes()
{
    return [
        ['route' => 'cmsadmin/page/create', 'alias' => 'Create Page'],
        ['route' => 'cmsadmin/page/update', 'alias' => 'Update Page'],
    ];
}
```