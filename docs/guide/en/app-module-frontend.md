creating a frontend module
==========================

$useAppLayoutPath
-----------------------

Choose if you want to load your layout from the project path (@app) or directly from your module. 

```php
public $useAppLayoutPath = true;
```
default is true.


Module Context
-------------------
If a module is invoke by another module the context variable contains the name of the module which has invoke the active module. For example if the cms loades other modules, the loaded module can access the 
parent module with $this->context;


$useAppLayoutPath
-----------------

By default it will now try to serach the layout in: __APP__/views/__MODULE__/layouts/main.php. If you want to use a layout inside if your module, you have to set;
```php
public $useAppLayoutPath = false;
```

page title
------------

use $this->title

