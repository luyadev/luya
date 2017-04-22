# Create a LUYA Application

With those few steps you can install *LUYA* on your Webserver. To install *LUYA* you have to install [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) on your Mac, Unix or Windows System.

> We have made an [installation Video on Youtube](https://www.youtube.com/watch?v=7StCJviSGkg) in order to help you install LUYA.

First of all you have to install the global `fxp/composer-asset-plugin` plugin, which is required by Yii to install bower packages via composer. To global install the plugin open your Terminal and run the following code:

```sh
composer global require "fxp/composer-asset-plugin:~1.3"
```

After setting up composer, we execute the composer `create-project` command to checkout the **luya-kickstarter** application, an *out of the box* setup enabling you to directly run your website. We recommend to run the `create-project` command directly from your htdocs/webserver folder:

```sh
composer create-project luyadev/luya-kickstarter:1.0.0-RC3
```

> Note: During the installation Composer may ask for your Github login credentials. This is normal because Composer needs to get enough API rate-limit to retrieve the dependent package information from Github. For more details, please refer to the [Composer documentation](https://getcomposer.org/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens).

The `create-project` command will create a folder (inside of your current folder where the `composer create-project` command was execute) named **luya-kickstarter**. After the command is finished go into the **configs** folder inside the application and copy the dist template files to original php files.

```sh
cp env.php.dist env.php
cp env-local-db.php.dist env-local-db.php
```

Now change the database connection inside the `configs/env-local-db.php` file to fit your mysql servers configuration. You should open all config files once to change values and understand the behavior. In order to understand the config files read more in the [environemnt configs section](install-configs.md). After successfully setting up your database connection, you have to reopen your Terminal and change into your project directory and excute the **luya** binary files which has been installed into your vendor folder by composer as described in the follwing.

Run the migration files with the [migrate console command](luya-console.md):

> Note: If the migration process failed, try to replace localhost with 127.0.0.1 in the database DNS configuration `(env-local-db.php)` which is located in the  configs folder.

```sh
./vendor/bin/luya migrate
```

Build and import all filesystem configurations into the database with the [import console command](luya-console.md):

```sh
./vendor/bin/luya import
```

At last we execute the [setup console command](luya-console.md) which is going to setup a user, group and permissions:

```sh
./vendor/bin/luya admin/setup
```

The setup proccess will ask you for an email and password to store your personal login data inside the database (of course the password will be encrypted).

> `./vendor/bin/luya health` will make a small check if several directories exist and readable/writable.

You can now log in into your administration interface `http://localhost/luya-kickstarter/admin` (depending on where you have located the LUYA files).

> Visit the [Installation Problems and Questions Site](install-problems.md) when you have any problems with the LUYA Setup.
