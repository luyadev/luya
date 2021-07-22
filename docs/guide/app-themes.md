# Themes

A theme can be used to overwrite views of other modules (e.g. app) or other themes with inheritance. As a collection of informations like Assets or Views it's bundled and therefore shareable.

> In order to create your custom theme you can run the [Console Command](luya-console.md) `theme/create` wizard.

## Create a new theme

A theme has a recommend folder structure. Each theme **requires to have a `theme.json`** which holds the basic theme informations. The layout and CMS layout files should be named as `theme.php`. Below an example of how a theme structure should look like:

```
.
├── theme.json      // required
├── composer.json   // recommended
├── resources
└── views
    ├── layouts
    │   └── theme.php
    └── cmslayouts
        └── theme.php   
```

+ `theme.json`: The theme configuration file contains all information about the theme itself like the name, description and optional array with path maps.
+ `composer.json`: The Composer configuration file is required to push the package to packagist and makes the installation process very fast.
+ `layouts/theme.php`: The layout file in the `layouts` folder is like the `layout.php` file in Yii applications and requires a `$content` variable.
+ `cmslayouts/theme.php`: The CMS layout [[cms-layouts.md]] which should be taken. Those can be changed in the admin UI.

> Take a look at the LUYA Theme Skeleton Project: https://github.com/luyadev/luya-theme-skeleton

This is what these files could look like:

Theme configuration file `theme.json`:

|variable|description|example
|--------|-----------|-----
|name|The name which is displayed in the Theme Manager|`my-super-name`
|description|A description what this theme include or what its built on|`My Super Theme based on Bootstrap 4 and JQuery`
|pathMap|Read more about in Additional path map|`[]`
|parentTheme| Read more about in the File inheritance/override section|`null`

```json 
{
    "name": "my-super-theme",
    "parentTheme": null,
    "pathMap": [],
    "description": "A theme based on Bootstrap 4 free creative theme (https://startbootstrap.com/themes/creative/)"
}
```

Composer configuration file `composer.json`:

```json
{
    ...
    "type": "luya-theme",
    ...
    "extra": {
        "luya": {
            "themes": [
                "src/theme.json"
            ]
        }
    }
}
```

Layout file `layouts/theme.php`:

```php
<?php
$this->beginPage();
?>
<html>
    <head>
        <title><?= $this->title; ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <?= $content ?>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
```

CMS layout file `cmslayouts/theme.php`:

```php
<div>
    <?= $placeholders['main'] ?>
</div>
```

## Import and Activate

While running the import command (`./vendor/bin/luya import`), the theme information will be loaded from the `theme.json` and stored in the database. The command will list the imported themes and layouts after running.

After a succesfull import of the new theme, the theme itself can be activated in the CMS Admin *Themes* section.
**For each new and exists pages you have to set/change the selected layout file.**

![theme-management](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/theme-management.png "LUYA theme management")

> For developing purposes themes can also be activated withing the {{luya\theme\ThemeManager}} component with {{luya\theme\ThemeManager::$activeThemeName}} property.

## Additional path map (`pathMap`)

It is also possible to define additional path for inheritance by adding a path map in the theme config. In this way block and widget views can also be override with a theme:

```json
{
    "pathMap": [
        "@moduleAlias/frontend/views"
    ]
}
```

These additional paths will be added to the end of the path map:

1. @app/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
2. @blueTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
3. @blankTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
4. @moduleAlias/frontend/views => [ @app/views, @blueTheme/views, @blankTheme/views ]

### File inheritance/override (`parentTheme`)

Theme inherit all view files from their parents. Only if a theme has the same view file as its parent than this file will be used while rendering.

The blank theme (base):

```json
{
    "name": "Blank theme"
}
```

The blue theme based on blank theme:

```json
{
    "name": "Blue theme",
    "parentTheme": "@app/themes/blank"
}
```

In the above example the blank theme could have the view `@blankTheme/views/site/index`. The blue theme does need to have this view file because it will inherit from the blank theme.

**But the views from `@app/views` will be override all other theme views**.

The order of view inheritance (pathMap) will looks like this:

1. Requested path => [theme paths]
2. @app/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
3. @blueTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]
3. @blankTheme/views => [ @app/views, @blueTheme/views, @blankTheme/views ]


At first search the requested path in the first column. On a match searching in the list of theme paths for a exists file in the defined order.

## Theme packages

When developing a LUYA theme for distribution via Packagist, the theme information can be stored in the `composer.json`. This makes the installation process for the consumer very short. Adding the theme package to the `composer.json` run `composer update` and `luya import` and the theme appears in the *Layouts* overview.

In the `extra.luya.themes` section of the `composer.json` an array with themes can be provided. Either a path to a folder which contains the `theme.json` or a direct path to a `theme.json` file is possible:


```json
{
    "extra": {
        "luya" : {
            "themes": [
                "src/theme1",
                "src/theme2/theme.json"
            ]
        }
    }
}
```

Both definitions are valid, either with the folder where the `theme.json` is contained or directly point to the `theme.json` file.
