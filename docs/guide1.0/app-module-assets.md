Publishing assets depending on the module
=========================================

If you want to use assets inside a module you have to define them inside the assets variable of the module.  Example Module.php with asset

```php
<?php
namespace app\modules\estore;

class Module extends \luya\base\Module
{    
    public $assets = [
        'app\modules\estore\EstoreAsset'
    ];
}
```

You have to create an EstoreAsset.php file inside of your Module Root path which could look like this:

```php
<?php

namespace app\modules\estore;

class EstoreAsset extends \luya\web\Asset
{
    public $sourcePath = '@estore/assets/';
    
    public $css = [
        "estore.css"
    ];
}
```

this would publish the estore file which is located int the estore/assets/ folder.