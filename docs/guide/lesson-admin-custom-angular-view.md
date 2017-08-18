# Create a Custom Angular Controller and Admin View

Sometimes you just want to create your own view within the admin module with your own angular controller, view and api responses. Therefore this lessions shows you what you need, how to register and create such basic custom applicatin within minutes.

This lession assumes, that you already have an admin module registered and running, see [[lesson-module.md]].

## Create Controller

Create a controller:

```php
<?php

namespace app\modules\mymodule\admin\controllers;

use Yii;
use luya\admin\base\Controller;

class FinderController extends Controller
{
    public $disablePermissionCheck = true;
    
    public $apiResponseActions = ['data'];
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
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

## Register Menu

Register the Controller in the Menu:

```php
public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
        ->nodeRoute('FINDER', 'important_devices', 'myadminmodule/finder/index');
}
```