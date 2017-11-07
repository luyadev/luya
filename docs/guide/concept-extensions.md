# Extensions

LUYA provides a flexible way to extend the system with your custom modules, blocks and functions.

## Composer types

As LUYA is built upon the composer package manager every extension must be included via composer. Therefore first create your own composer package by creating a `composer.json` file, e.g.:

```json
{
    "name": "username/package",
    "type": "luya-extension",
    "minimum-stability": "stable",
    "require": {
        "luyadev/luya-core": "1.0.0-RC4"
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
|luya-extension|Is used when you have blocks, helpers, assets and other files but no module.
|luya-module|Can contain the same as luya-extension but also modules. This packages are also listed on luya.io in the guide section.

## Extra section

The composer.json file can contain an extra section which can be read by the LUYA composer. E.g. we could do the following things:

```json
"extra" : {
    "luya" : {
        "blocks": [
            "path/to/blocks"
        ],
        "bootstrap": [
            "src/MyBootstrapClass.php"
        ]
    }
}
```

+ blocks: Include the provided folders or blocks while import command.
+ bootstrap: Add the file to the LUYA bootstraping process.

> When importing blocks a namespace for each block class have to be provided. You can use the [Composer autoloading](https://getcomposer.org/doc/01-basic-usage.md#autoloading) feature handle namespaces.
