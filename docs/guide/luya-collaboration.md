Help us improve LUYA
==================

If you like to contribute to the LUYA project you can easy follow these few steps:

1. Fork the [luyadev/luya](https://github.com/luyadev/luya) project to your account.
2. Define your working environment
3. Rebase the master
4. Create a new branch
5. Commit, push and create pull-request

Fork
------
To Fork the the [LUYA](https://github.com/luyadev/luya) project click on the FORK Button, this will create a copy of the repository on your account. After forking the repository you have to clone it into your local composer  via `git clone https://github.com/yourusername/luya`. 

![fork-luya](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/start-collaboration-fork.jpg "Fork Luya")

> Tipps with [git clone](https://help.github.com/articles/importing-a-git-repository-using-the-command-line/).

Working environment
---------------

After successfull clone into your webserver or local computer you will find a folder `envs/dev` in your *LUYA* fork project. This is the working environment you can test all functions and modules directly against the *LUYA* source code (even of the modules).

Now the envs/dev environment needs to be configured. To do so, go into the configs folder `envs/dev/configs` and copy the file `env.php.dist` to `env.php` and modify all the components and modules to fit your needs. The most important will be the *Database Component* you have to configure matching your server settings.

```sh
cp  env.php.dist env.php
```
> Make sure your database information and setting are correctly configured in `configs/env.php`.

As we assume you have [installed composer](install.md) already on your computer now you can run `composer install` inside of your `envs/dev` folder, this will install all required depenencies and create the psr4 mappings to the local *LUYA* library files (src, modules, etc.).

After `composer install` simply run this terminal commands in your console:

1.) Navigate into your public_html folder:

```sh
cd public_html
```

2.) Install Database:

```sh
php index.php migrate
```

3.) Import data from env to database

```sh
php index.php import
```

4.) and finally after importer has been run successfully setup the envs instance and configure your user account:

```sh
php index.php admin/setup
```

5.) Open the *public_html* folder of your dev environment in your browser`localhost/luya/envs/dev/public_html`.

> To access the admin area visit `localhost/luya/envs/dev/public_html/admin` 

Rebase your Master
------------------

We have added a little script where you can rebase your master to create new branches from an clean dev-master branch. The rebasemaster script will configure the original `luyadev/luya` repo as upstream, switch into the master branch and update the code.

> When you run the rebasemaster script for the first time, you have to add the init flag, this will configure the upstream.

```sh
./scripts/rebasemaster.sh init
```

When you have configure the upstream with init, then just fo with the following code:

```
./scripts/rebasemaster.sh
```

Create a branch
----------------

To have no conflicts with your Master branch, you should always create a new branch from the current upstream branch, so run the rebmaster master script and after that create a new branch

```sh
git checkout -b your-fix-branch master
```

Commit, Push and Pull Request
-----------------------------

You can now commit all your changes into the new branch you just created, after commiting all the changes you have to push to changes to your repository on GitHub:

```sh
git push origin
```

Visit your *LUYA* Fork on GitHub now and you will see a **PULL REQUEST** Button where you can create a Pull-Request:

![pull-request](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/start-collaboration-pull-request.jpg "Pull request")

## Module development

If you start developing your own module its recommend to place the module development directory not inside of the LUYA installation and treat it as separated project on github or on your preferred VCS. 
Include the module via `psr-4 binding` in your your `luyadev/envs/dev/composer.json` for development.

Below an example of a module inclusion for development:

1. Include your module in the `composer.json` file in the autoload section.

```php
"autoload" : {
        "psr-4" : {
        
            // other psr-4 modules
            
            "dev7\\restapi\\" : "../../../module-development/restapi/src"
        }
    }
    ```

2. Run inside of `luyadev\envs\dev` the command `composer dump-autoload` the update the autoload script.
3. Include the module in `luyadev\envs\dev\config\env.php` in the module section.

```php

// ..

modules => [
  
  // other modules
  
  'restapi' => 'dev7\restapi\frontend\Module',
  'restapiadmin' => 'dev7\restapi\admin\Module'
  
],

// ..

```

4. Ensure the namespace in your `Module.php` files match the same as in the `luyadev\envs\dev\config\env.php`, e.g. `dev7\restapi\frontend\`.






