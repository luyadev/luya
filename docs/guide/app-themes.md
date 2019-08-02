# Project themes

A theme can used to overwrite other views and _resources (will come late)_

## Theme folder structure

> In order to create your custom theme you can run the [Console Command](luya-console.md) `theme/create` wizard.

Structure of a theme

```
    .
    ├── resources
    ├── views
    │   ├── layouts
    │       └── main.php
    │   └── site
    │       └── index.php
    └── theme.json
```

## Configure active theme

To enable a theme you have to define it in your config file. The theme `@app/themes/blank` is the fallback/default theme.
E.g. add this to your configs in the themeManager section:

```php
$config = [
    'components' => [
        'themeManager' => [
            'activeTheme' => '@app/themes/blank'
        ]
    ]
];
``` 

## Example theme config

In our example we make a *blue theme* which inherit from the default *@app/themes/blank*.

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

*For detailed information of theme config see \luya\theme\ThemeConfig*

## File inheritance/override

Theme inherit all view files from their parents. Only if a theme has the same view file as its parent than this file will be used while rendering.

In the above example the *blank* theme could have the view `@blankTheme/views/site/index`.
The *blue* theme does need to have this view file because it will inherit from the *blank* theme.

But the views from `@app/views` will be override all other theme views.

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

## Theme manager

The `\luya\theme\ThemeManager` holds all theme information and also the active theme.

## Resources

Every registered theme

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

+ [luya-blockcollection](https://github.com/boehsermoe/luya-blockcollection/tree/theme)