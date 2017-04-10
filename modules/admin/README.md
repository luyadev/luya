LUYA Administration Interface
==========

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Build Status](https://travis-ci.org/luyadev/luya-module-admin.svg?branch=master)](https://travis-ci.org/luyadev/luya-module-admin)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya-module-admin/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya-module-admin?branch=master)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-admin/downloads)](https://packagist.org/packages/luyadev/luya-module-admin)

Administration Interface based on [Angular JS](https://angularjs.org/), [Materialize CSS](http://materializecss.com/) and [Yii 2](http://www.yiiframework.com/) (which is wrapped in the LUYA CORE).

![LUYA Admin Interface](https://raw.githubusercontent.com/luyadev/luya-module-admin/master/luya_admin.png)

## Features:

+ CRUD (based on RESTful and Angular)
+ Scaffolding CRUDs
+ Syncing Project between Environments
+ Storage System for Files and Images, also known as File Manager.
+ Permission System with Users and Groups.
+ Searching trough all Modules and Models.

## Installation

Install the module trough composer:

```sh
composer require luyadev/luya-module-admin:1.0.0-RC3
```

Add the module to your configuration file within the modules section:

```php
'modules' => [
    // ...
    'admin' => [
        'class' => 'luya\admin\Module',
    ]
]
```

The module is now registered and installed. In order to comple the installation run the migrate, import and setup command:

Database Migration:

```sh
./vendor/bin/luya migrate
```

Import:

```sh
./vendor/bin/luya import
```

Setup (Setting up the User and Group)

```sh
./vendor/bin/luya admin/setup
```

You can now login to your Administration Interface by adding the admin module in the Url: `http://example.com/admin`