# Admin permissions

LUYA provides an out of the box permission system. Menu entries are bound to the permission system but you can also define custom permissions. In order to update permissions run the `./vendor/bin/luya import` command which will restore all permissions in the database that you can allocate them to a user group.

Permissions are commonly part of the {{luya\admin\base\Module::getMenu()}} method but can also be defined in {{luya\admin\base\Module::extendPermissionApis()}} or {{luya\admin\base\Module::extendPermissionRoutes()}}.

In order to make wording clear in this guide section:

+ Authentication: This means you have to provide an access token, bearer auth header or session based authentication mechanism in order to access the given resource.
+ Permission: This means an API or WEB-Route is stored in the LUYA ADMIN permission system and can be associated to given groups which can be then associated to users (both users and api users). For example, users can be edited, added and deleted.
+ User vs API User: API Users are not able to login in the Admin UI, while Users do. There are also other limitations, like API Users can not access actions without permission entries, if disabled (which is by default)
+ REST/API vs WEB: A REST/API Controller will return JSON or XML formatted content and authentication must be done via token, while a web controller returns html (scalar values) and authentication is done trough session cookie.
+ Permission Routes: Permission entry for {{luya\admin\base\RestController}} and {{luya\admin\base\Controller}}.
+ Permission Apis: Permission entry for {{luya\admin\base\RestActiveController}}

## The menu

To see the module in the admin menu, please enable permission for installed module, without assignment the module will not appear in menu view. You can enable permissions under menu item Settings -> Groups -> click on permission (icon on right side -> mouse over) in the Entries tab, and assign permission.

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

## REST/API vs WEB Controller

There are different controllers which can be extended, but they have different permission systems. Some use `routes` and others take `apis` as permission level.

+ {{luya\admin\base\Controller}}: This is a WEB controller and permission is handled trough `routes`. Those controllers usually return html content and not REST responses (like json).
+ {{luya\admin\base\RestController}}: The RestController can take `routes` as permission, route validation can be done trough {{luya\admin\base\RestController::checkRouteAccess()}}. The controller requies response of array data (json response).
+ {{luya\admin\base\RestActiveController}}: The modelClass based ActiveController which implements basic REST behaviors like create,update,view and delete based on a given model. The permission is authorized trough `apis` and the implementation of {{luya\admin\base\RestActiveController::checkAccess()}}.

## Custom Actions in REST/Api Controllers

The handling of permissions is different for {{luya\admin\base\RestController}} and {{luya\admin\base\RestActiveController}} even though both are REST/Api Controllers. Also the handling of whether the API request is made from {{luya\admin\models\ApiUser}} or a "admin ui" {{luya\admin\models\User}} differs. The API user default behavior to grant actions without permission is defined in {{luya\admin\Module::$apiUserAllowActionsWithoutPermissions}}.

### RestController

The {{luya\admin\base\RestController}} contains by default **no permission** unless the action is defined in {{luya\admin\base\Module::extendPermissionRoutes()}}. This means that any authenticated user will have access to the action unless a extend permission route is provied. If {{luya\admin\Module::$apiUserAllowActionsWithoutPermissions}} is enabled, also Api Users will have access, by default api users won't have access.

The current permission route is resolved by the {{luya\admin\base\RestController::permissionRoute()}} action.

```php
class TestRestController extends luya\admin\base\RestController
{
    
    public function actionDogs()
    {
        return ['rocky', 'billy'];
    }
    
    public function actionCats()
    {
        return ['sheba', 'whiskas'];
    }
}
```

Assuming the module name is `pets` the requested routes would be `pets/test-rest/dogs` and `pets/test-rest/cats`

```php
class Pets extends luya\admin\base\Module
{
     public function extendPermissionRoutes()
     {
         return [
             ['route' => 'pets/test-rest-dogs', 'alias' => 'Dogs Action']
         ];
     }
}
```

Now the action route `pets/test-rest/dogs` can only accessed when the user has the certain permission assigned, but `pets/test-rest/cats` can be accessed by any authenticated user. If  {{luya\admin\Module::$apiUserAllowActionsWithoutPermissions}} is enabled, even Api Users could access the endpoint.

In order to turn of the {{luya\admin\Module::$apiUserAllowActionsWithoutPermissions}} apiUser check only for a given controller you might override {{luya\admin\traits\AdminRestBehaviorTrait::canApiUserAccess()}}.

```php
public function canApiUserAccess()
{
    return true;
}
```

Now the given API controller is also accessible to api users.

### RestActiveController

The {{luya\admin\base\RestActiveController}} requires a model class to perform classic read, create, update and delete tasks. If a custom action is defined, by default **no permission** is required for this action unless its defined in {{luya\admin\base\RestActiveController::actionPermissions()}}:

```php
class TestActiveRestController extends luya\admin\base\ActiveRestController
{
    public $modelClass = 'pets\models\Animals';
    
    public function actionPermissions()
    {
        return [
            'dogs' => \luya\admin\componenets\Auth::CAN_UPDATE,
        ];
    }
    
    public function actionDogs()
    {
        return ['rocky', 'billy'];
    }
    
    public function actionCats()
    {
        return ['sheba', 'whiskas'];
    }
}
```

With the following module config:

```php
class Pets extends luya\admin\base\Module
{
    public $apis = [
        'my-pets-api' => 'pets\apis\TestActiveRestController',
    ];
    
     public function extendPermissionApis()
     {
         return [
             ['api' => 'my-pets-api', 'alias' => 'Pets API']
         ];
     }
}
```

Now the actionDogs is only visible if the group of the user has permission update, while the cats action is visible to all authenticated users. If {{luya\admin\Module::$apiUserAllowActionsWithoutPermissions}} is enabled, even Api Users could access the endpoint.

## Disable Controller permission

Inside of each {{luya\admin\base\Controller}} abstracted class you can disable/override the permission check be enabling the property {{luya\admin\base\Controller::$disablePermissionCheck}}. This means all **logged in users** can access this controller but guest (not logged in users) are still not allowed to see this controller.

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

## Disable REST/Api action authentication

In order disable permissions for only a given action you can define {{luya\traits\RestBehaviorsTrait::$authOptional}} to make an action public available:

```php
class MyTestController extends \luya\admin\base\Controller
{
    public $authOptional = ['public'];

    public function actionPublic()
    {
        // this action is now public to everyone without authorization
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

