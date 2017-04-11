LUYA CMS
========

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Build Status](https://travis-ci.org/luyadev/luya-module-cms.svg?branch=master)](https://travis-ci.org/luyadev/luya-module-cms)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya-module-cms/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya-module-cms?branch=master)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-cms/downloads)](https://packagist.org/packages/luyadev/luya-module-cms)

This module provides a full functional Content Management System to added contents based on Blocks.

To use the LUYA CMS module you have to run a LUYA Application which is provided by the Luya core.

For installation and usage please check: [LUYA.IO](https://luya.io)

### Setup

Install the module trough composer:

```sh
composer require luyadev/luya-module-cms:1.0.0-RC3
```

Add frontend and admin module of the cms module to your configuration modules section and bootstrap the cms frontend module:

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

> The module names *cms* and *cmsadmin* are required and should not be changed!.

Run the `migrate` and `import` command.
