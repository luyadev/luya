# Common Setup Problems

There are few things people stumble upon mostly when installing LUYA.

## Language

+ After setting up the project and run the `setup` process the message `The requested language 'en' does not exist in language table` appears and a 404 error exception will be thrown. In order to fix this, make sure you have the same default language short code in your database (you have entered or used the default value in the setup process) and your configuration file in the `composition` section `'default' => ['langShortCode' => 'en']`. Those two values must be the same.

## Composer

+ During the installation Composer may ask for your Github login credentials. This is normal because Composer needs to get enough API rate-limit to retrieve the dependent package information from Github. For more details, please refer to the [Composer documentation](https://getcomposer.org/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens).
+ When you encounter errors with composer install/update, make sure you have installed the version **1.0.0** of composer, in order to update your composer run `composer self-update`.
+ As Yii requies the `fxp/composer-asset-plugin` make sure you have at least version `1.3` installed of the plugin, in order to update the composer-asset-plugin run `composer global require "fxp/composer-asset-plugin:~1.3"`.

## Server requirements

In order to run LUYA with deployer nicely on a production server, the following components should be installed (we use the most common components apache2 and mysql, of course you can run LUYA with other database components and webservers like nginx):

+ php 7.0 (or higher)
+ mysql 5.5 (or higher)
+ php extensions: curl, fileinfo, mbstring, icu, phar
+ apache modules: mod_rewrite
+ git (for deployer)
+ composer (for deployer)
+ ssh access (for deployer)

## Require the dev-master

Maybe you like to test the latest features of LUYA, so you can use the fowllowing composer json requirements, but do not forget to read the [UPGRADE.MD](https://github.com/luyadev/luya/blob/master/UPGRADE.md).

```json
"require": {
    "luyadev/luya-core" : "^1.0@dev",
    "luyadev/luya-module-admin" : "^1.0@dev",
    "luyadev/luya-module-cms" : "^1.0@dev"
}
```

## Ask us!

+ When you have problems with installing *LUYA* or have unexpected errors or strange behaviors, [create an issue on GitHub](https://github.com/luyadev/luya/issues).
+ Join our Slack Team: [![Join the Slack Team](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)
+ Join Gitter to get help from the Community: [![Join the chat at https://gitter.im/luyadev/luya](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/luyadev/luya?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
