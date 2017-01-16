# Problems during installation

## Problems

There are few things people stumble upon mostly.

### Language

After setting up the project and run the `setup` process the message `The requested language 'en' does not exist in language table` appears and a 404 error exception will be thrown. In order to fix this, make sure you have the same default language short code in your database (you have entered or used the default value in the setup process) and your configuration file in the `composition` section `'default' => ['langShortCode' => 'en']`. Those two values must be the same.

### Composer

When you encounter errors with composer install/update, make sure you have installed the version **1.0.0** of composer, in order to update your composer run `composer self-update`.

As Yii2 requies the `fxp/composer-asset-plugin` make sure you have at least version `1.1.4` installed of the plugin, in order to update the composer-asset-plugin run `composer global require "fxp/composer-asset-plugin:~1.1"`.

### Ask us!

When you have problems with installing *LUYA* or have unexpected errors or strange behaviors, let us know by creating an [issue on GitHub](https://github.com/luyadev/luya/issues) or [Join the Gitter Chat](https://gitter.im/luyadev/luya) we would loved to have your Feedback!

[![Join the chat at https://gitter.im/luyadev/luya](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/luyadev/luya?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Require the dev-master

Maybe you like to test the newest features of LUYA, so you can use the fowllowing composer json requirements, but do not forget to read the [README.MD](https://github.com/luyadev/luya/blob/master/UPGRADE.md).

```json
"require": {
    "luyadev/luya-core" : "^1.0@dev",
    "luyadev/luya-module-admin" : "^1.0@dev",
    "luyadev/luya-module-cms" : "^1.0@dev"
}
```
