# NgRest Config Plugins

An NgRest Plugin is like the type of an input. You can create selects, date pickers, file or image uploads, etc. Each NgRest Config Plugin can have its configuration options.

### Available Plugins

|Name				|Return		|Description
|--------------		|---		|-------------
|text				|string		|Input type text field.
|textArray			|array		|Multiple input type text fields.
|textarea		  	|string		|Textarea input type field.
|password			|string		|Input type password field.
|[selectArray](ngrest-plugin-select.md) |string	|Select Dropdown with options from input configuration.
|[selectModel](ngrest-plugin-select.md) |string	|Select Dropdown with options given from an Active Record Model class.
|toggleStatus       |integer/string	|Create checkbox where you can toggle on or off.
|image				|integer	|Create an image upload and returns the imageId from storage system.
|imageArray			|array		|Creates an uploader for multiple images and returns an array with the image ids from the storage system.
|file				|integer		|Creates a file upload and returns the fileId from the storage system.
|fileArray          |array		|Creates an uploader for multiple files and returns an array with the file ids from the storage system.
|checkboxList		|array		|Create multiple checkboxes and return the selected items as array.
|[checkboxRelation](ngrest-plugin-checkboxrelation.md) |array |Create multiple checkbox based on another model with a via table.
|date				|integer |Datepicker to choose date, month and year. Returns the unix timestamp of the selection.
|datetime 			|integer |Datepicker to choose date, month, year hour and minute. Returns the unix timestamp of the selection.
|decimal            |float	|Creates a decimal input field. First parameter defines optional step size. Default = 0.001
|number				|integer |Input field where only numbers are allowed.
|cmsPage			|\cms\menu\Item |Cms Page selection and returns the menu component item.

> Check the class reference/api guide to find out more about configuration options of the plugins.

## Create a custom project Plugin

Sometimes you really want to have project specific input behavior. To achieve this you have to create your own custom NgRest Plugin. First create a Plugin class:

```php
<?php

namespace myadminmodule\plugins;

use luya\admin\helpers\Angular;

class TestPlugin extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        $this->createListTag($id, $ngModel);
    }
    
    public function renderUpdate($id, $ngModel)
    {
        return Angular::directive('my-directive', ['model' => $ngModel, 'data' => $this->getServiceName('data')]);
    }
    
    public function renderCreate($id, $ngModel)
    {
        return Angular::directive('my-directive', ['model' => $ngModel, 'data' => $this->getServiceName('data')]);
    }
    
    public function serviceData()
    {
        return [
            'data' => [
                // some data we always want to expose to the directive,
            ],
        ];
    }
}
```

The above class is abstracted from the `admin\ngrest\base\Plugin` which requires the `renderUpdate`, `renderList` and `renderCreate` methods which are basically taking care of the form input or the element in the crud list view. As you can see we use the helper method `Angular::directive` to return a Form Input Tag with a custom directive named `my-directive`. The directive must be stored in en admin javascript file you can assign by using [Admin Module Assets](app-admin-module-assets.md). For example:

```js
zaa.directive("myDirective", function() {
    return {
        restrict: "E",
        scope : {
            'model' : '=',
            'data' : '=',
        },
        controller: function($scope, $filter) {
            $scope.$watch(function() { return $scope.model }, function(n, o) {
                console.log(n, o);
            });
        },
        template : function() {
            return '<div>{{data | json }} - {{ model }} - <input type="text" ng-model="model" /></div>';
        }
    }
});
```

Now in order to use the custom `TestPlugin` in your [NgRest Config Model](ngrest-model.md) cast ean extra Field which takes care of getting (list) and setting (update/create) the value in your `admin\ngrest\base\Model` ActiveRecord class model.

```php
class Product extends \luya\admin\ngrest\base\NgRestModel
{
    // ... 
    
    public function setField($data)
    {
        // This is what happends when the value from the angualr api response trys to save or update the model with $data.
    }
    
    public function getField()
    {
        // This is what happens when active record pattern trys to get the values for the field. This is basic getter/setter principal of the yii\base\Object.
    }
    
    public function extraFields()
    {
        return ['field'];
    }

    public function ngrestExtraAttributeTypes()
    {
        return [
            'field' => ['class' => myadminmodule\plugins\TestPlugin::className()],
        ];
    }
    
    public function ngRestConfig($config)
    {
        // ...
        $this->ngRestConfigDefine($config, ['create', 'update', 'list'], ['field']);
        // ...
    }
    
    // ...
}
```
