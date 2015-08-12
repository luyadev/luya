Create a new Luya Project
================

First of all you have to install the `fxp/composer-asset-plugin` plugin, which is required by Yii to install bower packages via composer:

```
composer global require "fxp/composer-asset-plugin:1.0.3"
```

Open your Terminal and execute the `create-project` to checkout the kickstarter/example project. 

```
composer create-project zephir/luya-kickstarter:dev-master 
```

This above command will create a folder (inside of your current folder where the `composer create-project` command was execute) named __luya-kickstarter__. After the command is finished (can take some time) you can move all the files where ever you want to have them.

Go into your configs folder inside your application and copy the dist template files to original php files:

```
cp server.php.dist server.php
cp prep.php.dist prep.php
cp local.php.dist local.php
```

Now change the database connection inside the `configs/local.php` file to your custom config. You should open all config files once to change values and understand the behavior. After successfully setting up your database connection, you have to reopen your Terminal and change into your project `public_html` directory:

```
cd /path/to/your/project/public_html
```

now execute the php command

```
php index.php migrate
```

It will ask for your permissions to execute the database migrations.

now execute the php command:

```
php index.php exec/setup
```

The setup proccess will ask you for an email and password to store your personal login data inside the database (of course the password will be encrypted).

You can now log in into your administration interface http://localhost/project/__admin__. When you have successfull logged into the administration area, navigate to __Administration -> Gruppen__ click on `Berechtigung` in the first group. A modal dialog will display all rights, select all and save. Now you have the ability to administrate all sections. enjoy! 

PHP Settings
------------

|Config |Value
|--- |----
|short_open_tags | 1
|memory_limit |512
|max_execution_time|60
|post_max_size|16M
|upload_max_filesize|16M