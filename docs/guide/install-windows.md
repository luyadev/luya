Create a new Luya Project on Windows and XAMPP
================

With those few steps you can install *LUYA* on your System. To install *LUYA* you have to install [Composer](https://getcomposer.org/doc/00-intro.md#installation-windows) on your Windows System.

First of all you have to install the global `fxp/composer-asset-plugin` plugin, which is required by Yii to install bower packages via composer. So open your Command Prompt go into your Webserver folder and insert:

```sh
composer global require "fxp/composer-asset-plugin:~1.2"
```

After that, we execute the composer `create-project` to checkout the **luya-kickstarter** project (a basic project you can start with out of the box).

```sh
composer create-project luyadev/luya-kickstarter:1.0.0-RC2
```

This above command will create a folder (inside of your current folder where the `composer create-project` command was execute) named __luya-kickstarter__. After the command is finished go into the **configs** folder inside your application and copy the dist template files to original php files.

```sh
copy env.php.dist env.php
copy env-local-db.php.dist env-local-db.php
```

Now change the database connection inside the `configs/env-local-db.php` file to fit your mysql servers configuration. You should open all config files once to change values and understand the behavior. After successfully setting up your database connection, you have to reopen your Command Prompt and change into your project directory and excute the console command at `public_html` folder.

> `php` command is available if you already add your php.exe path on your system environment variable

Create all Database tables:

```sh
php index.php migrate
```

Import specific data into the Database:

```sh
php index.php import
```

At least we execute the setup command which will install an administration area user, group and sets the lowest permission.

```
php index.php setup
```

The setup proccess will ask you for an email and password to store your personal login data inside the database (of course the password will be encrypted).

> `php index.php health` will make a small check if several directorys are readable etc.

You can now log in into your administration interface `http://localhost/luya-kickstarter/public_html/admin` (depending on where you have located the luya files). When you have successfull logged into the administration area, navigate to **System** -> **Groups** and click **Authorizations**. This will open an Active Window where you can enable all permissions for your Group.

Problems
--------

When you have Problems with installing *LUYA* or have unexpected errors or strange behaviors, let us know and [Issue on GitHub](https://github.com/luyadev/luya/issues) or [Join the Gitter Chat](https://gitter.im/luyadev/luya) we love your Feedback!

[![Join the chat at https://gitter.im/luyadev/luya](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/luyadev/luya?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
