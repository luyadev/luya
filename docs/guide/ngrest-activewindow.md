# NgRest ActiveWindow

An *NgRest ActiveWindow* is a concept to attach a modal window into a [NgRest crud list](ngrest-concept.md). The ActiveWindow is always bound to an **ID** of an item and is represented as a button with an icon and/or an alias, e.g. a button in the crud list:

![button](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/aw_button.png "ActiveWindow button")

An example of an active window (Change Password) when clicked:

![overlay-window](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/aw_window.png "ActiveWindow overlay")

## Create an ActiveWindow

> Use the [`admin/active-window` console command](luya-console.md) to generate a new ActiveWindow.

A very basic example class with the name *TestActiveWindow* just renders an index and contains a callback:

```php
namespace mymodule\aws;

class TestActiveWindow extends \luya\admin\ngrest\base\ActiveWindow
{
    public $module = 'mymodule';
    
    public function index()
    {
        return $this->render("index");
    }
    
    public function callbackSayHello($name)
    {
        $this->sendSuccess('Hello: ' . $this->itemId);
    }
}
```

Some general information about ActiveWindows:

+ The property `$module` is required and is used to determine the path for the views files.
+ The `index()` method is required and will always be the default method which is rendered by clicking on the button in the crud grid list.
+ Callbacks must be prefixed with `callback`, the properties of the callbacks can be either required or not.

Working with callbacks

+ To return successful data use `sendSuccess($message)`.
+ To return error data use `sendError($message)`.

Calling the callbacks

+ When a ActiveWindow callback is called the lower camelcase prefix method e.g. `callbackHelloWorld` must be called as `hello-world`.

## Attaching the class

In order to add an ActiveWindow into your NgRest config it has to be added in the {{luya\admin\ngrest\base\NgRestModel::ngRestActiveWindows()}} method. As the ActiveWindow contains the {{yii\base\BaseObject}} as extend class you can configure all public properties while the class is loading. Below, an example of how to load an ActiveWindow class and define `label` and `icon` public properties. The alias and icon properties are present in every ActiveWindow and can always be overridden.

```php
public function ngRestActiveWindows()
{
    return [
        ['class' => \luya\admin\aws\TestActiveWindow::class, 'label' => 'My Window Alias', 'icon' => 'extension'],
    ];
}
```

#### Button condition

A button condition can be defined adding a `condition` string to be evaluated towards the row fields. Example:

```php
public function ngRestActiveWindows()
{
    return [
        ['class' => \luya\admin\aws\TestActiveWindow::className(), 'label' => 'My Window Alias', 'icon' => 'extension', 'condition' => '{firstname}==\'foo\''],
    ];
}
```

This `My Windows Alias` button will only be shown for if the row `firstname` equals to 'foo' 

### View files

To render view files you can run the method `$this->render()` inside your ActiveWindow class. The render method will lookup for php view file based on the base path of your `$module` property. Lets assume we run `$this->render('index')` and have defined `admin` as your `$module` property and your Active Window name is `TestActiveWindow` this will try to find the view file under the path `@admin/views/aws/test/index.php`. 

## How to make a Button

In order to create a button with a callback we use the {{luya\admin\ngrest\aw\CallbackButtonWidget}} widget. 

Example of a view file:

```php
CallbackButtonWidget::widget(['label' => 'My button', 'callback' => 'hello-world', 'params' => ['name' => 'John Doe']]);
```

The callback of this button should look like this:

```php
public function callbackHelloWorld($name)
{
    return $this->sendSuccess('Hello ' . $name);
}
```

There are a few built in widgets you can use:

+ {{luya\admin\ngrest\aw\CallbackButtonWidget}} - Generate a button with a click to a callback.
+ {{luya\admin\ngrest\aw\CallbackButtonFileDownloadWidget}} - Generate a button which will then provide a download of a given file.
+ {{luya\admin\ngrest\aw\ActiveWindowFormWidget}} - Generate a form to submit data to a callback.

## Generate a form

You can also use the callback from the widget to create a form sending data to a callback

