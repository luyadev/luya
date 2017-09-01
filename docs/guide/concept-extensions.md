# Extensions

LUYA provides a flexible way to extend the system with your custom modules, blocks and functions.

## Composer Types

As LUYA is built upon the composer package manager, every extension must be included via composer. Thefore first create your own composer package by creating a `composer.json` file.

```json
{
    "name": "username/package",
    "type": "luya-exxtension",
    "minimum-stability": "stable",
    "require": {
        "luyadev/luya-core": "1.0.0-RC4"
    },
    "extra": {
    
    }
}
```

The following **type**s are supported by luya composer

+ luya-extension
+ luya-module

|type|description
|----|----------
|luya-extension|Is used when you have blocks, helpers, assets and other files but no module.
|luya-module|Can contain the same as luya-extension but also modules. This packages are also listed on luya.io guide section.

## Extra Section

The composer.json file can contain an extra section which can be read by the luya composer. We can do the following things

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

+ blocks: Include the provide folders or blocks while import command.
+ bootstrap: Add the file to the LUYA bootstraping process.