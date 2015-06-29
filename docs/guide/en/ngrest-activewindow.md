Angular Active Window
==============

Create an ActiveWindow which interactives with the ActiveWindow callback functions using angular.

ActiveWindow Class
-------------------
The default window responsive (the view you see when clicking on the button inside the crud list) is provided from the return value of the index() function.
Each ActiveWindow class must have a `$module` value. The `$module`value is used for the render method, the find the render template. For example the module value is __admin__, the the render method will look inside the path `@admin/views/aws/__CLASS_NAME__/`.
```php
namespace module\aws;

class TestActiveWindow extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'admin';
    
    public function index()
    {
        return $this->render("index");
    }
    
    public function callbackSayhello($name)
    {
        return 'Hello ' . $name . ' from item: ' . $this->getItemId();
    }
}
```

View File
----------
The render method from the example class above would try to find the view:
`@admin/views/aws/testactivewindow/index__`

Example content to interact with the callback `callbackSayhello` could be:
```
<h1>Hello ActiveWindow</h1>
<button type="button" ng-click="sendActiveWindowCallback('sayhello', { name : 'John Doe' })">Call the Callback</button>

<h3>RESPONSE:</h3>
<p>{{ activeWindowCallbackResponse }}</p>
```

Response
------------
After pushing the ***Call the Callback*** button, the activeWindowCallbackResponse variable would be filled with "Hello John Doe from item: 1", where the item id is the current selected element you have registered the ActiveWindow.