```php
<?php
use luya\admin\ngrest\aw\ActiveWindowFormWidget;

/* @var $this \luya\admin\ngrest\base\ActiveWindowView */
/* @var $form \luya\admin\ngrest\aw\ActiveWindowFormWidget */ 

?>
<div>
    <?php $form = ActiveWindowFormWidget::begin(['callback' => 'post-data', 'buttonValue' => 'Submit']); ?>
    <?= $form->field('firstname', 'Firstname'); ?>
    <?= $form->field('password', 'Password')->passwordInput(); ?>
    <?= $form->field('message', 'Message')->textarea(); ?>
    <?php $form::end(); ?>
</div>
```

The corresponding callback should look like this:

```php
public function callbackPostData($firstname, $lastname)
{
    return $this->sendError('error while collecting data... maybe?');
}
```

## AngularJS in view files

As the admin UI is written in AngularJS which let´s you easily create inline AngularJS controllers to interact with your ActiveWindow class.

The below view file shows an AngularJS controller which collects data from the the controller assigned into the view but uses `ng-repeat to display and render the data.

```php
<script>
zaa.bootstrap.register('InlineController', ['$scope', function($scope) {

    $scope.data = <?= $dataFromController; ?>;

    $scope.addToList = function(member) {
        $scope.$parent.sendActiveWindowCallback('add-to-list', {member:member}).then(function(response) {
            $scope.$parent.reloadActiveWindow();
        });
    };
}]);
</script>
<div class="row" ng-controller="InlineController">
    <ul>
        <li ng-click="addToList(member)" ng-repeat="item in data">{{item.name}}</li>
    </ul>
</div>
```

After the ActiveWindow response from the function `addToList` has received the ActiveWindow will be reloaded. This is just a very quick integration example and it does not give the user a true AngularJS experience but shows you how to deliver solutions in a very short time.

When working with angular you might want to trigger some of the functions of the crud, here a list of what functions are callable and what they do:

|Function|Description
|--------|-----------
|`$scope.$parent.closeActiveWindow()`|Close the current ActiveWindow
|`$scope.$parent.loadList()`|Reload the ActiveWindow list.
|`$scope.$parent.reloadActiveWindow()`|Reload (Rerender) the ActiveWindow.
|`$scope.$parent.toast.error(message)`|Display an error toast message.
|`$scope.$parent.toast.success(message)`|Display a success toast message.
|`$scope.$parent.sendActiveWindowCallback(callbackName, params)`|XHR request for given callbackName with additional params.

## Button permission level

In addition to button condition a permission level can be set. This will ensure displaying the buttons only when proper permission level is met.
This can be defined with the `permissionLevel` atrribute. Example:

```php
public function ngRestActiveWindows()
{
    return [
        ['class' => \luya\admin\aws\TestActiveWindow::className(), 'label' => 'My Window ', 'permissionLevel' => Auth::CAN_VIEW],
    ];
}
```

Above example will add the TestActiveWindow button if the user has the VIEW permission of the model.

If `permissionLevel` attribute is not set, the default behavior is applied which is `CAN_UPDATE` permission is required.

```php
...
        ['class' => \luya\admin\aws\TestActiveWindow::className(), 'label' => 'My Window'],
...
```

To disable permission checks, you have to set the `permissionLevel` to am empty string: 

```php
...
        ['class' => \luya\admin\aws\TestActiveWindow::className(), 'label' => 'My Window', 'permissionLevel' => ''],
...
```

## Existing reusable ActiveWindows

The admin UI of LUYA provides some basic reusable ActiveWindows which you can reuse and use out of the box. Just attach them to your NgRest config with the given configuration. Take a look at the API reference for more details in how to attach the specific ActiveWindow.

|Class|Description
|--|--|
|{{\luya\admin\aws\TaggableActiveWindow}}|Provides the option to set tags for the given record.
|{{\luya\admin\aws\ImageSelectCollectionActiveWindow}}|Select images from the file manager and store them in a reference table.
|{{\luya\admin\aws\FlowActiveWindow}}|Provides an image uploader (flow uploader) which are hidden in the filemanager and stored in a reference table.
|{{\luya\admin\aws\DetailViewActiveWindow}}|A detail view where you can define the attributes with the given type or just print all fields with the corresponding value.
|{{\luya\admin\aws\ChangePasswordActiveWindow}}|An option to change the password.
|{{\luya\admin\aws\CoordinatesActiveWindow}}|Provides a view where you can find coordinates for a given location.
