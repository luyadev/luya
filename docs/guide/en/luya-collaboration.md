Help us improve LUYA
==================

If you like to contribute to the LUYA project you can easyl follow thes few steps:

1. Fork the [zephir/luya](https://github.com/zephir/luya) project to your account.
2. Define your working environment
3. Rebase the master
4. Create a new branch
5. Commit, push and create pull-request

Fork
------
To Fork the the [LUYA](https://github.com/zephir/luya) project click on the FORK Button, this will create a copy of the repository on your account. After forking the repositor you have to clone it into your local composer  via `git clone https://github.com/yourusername/luya`. 

![fork-luya](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/start-collaboration-fork.jpg "Fork Luya")

> Tipps with [git clone](https://help.github.com/articles/importing-a-git-repository-using-the-command-line/).

Working environment
---------------

After successfull clone into your webserver/computer you will find a folder `envs/dev` in your *LUYA* fork project. This is the working environment you can test all functions and modules directly against the *LUYA* source code (even of the modules).

So now you have to configure the envs/dev environment. To do so, go into the configs folder `envs/dev/configs` and copy the file `server.php.dist` to `server.php` and modify all the components and modules to fit your needs. The most important will be the *Database Component* you have to configure matching your server settings.

As we assume you have [installed composer](install.md) already on your computer now you can rown `composer install` inside of your `envs/dev` folder, this will install all required depenencies and create the psr4 mappings to the local *LUYA* library files (src, modules, etc.).

After that you just have to run the basic terminal commands in your console:

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

After this you can now open the *public_html* folder in your browser of your dev env `localhost/luya/envs/dev/public_html`.

Rebase your Master
------------------

We have added a little script where you can rebase your master to create new branches from an clean dev-master branch. The rebasemaster script will configure the original `zephir/luya` repo as upstream, switch into the master branch and update the code.

> When you run the rebasemaster script for the first time, you have to add the init flag, this will configure the upstream.

```sh
./scripts/rebasemaster.sh init
```

When you have configure the upstream with init, then just fo with the following code:

```
./scripts/rebasemaster.sh
```

Branch erstellen
----------------

To have no conflicts with your Master branch, you should always create a new branch from the current upstream branch, so run the rebmaster master script and after that create a new branch

```sh
git checkout -b your-fix-branch master
```

Commit, Push und Pull Request
-----------------------------

You can now commit all your changes into the new branch you just created, after commiting all the changes you have to push to changes to your repository on GitHub:

```sh
git push origin
```

Visit your *LUYA* Fork on GitHub now and you will see a **PULL REQUEST** Button where you can create a Pull-Request:

![pull-request](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/start-collaboration-pull-request.jpg "Pull request")


Informations about Design and CSS
=================================

Admin Design Kompilierung
-------------------------
Damit alle styles kompiliert werden, benötigen Sie folgende Programme / Plugins:

* [Compass](http://compass-style.org/install/) (gem install compass)
* [Autoprefixer-rails](autoprefixer-rails) (gem install autoprefixer-rails)

> Bei Berechtigungsfehlern kannst du die oben genannten Befehle mit "sudo" ausführen, oder die Berechtigung im Installationsverzeichniss von ruby anpassen.*

Wenn die oben genannten Befehle erfolgreich ausgeführt wurden, kannst du nun in das gewünschte Modul (Unterordner ressources/) wechseln und folgenden Befehl ausführen

```sh
compass watch
```

oder

```sh
compass compile
```

+ "compile" Befehl kompiliert alle Styles einmalig und muss bei Änderungen erneut ausgeführt werden.
+ Der "watch" Befehl kompiliert automatisch sobald eine Datei geändert wurde.

Jedes Modul hat eine eigene Compass Konfiguration (config.rb). Daher muss auch der oben genannte Befehl in jedem Modul (Unterordner ressources/) einzeln ausgeführt werden.

> Alle CMS relevanten Styles werden im SCSS Format erfasst. Dabei muss man sich an die Richtlinien der [cssguidelines](http://cssguidelin.es) halten.

