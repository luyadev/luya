# Admin assets

This section describes how to add assets (css or javascript) files to your administration module. To ensure that they are depending and initializing your files at the right point all your custom assets should depend on the `admin\assets\Main` package.

### Example bundle

Below an example administration asset file depending on the administration main asset bundle:

```php
<?php

namespace app\modules\myadmin\assets;

class MyAdminAsset extends \luya\web\Asset
{
    public $sourcePath = '@myadmin/resources';

    public $js = [
        'js/johndoe.js',
    ];

    // important to solve all javascript dependency issues here, e.g. jquery, bower, angular, ...
    public $depends = [
        'luya\admin\assets\Main',
    ];
}
```

> The asset bundle itself should always stored in a `assets` folder where the resource files for the asset should always located in a `resources` folder.

### Embedding the assets

To embed the above created example asset file which is stored in your admin module you have to add the asset bundle into the {{\luya\base\AdminModuleInterface::getAdminAssets()}} method of the belonging `Module.php` file as shown below:

```php
<?php
namespace app\modules\myadmin;

class Module extends \luya\admin\base\Module
{
    public function getAdminAssets()
    {
        return [
            'app\modules\myadmin\assets\MyAdminAsset'
        ];
    }
}
```

As the admin UI is written in angular the assets must be pre assigned to the admin UI therefore the `getAdminAssets()` method exists.

Keep in mind that you have to register this module in order to register the asset files.
