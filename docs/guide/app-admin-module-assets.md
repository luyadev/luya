# Admin assets

This section describes how to add assets (CSS or JavaScript) files to your administration module. To ensure that they are depending and initializing your files at the right point all your custom assets should depend on the `admin\assets\Main` package.

## Register Asset Bundle

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

    // important to solve all JavaScript dependency issues here, e.g. jQuery, bower, angular, ...
    public $depends = [
        'luya\admin\assets\Main',
    ];
}
```

> The asset bundle itself should always stored in a `assets` folder where the resource files for the asset should always located in a `resources` folder.

## Embedding the assets

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

> Keep in mind that you have to register this module in order to register the asset files.

## Using i18n in JavaScript

In order to use the i18n service inside your JavaScript files, you have to pass the translations keys you d'like to use inside your JavaScript to the admin UI. Therefore define {{luya\admin\base\Module::getJsTranslationMessages()}} in your admin module class:

```php
public function getJsTranslationMessages()
{
    return [
        'i18n_message_key_from_message_1', 'i18n_message_key_from_message_2', // ...
    ];
}
```

> Only registered translation keys can be used, see [[app-translation.md]] module translation section to register translations.

Now you can use this registered translation keys inside your JavaScript files with `i18n['i18n_message_key_from_message_1']`. If you have a parameterized translation message you can use `i18nParam('i18n_message_key_from_message_2', {variable: value})`. The message for this parameterized value could be `Hello %variable%`.
