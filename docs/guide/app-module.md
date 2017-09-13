# Project Module

A very important behavior in *LUYA* projects are **modules**. You can always use modules to put your own custom and reusable logic inside. For instance you can put database logic inside of the via ActiveRecord models. A module can also provide informations for other module, for example [CMS Blocks](app-blocks.md). 

## Module Types

There are two different types of Modules:

+ [Admin](app-admin-module.md) - Contains Models, Migrations Administration, [NgRest Crud](ngrest-concept.md).
+ [Frontend](app-module-frontend.md) - Contains controllers and views, logic for frontend implementations.

> In order to create your custom modules you can run the [Console Command](luya-console.md) `module/create` wizard.

Structure of Modules

```
.
├── admin
│   ├── assets
│   ├── apis
│   ├── importers
│   ├── controllers
│   ├── migrations
│   └── resources
├── frontend
│   ├── assets
│   ├── controllers
│   ├── blockgroups
│   ├── blocks
│   └── views
├── models
└── helpers
```

### Use and configure

To integrate a module you have to define it in your config file `env-prep.php` and / or `env-prod.php`, depending on which environment your `env.php` is returning, in the modules section:

```php
$config = [
    'modules' => [
        'contact'=> 'app\modules\team\Module'
    ]
];
``` 

## Example Module

In our example we make a *TEAM Module* which has a frontend and admin module part. All admin modules have by defintion the suffix **admin**, the naming of the modules would look like this in our case:

+ team *Frontend* `modules/team/Module.php`
+ teamadmin *Admin* `modules/teamadmin/Module.php`


```php
<?php
namespace app\modules\team;

class Module extends \luya\base\Module
{

}
```

The *Admin* Module `modules/teamadmin/Module.php`:

```php
<?php
namespace app\modules\teamadmin;

class Module extends \luya\admin\base\Module
{

}
```


## Import Method

All modules can contain a `import(\luya\console\interfaces\ImportController $import)` import method, this method will be called when running the [console command `import`](luya-console.md). One of the main ideas behind LUYA is to store data from programmatic files into your database while importing. If the `import()` method returns an array each class must extend the `luya\console\Importer` class.

Example response for multiple importer classes:

```php
public function import(\luya\console\interfaces\ImportController $import)
{
    return [
        '\\luya\\cms\\importers\\BlockImporter',
        '\\luya\\cms\\importers\\CmslayoutImporter',
    ];
}
```

Example code where import directly does handle some code:

```php
public function import(\luya\console\interfaces\ImportControllerInterface $import)
{
    foreach ($import->getDirectoryFiles('filters') as $file) {
        $filterClassName = $file['ns'];
        if (class_exists($filterClassName)) {
            $object = new $filterClassName();
            $import->addLog('filters', implode(", ", $object->save()));
        }
    }
}
```

## PSR-4 binding with composer

Sometimes you dont want to use the long namespaces names like `app\modules\mymodule` and create a shorter way to access your files. In order to add a shorter *alias* to your namespace you psr-4 bind them in your composer.json file. To do so open the `composer.json` file and add the *autoload* section (if not exists):

```json
"autoload" : {
    "psr-4" : {
        "mymodule\\" : "app/modules/mymodule"
    }
}
```

Run the `composer dump-autoload` command in order to refresh the autoload section of your composer file. Now you are able to access the *mymodule* files directly with the *mymodule* module namepsace.

## Links

+ [Frontend Modul guide](app-module-frontend.md)
+ [Admin Modul guide](app-admin-module.md)
