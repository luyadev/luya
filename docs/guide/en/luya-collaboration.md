help creating LUYA
==================
If you like to contribute to the LUYA project you can easyl follow thes few steps:

1. fork the [zephir/luya](https://github.com/zephir/luya) project to your account..
2. Define your working environment
3. Rebase the master
4. Create a new branch
5. Commit, push and pull-request

Forken
------
To Fork the the [LUYA](https://github.com/zephir/luya) project click on the FORK Button, this will create a copy of the repository on your account. After forking the repositor you have to clone it into your local composer  via `git clone https://github.com/yourusername/luya`. 

![fork-luya](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/start-collaboration-fork.jpg "Fork Luya")

> Tipps with [git clone](https://help.github.com/articles/importing-a-git-repository-using-the-command-line/).

Wokring Environemnt
---------------

After successfull clone into your localhost you will find a folder `envs/dev` in your LUYA fork project. This is the working environemnt you can test all functions and modules directly against the luya source code (even of the modules).

So now you have to configure the envs/dev environemnt, to do this go into the configs folter `envs/dev/configs` and copy the file `server.php.dist` to `server.php` and change all the environemnt setting you whish. The most important will be the *Database Component* you have to configure matching your server settings.

> The `server.php` is in gitingore list.

As we assumen you have installe composer now you can rown `composer install` inside of your `envs/dev` folter, this will installed all required depenencies and create the psr4 mappings to the local files.

After that we are only have to do the basic terminal commands in your console:

Install Database:

```sh
./vendor/bin/luya migrate
```

Import data from env to databse

```sh
./vendor/bin/luya import
```

and finally setup the envs instance to login with your user:

```sh
./vendor/bin/luya setup
```

After this you can now open the public_html folder in your browser of your dev env `localhost/luya/envs/dev/public_html`.

