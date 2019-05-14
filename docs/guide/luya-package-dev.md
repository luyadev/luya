# Create package (Extension/Module)

This guide is intended to provide the very basic steps to create a LUYA Package (also known as extension or module). 
There are different type of packages:

|type|description
|----|----------
|extension|Is used when you have blocks, helpers, assets, widgets, components and other files but no module or controller.
|module|Can contain the same as an extension but also modules and controllers which needs to be registered in the config of the application.

In this guide we will give you a very basic step by step instruction in **how to create an extension** with a block for the cms which will be distributed over the packagist package manager.

## Create basic extension with a block

You can use this sekeleton for a new package: https://github.com/luyadev/luya-package-skeleton

```sh
git clone https://github.com/luyadev/luya-package-skeleton
cd luya-package-skeleton
```

1. Create a repository on GitHub, make sure the repository is public, otherwise we can not register on packagist.org.

2. Create a composer.json with basic informations about the vendor and package name. Replace username with your github username or vendor name, and package with the package name. Example `nadar/luya-material-blocks`.

```json
{
    "name": "username/package",
    "type": "luya-extension",
    "require-dev": {
        "luyadev/luya-testsuite": "^1.0"
    },
    "autoload" : {
        "psr-4" : {
            "username\\package\\" : "src/",
        }
    },
    "extra": {
      "luya" : {
        "blocks": [
            "src{{DS}}blocks"
        ]
      }
    }
}
```


3. As we have mappend the namespace `username\package` into the `src/` folder you can now create you block inside the src folder, example `src/HeroBlock.php`.

```php
<?php
namespace username\package;

use luya\cms\base\PhpBlock;

class HeroBlock extends PhpBlock
{
    // code for block goes here ...
}
```

4) In order to test the blocks you can register with Composer https://getcomposer.org/doc/05-repositories.md#path or provide the cms admin the path to the blocks `'cmsadmin' => ['blocks' => 'path/to/blocks/src']]`.
5) Now you should commit and push the code to github and register the package on packagist: https://packagist.org/packages/submit

## Composer definition informations

As LUYA is built upon the composer package manager every extension must be included via composer. Therefore first create your own composer package by creating a `composer.json` file, e.g.:

```json
{
    "name": "username/package",
    "type": "luya-extension",
    "minimum-stability": "stable",
    "require": {
        "luyadev/luya-core": "^1.0"
    },
    "extra": {
    
    }
}
```

The following **types** are supported by LUYA composer

+ luya-extension
+ luya-module

|type|description
|----|----------
|luya-extension|Is used when you have blocks, helpers, assets, widgets, components and other files but no module or controller.
|luya-module|Can contain the same as luya-extension but also modules and controllers.

### Extra section

The composer.json file can contain an extra section which can be read by the LUYA composer. E.g. we could do the following things:

```json
"extra" : {
    "luya" : {
        "blocks": [
            "path{{DS}}to{{DS}}blocks"
        ],
        "bootstrap": [
            "src{{DS}}MyBootstrapClass.php"
        ]
    }
}
```

+ blocks: Include the provided folders or blocks while import command. Use `{{DS}}` for the directory seperator, the luya composer plugin auto replace by current OS specific directory seperator.
+ bootstrap: Add the file to the LUYA bootstraping process.

> When importing blocks a namespace for each block class have to be provided. You can use the [Composer autoloading](https://getcomposer.org/doc/01-basic-usage.md#autoloading) feature handle namespaces.
