# Create a LUYA Application

The LUYA installation requires Composer, please have a look at the [official Composer website](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) if you haven´t installed on your system yet.

> Find the [installation Video on Youtube](https://www.youtube.com/watch?v=Ybq878PMe_U) in order to help you install LUYA.

First of all it´s mandatory to install the global `fxp/composer-asset-plugin` plugin, which is required by Yii to install bower packages via composer. To install the `fxp/composer-asset-plugin` globally open your terminal and run the following command:

```sh
composer global require "fxp/composer-asset-plugin:~1.4"
```

After setting up Composer, we execute the Composer command `create-project` to checkout the **luya-kickstarter** application, an **out of the box** LUYA setup to run your website directly. It´s recommend to run the `create-project` command directly from your htdocs/webserver folder like this:

```sh
composer create-project luyadev/luya-kickstarter:^1.0
```

> Note: During the installation Composer may ask for your Github login credentials. This is normal because Composer needs to get enough API rate-limit to retrieve the dependent package information from Github. For more details, please refer to the [Composer documentation](https://getcomposer.org/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens).

The `create-project` command will create a folder (inside of your current folder where the `composer create-project` command was executed) named **luya-kickstarter**. 
If the Composer installation is done change into the **configs** folder inside the application and copy the `.dist` template files to original `.php` files.

```sh
cp env.php.dist env.php
cp env-local-db.php.dist env-local-db.php
```

Now the database connection inside the `configs/env-local-db.php` file needs to fit your mysql servers configuration. 
It´s recommend to open all config files once to change values and understand the behavior. In order to understand the config files read more in the [environment configs section](install-environments.md). 
After successfully setting up your database connection, you have to reopen your terminal and change into your project directory and excute the **luya** binary files which has been installed into your vendor folder by composer as described in the follwing.

Run the migration files with the [migrate console command](luya-console.md):

> Note: If the migration process failed, try to replace localhost with 127.0.0.1 in the database DNS configuration `(env-local-db.php)` which is located in the  configs folder.

```sh
./vendor/bin/luya migrate
```

Build and import all filesystem configurations into the database with the [import console command](luya-console.md):

```sh
./vendor/bin/luya import
```

Finally execute the [setup console command](luya-console.md) command which is going to setup a user, group and permissions:

```sh
./vendor/bin/luya admin/setup
```

The setup process will ask you for an email and password to store your personal login data inside the database (of course the password will be encrypted).

> `./vendor/bin/luya health` will make a small check if several directories exist and readable/writable.

You can now log in into the administration interface, e.g. `http://localhost/luya-kickstarter/public_html/admin` (dependings on the location of the LUYA files).

> Visit the [Installation Problems and Questions Site](install-problems.md) when you have any problems with the LUYA setup.

---

### What's next?

+ [Understanding the LUYA Core](concept-core.md)
+ [Create new CMS layout](app-cmslayouts.md)
+ [Create new CMS block](app-blocks.md)
+ [Build navigations / Menus](app-menu.md)
