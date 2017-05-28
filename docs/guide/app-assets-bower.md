load assets via composer bower
==============================

> The LUYA team discontinued to user bower assets, as it makes the composer update process very slow.

require
--------
added your bower packages into the require part:

```json
require : {
    "bower-asset/jquery" : "2.1.*@stable",
    "bower-asset/jquery-ui" : "1.*@stable"
}
```

extras
------
check your composer.json to set the extra informations:

```json
    "extra": {
        "asset-installer-paths": {
            "bower-asset-library": "vendor/bower"
        }
    },
```

asset
-----
create php asset class based in your config above:

```php
class JqueryAsset extends \luya\web\Asset
{
    public $sourcePath = '@bower';

    public $js = [
        'jquery/dist/jquery.min.js',
        'jquery-ui/jquery-ui.min.js',
    ];
}
```
