<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# LUYA CMS module


[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Build Status](https://travis-ci.org/luyadev/luya-module-cms.svg?branch=master)](https://travis-ci.org/luyadev/luya-module-cms)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya-module-cms/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya-module-cms?branch=master)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-module-cms/v/stable)](https://packagist.org/packages/luyadev/luya-module-cms)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-cms/downloads)](https://packagist.org/packages/luyadev/luya-module-cms)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

The LUYA CMS module provides a full functional Content Management System for adding contents based on blocks.

![Luya Admin](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/luya-rc4.png)

To use the LUYA CMS module you have to run a LUYA Application which is provided by the LUYA core.

For installation and usage please check: [LUYA.IO](https://luya.io)

## Installation

For the installation of modules Composer is required.

```sh
composer require luyadev/luya-module-cms:~1.0.0
```
### Configuration 

Add the frontend and admin module of the cms module to your configuration modules section and bootstrap the cms frontend module:

```php
return [
    'modules' => [
        // ...
        'cms' => 'luya\cms\frontend\Module',
        'cmsadmin' => 'luya\cms\admin\Module',
        // ...
    ],
    
    // ...
    
    'bootstrap' => [
        'cms',
    ],
];
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


> Please note that the module names *cms* and *cmsadmin* are required and should not be changed!

