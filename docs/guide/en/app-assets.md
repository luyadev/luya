App Assets
==========

class
-----
create an asset class extend from yii\web\AssetBundle like below:
```php
namespace app\assets;

class LuyaioAsset extends \luya\base\Asset
{
    public $sourcePath = '@app/resources';
    
    public $css = [
        "css/style.css",
    ];
}
```
the above example would register the asset folder @app/resources and copy the css file style.css (@app/resources/css/style.css) into the asset cache.

register asset
---------------
To register an asset file you have to put those files into the config. Each module can have assets. All controllers of this module will register those assets into the view.

If you are in a cms context, all asset files must be registered to the cms module, otherwhise they will not be available in the cmslayout twig files. Added an array item to your modules asset array:
```php
return [
	'modules' => [
		...
        'cms' => [
            'class' => 'cms\Module',
            'assets' => [
                '\\app\\assets\\LuyaioAsset',
                '\\app\\assets\\FooBarAsset',
            ]
        ],
		...
	]
];
```

If you need the to access the baseUrl of a specific class you can now get the class object like
```php
$luyaio = $this->getAssetManager()->getBundle('\\app\\assets\\LuyaioAsset');
```

All asset who are register with the module asset property can also be access in the twig files with the function:
```
{{ asset('\\app\\assets\\LuyaioAsset').baseUrl }}
```

register asset in the view
--------------------------
If there is an asset you only need in the current php view file, you can always register them with the command:
```php
$luyaio = \app\assets\LuyaioAsset::register($this);
```
inside the view. Its not recommend to make us of this practice.

To access the baseUrl of the asset (cache) folder use the code below:
```php
<img src="<?= $luyaio->baseUrl; ?>img/teaser.png" border="0" />
```