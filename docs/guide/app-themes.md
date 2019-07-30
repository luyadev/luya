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

### Configure active theme

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
    "name" : "Blank theme"
}
```

The *blue* theme based on *blank* theme:

```theme.json
{
    "name" : "Blue theme"
    "parentTheme" : "@app/themes/blank"
}
```


## Import Method

The application and all modules can have a *themes* directory which will be loaded when running the [console command `import`](luya-console.md). 

> One of the main ideas behind LUYA is to store data in files and import them into your database.

## Links

+ [Frontend Module guide](app-module-frontend.md)
+ [Admin Module guide](app-admin-module.md)
