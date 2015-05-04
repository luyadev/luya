load assets via composer bower
==============================

composer.json
```json
require : {
    "bower-asset/jquery" : "2.1.*@stable",
    "bower-asset/jquery-ui" : "1.*@stable"
}
```

create asset for the packages above:
```php
class AssetBower extends \yii\web\AssetBundle
{
	public $sourcePath = '@bower';

	public $js = [
        'jquery/dist/jquery.min.js',
        'jquery-ui/jquery-ui.min.js',
    ];
}

```