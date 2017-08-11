# Admin Modules

An Admin Module provides the ability to quickly create an adminstration section for your data. The LUYA Crud system is called [[ngrest-concept.md]] or you can also use [[app-admin-controllerview.md]] in order to render a view with data from a controller.

Some features available in the Admin section:

+ Create, Read, Update and Delete with Angular and Yii base on Active Records => [[ngrest-concept.md]]
+ Display custom Data with a Controller and View File => [[app-admin-controllerview.md]]
+ Storage System for uploading images and files => {{luya\admin\components\StorageContainer}}
+ Permissions and Admin Menus => [[app-admin-module-permission.md]]
+ APIs

## Creating an Admin Module

You can use the [[app-console.md]] `module/create` to scaffold quickly all the required folders and files. The scaffolding command will genearte a new folder structure like this assuming we use the module name `mymodule`:

```
.
└── mymodule
    ├── admin
    │   ├── aws
    │   ├── migrations
    │   └── Module.php
    ├── frontend
    │   ├── blocks
    │   ├── controllers
    │   ├── Module.php
    │   └── views
    ├── models
    └── README.md
```

So you will have a new folder `mymodule` inside the modules folder of your application with the folders `admin` and `frontend` and `models`. As models can be in booth admin and frontend context this is where your module shared data belongs to.

In order to add the modules to your application go into the modules section of your config and add your frontend and admin modules as following:

```php
return [
    'modules' => [
        // ...
        'mymodule' => 'app\modules\mymodule\frontend\Module',
        'mymoduleadmin' => 'app\modules\mymodule\admin\Module',
        // ...
    ],
];
```