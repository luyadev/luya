# Admin controller and view file

In order to use a controller to prepare your data you have to assign those into the view file and finally generate a new menu entry for this view as described in this guide.

## Generate custom controller and view

Let´s assume you have already registered your admin module ([[app-admin-module.md]]). Next let´s create a new controller in the `controllers` folder of your admin folder:

```php
<?php

namespace app\modules\mymodule\admin\controllers;

use luya\admin\base\Controller;

class StatsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'data' => [], // Data to assign into the view file `index`.
        ]);
    }
}
```

The controller will now try to find the view file `app/modules/mymodule/admin/views/stats/index.php` so you have to create this file:

```php
<?php
/** @var $this \luya\web\View */
?>
Hello World!
```

Now your controller and view files are ready, head over to the next section to learn how create a new menu entry for your controller.

## Register the controller in the menu

In order to register your custom controller you have to extend (or create if not done already) the {{luya\admin\base\Module::getMenu()}} function in order to match your route. We assume you have assigned your admin module as `mymoduleadmin` in your application configuration, so the route to your controller would be `mymoduleadmin/stats/index`: 

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('My Root Menu', 'accessibility')
            ->group('Group Description')
                ->itemRoute("Stats Controller", "mymoduleadmin/stats/index", "poll"); // icons like poll: https://material.io/icons/
}
```

You have now told the administration module that there is a new menu entry. All you have to do is now run the `./vendor/bin/luya import` command and assign the new permissions to your admin UI.

> Important! Do not forget to run `import` command **and** assign the permission to your Administration Group in the Admin UI afterwards!

You could also use {{luya\admin\componenets\AdminMenuBuilder::nodeRoute()}} which would not have a group and item which gives you a larger screen to build your custom views.

## Custom view inline AngularJS controller

If you would like to make a view file without any asset integration you can just bootstrap an inline angular controller within your view file like this :

```php
<script>
zaa.bootstrap.register('FinderController', function($scope, $controller) {
    
    // add your angular controller logic here

    $scope.title = 'Hello World';    
});
</script>
<div class="luya-content" ng-controller="FinderController">
    <h1>{{title}}</div>
</div>
```

You could also register a java script file within an [[app-admin-module-assets.md]].