# Project themes

A theme can be used to overwrite views of other modules (e.g. app) or other themes with inheritance. A Theme is a collection of informations like Assets and Views. Its bundled and therefore shareable.

> In order to create your custom theme you can run the [Console Command](luya-console.md) `theme/create` wizard.

## Create a new theme

A theme has a fixed define folder structure:

```
.
├── theme.json     // required
|- composer.json // recommend
├── resources
└── views
    ├── layouts
    │   └── theme.php
    └── cmslayouts
        └── theme.php   
```

+ `theme.json`: The theme.json contains all information about the theme itself. Like the name, description and optional array with `pathMaps`.
+ `composer.json`: The composer.json is required to pushed the package to packagist. 
+ `layouts/theme.php`: The theme.php in the layout folder is like the `layout.php` file in Yii applications. The layout/theme.php requires a `$content` variable.
+ `cmslayouts/theme.php`: The cms layout [[cms-layouts.md]] which should be taken. Those can be changed in the admin UI.

> Take a look at the LUYA Theme Skeleton Project: https://github.com/luyadev/luya-theme-skeleton

This is what the files could look like:

theme.json:

|variable|description|example
|--------|-----------|-----
|name|The name which is displayed in the Theme Manager|`my-super-name`
|description|A description what this theme include or what its built on|`My Super Theme based on Bootstrap 4 and JQuery`
|pathMap|An array with ..... Read more about in Additional path map|`[]`
|parentTheme|.... Read more about in the File inheritance/override section|`null`

```json 
{
    "name": "my-super-theme",
    "parentTheme": null,
    "pathMap": [],
    "description": "A theme based on Bootstrap 4 free creative theme (https://startbootstrap.com/themes/creative/)"
}
```

composer.json:

```json
{
    ...
    "type": "luya-theme",
    ...
    "extra": {
        "luya": {
            "themes": [
                "theme.json"
            ]
        }
    }
}
```

layouts/theme.php:

```php
```

cmslayouts/theme.php

```php

```


## Import and Activate

While running the `import` (`./vendor/bin/luya import`) command, the theme information will be loaded from the `theme.json` and stored in the database. The imported will show the imported themes when running the import command.

After a succesfull import of the new theme, it can be activated in the CMS Admin `Themes` section:

![theme-management](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/theme-management.png "LUYA theme management")

## Additional path map (`pathMap`)

**TODO: Why should i do this? Example? Use Case?**

It is also possible to define additional path for inheritance by add a path map in the theme config. In this way block and widget views can also be override with a theme.

```json
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

### File inheritance/override (`parentTheme`)

Theme inherit all view files from their parents. Only if a theme has the same view file as its parent than this file will be used while rendering.

The blank theme (base)

```json
{
    "name": "Blank theme"
}
```

The blue theme based on *blank* theme:

```json
{
    "name": "Blue theme",
    "parentTheme": "@app/themes/blank"
}
```

In the above example the *blank* theme could have the view `@blankTheme/views/site/index`. The *blue* theme does need to have this view file because it will inherit from the *blank* theme.

**But the views from `@app/views` will be override all other theme views**.

The order of view inheritance (pathMap) will looks like this:

1. equested path => [theme paths]
2. @app/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
3. @blueTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
3. @blankTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]


At first search the requested path in the first column. On a match searching in the list of theme paths for a exists file in the defined order.

## Theme packages (composer.json)

You can also register a theme from a composer package.
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

If a theme override views of other modules/packages, those dependencies have to be defined in the *composer.json* as require.
