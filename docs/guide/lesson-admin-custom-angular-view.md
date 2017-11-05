# Create a Custom Angular Controller and Admin View

Sometimes you just want to create your own view within the admin module with your own angular controller, view and api responses. Therefore this lessions shows you what you need, how to register and create a quick basic view within minutes.

This lession assumes, that you already have an admin module registered and running, see [[lesson-module.md]].

## Register Menu

Let your menu know that you have a new menu node.

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
        ->nodeRoute('My Menu Item', 'important_devices', 'myadminmodule/finder/index');
}
```

When clicking on the menu point the route `myadminmodule/finder/index` will be triggered, so therefore create a controller with the name `FinderController` in the module `myadminmodule` with an action `index`.

> More about permissions and menus in the [[app-admin-module-permission.md]] section.

## Create Controller

Creating the controller `FinderController` with an `index` action and a api callable action named `data`:

```php
<?php

namespace app\modules\mymodule\admin\controllers;

use Yii;
use luya\admin\base\Controller;

class FinderController extends Controller
{
    // disables the route based permissions checks
    public $disablePermissionCheck = true;
    // let the controller know that actionData returns data in API Format (json).
    public $apiResponseActions = ['data'];
    
    // The view file to rendern when entering this controller
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    // the api to send and retrieve data
    public function actionData()
    {
        return [
            'time' => time(),
        ];    
    }
}
```

## Create View File

Create a the view file for the index action of the controller:

```
<script>
zaa.bootstrap.register('MyController', function($scope, $http) {

    $scope.dataResponse;

    $scope.click = function() {
        $http.get('myadminmodule/finder/data').then(function(response) {
            $scope.dataResponse = response.data;        
        });
    };
    
});
</script>
<div class="luya-content" ng-controller="MyController">
    <h1>My Custom View</h1>
    
    <button type="button" ng-click="click()" class="btn btn-primary">Click me</button>
    
    <div ng-if="dataResponse">
        The time is: {{dataResponse.time}}
    </div>
</div>
```

Its very common to just write the angular controller code inside the view, of course you can also make a javascript file add this to an asset an register the [[app-admin-module-assets.md]].
