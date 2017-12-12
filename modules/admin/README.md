<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# LUYA Administration Interface module

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Build Status](https://travis-ci.org/luyadev/luya-module-admin.svg?branch=master)](https://travis-ci.org/luyadev/luya-module-admin)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya-module-admin/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya-module-admin?branch=master)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-module-admin/v/stable)](https://packagist.org/packages/luyadev/luya-module-admin)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-admin/downloads)](https://packagist.org/packages/luyadev/luya-module-admin)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

Administration Interface based on [AngularJs](https://angularjs.org/), [Bootstrap 4](https://getbootstrap.com) and [Yii 2 Framework](http://www.yiiframework.com/) (which is wrapped in the LUYA CORE).

![LUYA Admin Interface](https://raw.githubusercontent.com/luyadev/luya-module-admin/master/luya_admin.png)

+ CRUD (based on RESTful and Angular)
+ Scaffolding CRUDs
+ Syncing Project between Environments
+ Storage System for Files and Images, also known as File Manager.
+ Permission System with Users and Groups.
+ Searching trough all Modules and Models.

## Installation

For the installation of modules Composer is required.

```sh
composer require luyadev/luya-module-admin:~1.0.0
```

### Configuration 

After installation via Composer include the module to your configuration file within the modules section.

```php
'modules' => [
    // ... 
    'admin' => [
        'class' => 'luya\admin\Module',
    ]
]
```

### Initialization 

After successfully installation and configuration run the migrate, import and setup command to initialize the module in your project.

1.) Migrate your database.

```sh
./vendor/bin/luya migrate
```

2.) Import the module and migrations into your LUYA project.

```sh
./vendor/bin/luya import
```

3.) Create admin user and and user groups.

```sh
./vendor/bin/luya admin/setup
```

You can now login to your Administration Interface by adding the admin module in the Url: `http://example.com/admin`
