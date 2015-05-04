Angular Strap
==============

Create a strap which interactives with the strap callback functions using angular.

Strap Class
-----------

The class with render and callbacks
```php
<?php

namespace module\straps;

class TestStrap extends \admin\ngrest\StrapAbstract
{
    public function render()
    {
        return $this->getView()->render('@module/views/strap/teststrap.php');
    }
    
    public function callbackSayhello($name)
    {
        return 'Hello ' . $name . ' from item: ' . $this->getItemId();
    }
}
```

View File
----------

the view file which is rendered from the path ***@module/views/strap/teststrap.php*** could look like sth:

```
<h1>Hello Strap</h1>
<button type="button" ng-click="sendStrapCallback('sayhello', { name : 'John Doe' })">Call the Callback</button>

<h3>RESPONSE:</h3>
<p>{{ strapCallbackResponse }}</p>
```

Result
-------

After pushing the ***CCall the Callback*** button the strapCallbackResponse variable would be filled with "Hello John Doe from item: 1", where the item id is the current selected element you have pushed the strap button.