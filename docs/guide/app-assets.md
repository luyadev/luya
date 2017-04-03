# Application Assets

Asset files like CSS or JavaScript are resources you have to integrate in your web project but organize them in "package" like folders, so called Asset Bundles. Assets are based on [Yii2 Asset Bundles](http://www.yiiframework.com/doc-2.0/guide-structure-assets.html) you may read more detailed informations about. The LUYA assets describe just another way of including them into you project.

An example class of an asset where files are located in `@app/resources` and includes the `css/styles.css` into the view files where the asset is loaded.

```php
namespace app\assets;

class MyTestAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';
    
    public $css = [
        "css/style.css",
    ];
}
```

From the example above the css file `style.css` would be looked up in the location `@app/resources/css/styles`.

> In a project context, we recommend to *not* store images inside the asset sources. Images should stored in the `public_html` folder and you can access them in the view with `src="<?= $this->publicHtml; ?>/myimage.jpg"`.

### Using the Asset

To register an asset file you have to put those files into the config of a module. Each module can have assets. All controllers of this module will register those assets into the view automaticaly. If you are in a cms context, all asset files must be registered to the cms module, otherwise they will not be available in the cmslayouts. An example of registering assets into the cms module:

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

The original Yii way of including Assets is good as well, therefore you have to register the asset in any view file (views, layouts), an example of registering an asset:

```php
use app\assets\MyTestAsset;

$asset = MyTestAsset::register($this); // $this represents the view object
```

### Publish Options

To ensure a minimal footprint and to avoid issues with node packages inside the resource folder, it's recommended to manually select the folders to be published.
For example in the LUYA kickstarter project, you'll find both the 'boostrap' and the 'css' folder in the publish options:

```php
public $publishOptions = [
    'only' => [
        'bootstrap/*',
        'css/*',
    ]
];
```


### Accessing the asset path

Sometimes you may want to access the folder with the asset files, therefore you need to retrieve the baseUrl of the asset which as the *actual path of the folder in the filesystem* which is in the `public_html/assets/$HASH_NUMBER`.

Run the the get bundle method inside your view file for the registered assetManager in the view object:

```php
$myAsset = $this->assetManager->getBundle('\\app\\assets\\MyTestAsset');

echo $myAsset->baseUrl; 
```

To access the baseUrl of an asset in a twig template you may use:

```
{{ asset('\\app\\assets\\MyTestAsset').baseUrl }}
```
