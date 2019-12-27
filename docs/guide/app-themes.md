# Project themes

A theme can be used to overwrite views form other themes (inherit) or other module views.

## Theme folder structure

> In order to create your custom theme you can run the [Console Command](luya-console.md) `theme/create` wizard.

Themes directories can be located at `@app/themes/{themeName}` or inside of a composer package (see below). To load a new theme you have to execute `vendor/bin/luya import` form console.

Example of a theme directory structure:

```
    .
    ├── theme.json     // required
    ├── resources
    └── views
        ├── layouts
        │   └── theme.php
        └── site
            └── index.php   
```

## Configure active theme

To enable a theme you have to assign it to the theme manager. You can define this in your config file just add the theme alias e.g. `@app/themes/blank` to the `themeManager` config section:

```php
$config = [
    'components' => [
        'themeManager' => [
            'activeTheme' => '@app/themes/blank'
        ]
    ]
];
``` 

Since version 3.0 of CMS module, activate a theme can also be done in the admim area under *Settings* -> *Themes*

![theme-management](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/theme-management.png "LUYA theme management")

## Example theme config

In our example we make a *blue theme* which inherit from the theme *@app/themes/blank*.

The *blank* theme (base)

```theme.json
{
    name: "Blank theme"
}
```

The *blue* theme based on *blank* theme:

```theme.json
{
    "name": "Blue theme",
    "parentTheme": "@app/themes/blank"
}
```

For detailed information of theme config take a look at {{luya\theme\ThemeConfig}} class.

## File inheritance/override

Theme inherit all view files from their parents. Only if a theme has the same view file as its parent than this file will be used while rendering.

In the above example the *blank* theme could have the view `@blankTheme/views/site/index`.
The *blue* theme does need to have this view file because it will inherit from the *blank* theme.

**But the views from `@app/views` will be override all other theme views.

The order of view inheritance (pathMap) will looks like this:

```pathmap
// requested path => [theme paths]
@app/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
@blueTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
@blankTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
```

At first search the requested path in the first column. 
On a match searching in the list of theme paths for a exists file in the defined order.

### Additional path map

It is also possible to define additional path for inheritance by add a path map in the theme config.
In this way block and widget views can also be override with a theme.

```theme.json
{
    "pathMap": [
        "@moduleAlias/frontend/views"
    ]
}
```

These additional paths will be added to the end of the path map:

```
@app/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
@blueTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
@blankTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
@moduleAlias/frontend/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
```

## Layouts

Themes will use the layout file *theme.php* as default and the cmslayout *theme.php* too. You have to select this theme layout in the page version.

## Theme manager

The {{luya\theme\ThemeManager}} holds all theme information and also the active theme.

## Resources

An example asset which contains resources from a theme.

```php
class ResourcesAsset extends \luya\web\Asset
{
    public $sourcePath = '@blankTheme/dist';
    
    public $css = [
        'main.css'
    ];

    public $js = [
        'main.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
```

## Import Method

The application and all modules can have a *themes* directory which will be loaded when running the [console command `import`](luya-console.md). 

> One of the main ideas behind LUYA is to store data in files and import them into your database.

## Theme packages

You can also create a theme as a composer package.
You only have to add inside the extra section of the *composer.json* the relative path to every theme you want to register.

```json
{
    "extra": {
        "luya" : {
            "themes": ["themes/blank"]
        }
    }
}
```

For more information to packages see [package guide](luya-package-dev.md).

Some other examples of theme packages:

+ [luya-themecollection](https://github.com/boehsermoe/luya-themecollection)
