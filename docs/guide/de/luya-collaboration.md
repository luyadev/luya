Bei LUYA mithelfen
==================
Wenn du am *LUYA* Projekt mitarbeiten möchtest kannst du mit den folgenden Schritten leicht deine Änderungen mitteilen.

1. Forke das [zephir/luya](https://github.com/zephir/luya) Projekte in deinen Account.
2. Erstelle deine Arbeitsumgebung mit `envs/dev`.
4. Rebase deinen Master
5. Erstelle einen Branch
6. Commit, Push und Pull-Request

Forken
------
Um unser *LUYA* repository zu forken klicken gehen Sie auf [zephir/luya](https://github.com/zephir/luya) und danach auf den **FORK** Knopf. Dies wird eine Kopie der aktuellen Daten von Luya in dein eigenes Github Profil erstellen welches du danach auf deinem Computer via `git clone https://github.com/deinuser/luya` auschecken kannst. 

![fork-luya](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/start-collaboration-fork.jpg "Fork Luya")

> Tipps zum Ungang mit [git clone](https://help.github.com/articles/importing-a-git-repository-using-the-command-line/)

Arbeitsumgebung
---------------
Sobald du das Repostiory auf deinem Localhost hast kannst du deine Umgebung im Ordner `envs/dev` finden.

Die Arbeitsumgebung muss nun auf dein Konfiguration angepasst werden. Wechsel deshalb in das *configs* Verzeichniss unter `envs/dev/configs` und kopier die Datei `server.php.dist` nach `server.php` und passe deine gewünschten Parameter an.

> Die `server.php` ist auf gitingore und kann somit beliebig angepasst werden.

Als nächstes führen wir den `composer install` befehl aus innerhalb des dev env projekt ordners `envs/dev`. Dies wird dir alle nötigen Resourcen in den Vendor Ordner kopieren und ein PSR4 binding auf deine lokalen *LUYA* Daten.

Nun werden die Terminal-befehle `migrate` und `setup` ausgeführt, dazu öffnen Sie das Terminal und wechseln in das Projekt Verzeichnis und führen folgende Befehle aus:

```sh
./vendor/bin/luya migrate

./vendor/bin/luya setup
```

Die Datenbank-Tabellen sind nun erstellt und eine Benutzer und deren nötigen Daten wurden eingerichtet, testen Sie nun die Devs installation in dem Sie `envs/dev/public_html` im Browser öffnen.

Rebase Master
-------------
Wenn du das erste mal das *rebasemaster* script ausführtst muss du die option *init* anhängen damit luya als upstream repo hinterlegt wird.

```sh
./scripts/rebasemaster.sh init
```

Ansonsten kannst du das rebasemaster script ohne argument asuführen
```
./scripts/rebasemaster.sh
```

> `rebasemaster.sh` wechselt in dein lokaler master branch, holt die neuen Daten vom upstream (zephir/luya) und macht ein rebase der neuen Infomrationen in deinen lokalen master.

Branch erstellen
----------------
Erstelle nun eine neun Branch anhand deines Master, das machen wir damit wir keine Konflikte und Probleme haben und Branches einfacher einen Pull Request auslösen können.

```sh
git checkout -b deinbranche master
```

> Wobei `deinbranche` dein branch name ist den du vergeben kannst. zbsp. *fixing issue #123*.


Commit, Push und Pull Request
-----------------------------
Du kannst nun deine Änderungen in deinen neu erstellen Branch *commiten* und den/die commit/s auf dein Remote (github.com/deinbenutzer/luya) *pushen* (`git push origin`).

Nun ist dein neuer Branch auf der Github Platform. Wechslen nun im Browser auf dein *LUYA* Fork innterhalb deines GitHub Profils und klicke auf den **PULL REQUEST** Knopf.

![pull-request](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/start-collaboration-pull-request.jpg "Pull request")

Informationen bezüglich Design und CSS
======================================

Admin Design Kompilierung
-------------------------

To compile the syles you have to install the following tools and plugins:

* [Compass](http://compass-style.org/install/) (gem install compass)
* [Autoprefixer-rails](autoprefixer-rails) (gem install autoprefixer-rails)

> If you have not enough rights to run the command use *sudo* to run the commands, ro change the permissions in the install directory of ruby.


If you have installed the tools successfull, you can no switch to the `resources` folder and run:

```sh
compass watch
```

or

```
compass compile
```

+ compile: will compile all styles once
+ watch: watching for changes in the file and runs compile automatic


Each module does have its own compass configratuons `config.rb`, so you have to run this process in each sub folder for the specific module.

> All LUYA admin styles are compose in the scss format and have to to be writen corresponding the [cssguidelines](http://cssguidelin.es).
