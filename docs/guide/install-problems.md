# Common Setup Problems

There are few things people stumble upon mostly when installing LUYA.

## Language

+ After setting up the project and run the `setup` process the message `The requested language 'en' does not exist in language table` appears and a 404 error exception will be thrown. 
In order to fix this, make sure you have the same default language short code in your database (you have entered or used the default value in the setup process) and your configuration file in the `composition` section `'default' => ['langShortCode' => 'en']`. Those two values must be the same.

## Composer

+ During the installation Composer may ask for your GitHub login credentials. This is normal because Composer needs to get enough API rate-limit to retrieve the dependent package information from GitHub. For more details, please refer to the [Composer documentation](https://getcomposer.org/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens).
+ When you encounter errors with Composer install/update, make sure you have installed the version **1.0.0** of Composer, in order to update your Composer run `composer self-update`.
+ As Yii requires the `fxp/composer-asset-plugin` make sure you have at least version `1.4` of the plugin installed, in order to update the Composer asset plugin run `composer global require "fxp/composer-asset-plugin:~1.4"`.

## Server requirements

In order to run LUYA with deployer nicely on a production server, the following components should be installed (we use the most common components Apache2 and MySQL, of course you can run LUYA with other database components and webservers like nginx):

+ PHP 7.1 (or higher) (PHP 7.0 and PHP 5.6 should work but its not tested anymore)
+ MySQL 5.5 (or higher)
+ PHP extensions: curl, fileinfo, mbstring, icu, phar, zip
+ Apache modules: mod_rewrite
+ Git (for deployer)
+ Composer (for deployer)
+ SSH access (for deployer)

## Require the dev-master

Maybe you like to test the latest features of LUYA, so you can use the following Composer JSON requirements, but do not forget to read the [UPGRADE.MD](https://github.com/luyadev/luya/blob/master/UPGRADE.md).

```json
"require": {
    "luyadev/luya-core" : "dev-master",
    "luyadev/luya-module-admin" : "dev-master",
    "luyadev/luya-module-cms" : "dev-master"
}
```

## Ask us!

+ If you are getting problems during the installation of LUYA, unexpected errors or strange behaviors please [create an issue on GitHub](https://github.com/luyadev/luya/issues).
+ Join the Forum [forum.luya.io](https://forum.luya.io)
