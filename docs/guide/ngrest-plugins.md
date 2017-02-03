# NgRest Config Plugins

An NgRest Plugin is like the type of an input. You can create selects, date pickers, file or image uploads, etc. Each NgRest Config Plugin can have its configuration options. In order to understand how to use the plugins read the [[ngrest-model.md]] Guide-Section.

### Available Plugins

A few plugins have options to configure, make sure you check the class reference of the plugin to find all details.

|Name			|Class|Return		|Description
|--------------	|-----|---		|-------------
|text           |{{\luya\admin\ngrest\plugins\Text}}|string		|Input type text field.
|textArray			|{{\luya\admin\ngrest\plugins\TextArray}}|array		|Multiple input type text fields.
|textarea		  	|{{\luya\admin\ngrest\plugins\Textarea}}|string		|Textarea input type field.
|password			|{{\luya\admin\ngrest\plugins\Password}}|string		|Input type password field.
|[selectArray](ngrest-plugin-select.md) |{{\luya\admin\ngrest\plugins\SelectArray}}|string	|Select Dropdown with options from input configuration.
|[selectModel](ngrest-plugin-select.md) |{{\luya\admin\ngrest\plugins\SelectModel}}|string	|Select Dropdown with options given from an Active Record Model class.
|toggleStatus       |{{\luya\admin\ngrest\plugins\ToggleStatus}}|integer/string	|Create checkbox where you can toggle on or off.
|image				|{{\luya\admin\ngrest\plugins\Image}}|integer	|Create an image upload and returns the imageId from storage system.
|imageArray			|{{\luya\admin\ngrest\plugins\ImageArray}}|array		|Creates an uploader for multiple images and returns an array with the image ids from the storage system.
|file				|{{\luya\admin\ngrest\plugins\File}}|integer		|Creates a file upload and returns the fileId from the storage system.
|fileArray          |{{\luya\admin\ngrest\plugins\FileArray}}|array		|Creates an uploader for multiple files and returns an array with the file ids from the storage system.
|checkboxList		|{{\luya\admin\ngrest\plugins\CheckboxList}}|array		|Create multiple checkboxes and return the selected items as array.
|[checkboxRelation](ngrest-plugin-checkboxrelation.md) |{{\luya\admin\ngrest\plugins\CheckboxRelation}}|array |Create multiple checkbox based on another model with a via table.
|date				|{{\luya\admin\ngrest\plugins\Date}}|integer |Datepicker to choose date, month and year. Returns the unix timestamp of the selection.
|datetime 			|{{\luya\admin\ngrest\plugins\Datetime}}|integer |Datepicker to choose date, month, year hour and minute. Returns the unix timestamp of the selection.
|decimal            |{{\luya\admin\ngrest\plugins\Decimal}}|float	|Creates a decimal input field. First parameter defines optional step size. Default = 0.001
|number				|{{\luya\admin\ngrest\plugins\Number}}|integer |Input field where only numbers are allowed.
|cmsPage			|{{\luya\admin\ngrest\plugins\CmsPage}}|{{luya\cms\menu\Item}}|Cms Page selection and returns the menu component item.
|link               |{{\luya\admin\ngrest\plugins\Link}}|{{luya\web\LinkInterface}}|Select an internal page or enter an external link, the database field must be a varchar field in order to store informations and the cms module is required.
|slug               |{{\luya\admin\ngrest\plugins\Slug}}|string|Generates a slugified string which can be used for url rules.
## Create a custom project Plugin

Sometimes you really want to have project specific input behaviour. To achieve this you have to create your own custom NgRest Plugin. First create a Plugin class:

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

Make sure the the `field` extra field is part of the validation rules. For example:

```php
public function rules()
{
    return [
        // ...
        [['field'], 'safe'],
    ];
}
```
