Create a new Luya Project
================

With those few steps you can install *LUYA* on your Webserver. To install *LUYA* you have to install [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) on your Mac, Unix or Windows System.

> We have made an [installation Video on Youtube](https://www.youtube.com/watch?v=7StCJviSGkg) in order to help install LUYA.

First of all you have to install the global `fxp/composer-asset-plugin` plugin, which is required by Yii to install bower packages via composer. To global install the plugin open your Terminal and run the following code:

```sh
composer global require "fxp/composer-asset-plugin:1.1.4"
```

After setting up composer, we execute the composer `create-project` command to checkout the **luya-kickstarter** application, an *out of the box* setup you can directly run your website. We recommend to run the `create-project` command directly from your htdocs/webserver folder:

```sh
composer create-project luyadev/luya-kickstarter:1.0.0-beta7
```

> Note: During the installation Composer may ask for your Github login credentials. This is normal because Composer needs to get enough API rate-limit to retrieve the dependent package information from Github. For more details, please refer to the [Composer documentation](https://getcomposer.org/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens).

The `crate-project` command will create a folder (inside of your current folder where the `composer create-project` command was execute) named **luya-kickstarter**. After the command is finished go into the **configs** folder inside the application and copy the dist template files to original php files.

```sh
cp server.php.dist server.php
cp localdb.php.dist localdb.php
```

Now change the database connection inside the `configs/localdb.php` file to fit your mysql servers configuration. You should open all config files once to change values and understand the behavior. In order to understand the config files read more in the [environemnt configs section](install-configs.md). After successfully setting up your database connection, you have to reopen your Terminal and change into your project project directory and excute the **luya** binary files which has been installed into your vendor folder by composer.

Run the migration files with the [migrate console command](luya-console.md):

```sh
./vendor/bin/luya migrate
```

Build and import all filesystem configurations into the database with the [import console command](luya-console.md):

```sh
./vendor/bin/luya import
```

At least we execute the [setup console command](luya-console.md) which is going to setup an user, group and permissions:

```sh
./vendor/bin/luya setup
```

The setup proccess will ask you for an email and password to store your personal login data inside the database (of course the password will be encrypted).

> `./vendor/bin/luya health` will make a small check if several directorys are readable and exist.

You can now log in into your administration interface `http://localhost/luya-kickstarter/admin` (depending on where you have located the luya files). When you have successfull logged into the administration area, navigate to **System** -> **Groups** and click **Authorizations**. This will open an Active Window where you can enable all permissions for your Group.

Dev-Master
----------

Maybe you like to test the newest features of LUYA, so you can use the fowllowing composer json requirements, but do not forget to read the [README.MD](https://github.com/luyadev/luya/blob/master/UPGRADE.md).

```json
"require": {
    "luyadev/luya-core" : "^1.0@dev",
    "luyadev/luya-module-admin" : "^1.0@dev",
    "luyadev/luya-module-cms" : "^1.0@dev",
    "luyadev/luya-module-cmsadmin" : "^1.0@dev"
}
```

Problems
--------

### Composer

When you encounter errors with composer install/update, make sure you have installed the version **1.0.0** of composer, in order to update your composer run `composer self-update`.

As Yii2 requies the `fxp/composer-asset-plugin` make sure you have at least version `1.1.4` installed of the plugin, in order to update the composer-asset-plugin run `composer global require "fxp/composer-asset-plugin:~1.1"`.

### Ask us!

When you have Problems with installing *LUYA* or have unexpected errors or strange behaviors, let us know and [Issue on GitHub](https://github.com/luyadev/luya/issues) or [Join the Gitter Chat](https://gitter.im/luyadev/luya) we love your Feedback!

[![Join the chat at https://gitter.im/luyadev/luya](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/luyadev/luya?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)