Help us improve LUYA
==================

If you like to contribute to the LUYA project, you only have to follow five steps:

1. Fork the [luyadev/luya](https://github.com/luyadev/luya) project to your account
2. Define your working environment
3. Rebase the master
4. Create a new branch
5. Commit, push and create a pull-request

Fork
------
To fork [LUYA](https://github.com/luyadev/luya) click on the *"fork"* button in GitHub, this will create a copy of the repository on your account.
After forking the repository you have to clone it via `git clone https://github.com/yourusername/luya` to create a local copy on your computer or webserver.

![fork-luya](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/start-collaboration-fork.jpg "Fork Luya")

> Tips with [git clone](https://help.github.com/articles/importing-a-git-repository-using-the-command-line/).

Working environment
---------------

After successfully cloning the repository into your webserver or local computer, you will find a folder `envs/dev` in your forked *LUYA* project.
This is the working environment where you can test all functions and modules directly with your local *LUYA* source code (including all modules).

But the `envs/dev` environment needs to be configured first. To do so, go into the *configs* folder `envs/dev/configs` and duplicate the file `env.php.dist` to `env.php`.
Modify all components and modules to fit your needs. Don't forget to create a database and configure your *database settings* by entering your specific database server settings.

```sh
cp  env.php.dist env.php
```
> Make sure your database information and setting are correctly configured in `configs/env.php`.

Assuming you've have already [installed composer](install.md) on your computer, you can now run `composer install` inside of your `envs/dev` folder, this will install
all required dependencies and create the PSR-4 mappings to your local *LUYA* library files (*src*, *modules*, etc.).

After `composer install` simply run these terminal commands in your console:

1.) Navigate into your *public_html* folder:

```sh
cd public_html
```

2.) Create all needed database structures:

```sh
php index.php migrate
```

3.) Import all provided block and module data from *envs* to your database:

```sh
php index.php import
```

4.) Finally after finishing the import process, you've to setup the environment instance by configuring your user account:

```sh
php index.php admin/setup
```

5.) Open the *public_html* folder of your dev environment in your browser `localhost/luya/envs/dev/public_html`.

> To access the admin area visit `localhost/luya/envs/dev/public_html/admin` 

Rebase your master
------------------

We have added a little script which will rebase your master and bring your local version up to date. From this clean base you're able to create new
branches from the dev-master branch where you'll check in your changes.
The *rebasemaster* script will configure the original `luyadev/luya` repo as upstream, switch into the master branch and update the code.

> When you run the *rebasemaster* script for the first time, you have to add the init flag, this will configure the upstream.

```sh
./scripts/rebasemaster.sh init
```

When you have configured the upstream with init, just execute the following command:

```
./scripts/rebasemaster.sh
```

Create a branch
----------------

To avoid having conflicts with your master branch, always create a new branch from the current upstream branch.
Just run the *rebmastermaster* script and create a new branch afterwards.

```sh
git checkout -b your-fix-branch master
```

Commit, push and pull request
-----------------------------

You're now able to commit all your changes into this new branch you've just created. After committing all the changes, you've to push the changes to
your forked repository on GitHub:

```sh
git push origin
```

Visit your *LUYA* fork on GitHub and you'll see a **pull request** Button. Click to create a pull request:

![pull-request](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/start-collaboration-pull-request.jpg "Pull request")
