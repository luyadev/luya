Bei LUYA mithelfen
==================
Wenn du am *LUYA* Projekt mitarbeiten möchtest kannst du mit den folgenden Schritten leicht deine Änderungen mitteilen.

1. Forke das [luyadev/luya](https://github.com/luyadev/luya) Projekte in deinen Account.
2. Erstelle deine Arbeitsumgebung mit `envs/dev`.
4. Rebase deinen Master
5. Erstelle einen Branch
6. Commit, Push und Pull-Request

Forken
------
Um unser *LUYA* repository zu forken klicken gehen Sie auf [luyadev/luya](https://github.com/luyadev/luya) und danach auf den **FORK** Knopf. Dies wird eine Kopie der aktuellen Daten von Luya in dein eigenes Github Profil erstellen welches du danach auf deinem Computer via `git clone https://github.com/deinuser/luya` auschecken kannst. 

![fork-luya](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide1.0/img/start-collaboration-fork.jpg "Fork Luya")

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

> `rebasemaster.sh` wechselt in dein lokaler master branch, holt die neuen Daten vom upstream (luyadev/luya) und macht ein rebase der neuen Infomrationen in deinen lokalen master.

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

![pull-request](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide1.0/img/start-collaboration-pull-request.jpg "Pull request")

Informationen bezüglich Design und CSS
======================================

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
