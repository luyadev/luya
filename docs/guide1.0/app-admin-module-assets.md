Admin Assets
==================

This section describes how to add assets (css or javascript) files to your administration module, to make sure are depending and initializing your files at the right point, all your custom assets should depend on the `admin\assets\Main` packaged.


### Example Bundle

Below en example administration asset file depending on the administration main asset bundle:

```php
<?php

namespace app\modules\myadmin\assets;

class MyAdminAsset extends \luya\web\Asset
{
    public $sourcePath = '@myadmin/resources';

    public $js = [
        'js/johndoe.js',
    ];

    // important to solve all javascript dependency issues relating jquery, bower, angular, ...
    public $depends = [
        'admin\assets\Main',
    ];
}
```

> The asset bundle itself should always stored in a `assets` folder where the resource files for the asset should always located in a `resources` folder.

### Embed the asset

To emebed the above created example asset file stored in your admin module you hav to add the asset bundle into your `$assets` array config of the belonging `Module.php` file as shown below:

```php
<?php
namespace app\modules\myadmin;

class Module extends \admin\base\Module
{
    public $assets = [
        'app\modules\myadmin\assets\MyAdminAsset'
    ];

}
```