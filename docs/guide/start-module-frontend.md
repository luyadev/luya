creating a frontend module
==========================

$useAppLayoutPath
-----------------------

Choose if you want to load your layout from the application path (@app) or directly from your module. 

```php
public $useAppLayoutPath = true;
```
default is true.


$urlRules
---------
Adding url rules

```
    public static $urlRules = [
        ['pattern' => 'estore/warenkorb', 'route' => 'estore/default/basket'],
    ];
```

$useAppLayoutPath
-----------------

By default it will now try to serach the layout in: __APP__/views/__MODULE__/layouts/main.php. If you want to use a layout inside if your module, you have to set;
```php
public $useAppLayoutPath = false;
```

page context
------------

use $this->context->pageTitle

moduleLayout
------------

use 
```php
$this->renderLayout([

]]); 
```php

to render a fake like layout inside modules