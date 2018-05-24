# Admin modules

An admin module provides the ability to quickly create an admin UI section for your data. The LUYA Crud system is called [[ngrest-concept.md]] or you can also use [[app-admin-controllerview.md]] in order to render a view with data from a controller.

Some features available in the admin UI section:

+ Create, read, update and delete with AngularJS and Yii2 base on Active Records => [[ngrest-concept.md]]
+ Display custom data with a controller and view file => [[app-admin-module-controllerview.md]]
+ Storage system for uploading images and files => {{luya\admin\storage\BaseFileSystemStorage}}
+ Permissions and admin UI menus => [[app-admin-module-permission.md]]
+ APIs

## Creating an admin module

You can use the [[app-console.md]] `module/create` to scaffold quickly all the required folders and files. The scaffolding command will generate a new folder structure like this:

```
.
└── mymodule
    ├── admin
    │   ├── aws
    │   ├── migrations
    │   └── Module.php
    ├── frontend
    │   ├── blocks
    │   ├── controllers
    │   ├── Module.php
    │   └── views
    ├── models
    └── README.md
```

Let´s assume we use the module name `mymodule`, so you will have a new folder `mymodule` inside the modules folder of your application with the folders `admin` and `frontend` and `models`. As models can be in booth admin and frontend context this is where your module shared data belongs to.

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

> Hint: Keep in mind, if you are creating a module for admin usage, the admin name in the config must contain a suffix like `mymoduleadmin` otherwise using only `mymodule` for admin modules will give you some disadvantages.
