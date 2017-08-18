# Application Assets

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

### Using the Asset

To use an asset bundle, register it with a view by calling the {{yii\web\AssetBundle::register()}} method. For example, in a view template you can register an asset bundle like the following:

```php
use app\assets\AppAsset;
AppAsset::register($this);  // $this represents the view object
```

> The yii\web\AssetBundle::register() method returns an asset bundle object containing the information about the published assets, such as basePath or baseUrl.

If you are registering an asset bundle in other places, you should provide the needed view object. For example, to register an asset bundle in a widget class, you can get the view object by `$this->view`.

When an asset bundle is registered with a view, behind the scenes Yii will register all its dependent asset bundles. And if an asset bundle is located in a directory inaccessible through the Web, it will be published to a Web directory. Later, when the view renders a page, it will generate <link> and <script> tags for the CSS and JavaScript files listed in the registered bundles. The order of these tags is determined by the dependencies among the registered bundles and the order of the assets listed in the {{yii\web\AssetBundle::$css}} and {{yii\web\AssetBundle::$js}} properties.

### Publish Options

To ensure a minimal footprint and to avoid issues with node packages inside the resource folder, it's recommended to manually select the folders to be published. For example in the LUYA kickstarter project, you'll find both the 'boostrap' and the 'css' folder in the publish options:

```php
public $publishOptions = [
    'only' => [
        'bootstrap/*',
        'css/*',
    ]
];
```

Or you can do also the opposite of this behavior by select which folder should **not** be copied within the assets folder. To do so configure the `except` property:

```php
public $publishOptions = [
    'except' => [
        'node_modules/',
    ]
];
```

> Patterns ending with '/' apply to **directory** paths only, and patterns not ending with '/' apply to **file** paths only. For example, '/a/b' matches all file paths ending with '/a/b'; and '.svn/' matches directory paths ending with '.svn'.


### Accessing the asset path

Sometimes you may want to access the folder with the asset files, therefore you need to retrieve the baseUrl of the asset which as the *actual path of the folder in the filesystem* which is in the `public_html/assets/$HASH_NUMBER`.

Run the the get bundle method inside your view file for the registered assetManager in the view object:

```php
$myAsset = $this->assetManager->getBundle('\\app\\assets\\MyTestAsset');

echo $myAsset->baseUrl; 
```
