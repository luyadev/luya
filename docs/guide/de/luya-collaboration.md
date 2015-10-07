Bei LUYA mithelfen
==================
Wenn du am *LUYA* Projekt mitarbeiten möchtest kannst du mit den folgenden Schritten leicht deine änderungen mitteilen.

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

Die Arbeitsumgebung muss nun auf dein Konfiguration angepasst werden. Wechsle deshalb in das *configs* Verzeichniss unter `envs/dev/configs` und kopier die Datei `server.php.dist` nach `server.php` und passe deine gewünschten Parameter an.

> Die `server.php` ist auf gitingore und kann somit beliebig angepasst werden.

Als nächstes führen wir den `composer install` befehl aus innerhalb des dev env projekt ordners `envs/dev`. Dies wird dir alle nötigen Resourcen in den Vendor ORdner kopieren und ein PSR4 binding auf deine lokalen *LUYA* Daten.

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

> `rebasemaster.sh` wechselt in dein lokaler master branch, holt die neuen daten vom upstream (zephir/luya) und macht ein rebase der neune Infomrationen in deinen lokalen master.

Branch erstellen
----------------
Erstelle nun eine neneun Branch anhand deines Master, das machen wir damit wir keine konflikte und Probleme habeb und branches einfacher einen Pull Request auslösen können.

```sh
git checkout -b deinbranche master
```

> Wobei `deinbranche` dein branch name ist den du vergeben kannst. zbsp. *fixing issue #123*.


Commit, Push und Pull Request
-----------------------------
Du kannst nun deine änderungen in deinen neu erstellen branch *commiten* und den/die commit/s auf dein Remote (github.com/deinbenutzer/luya) *pushen* (`git push origin`).

Nun ist dein neuer Branch auf der Github Platform. Wechslen nun im Browser auf dein *LUYA* fork innterhalb deines GitHub profils und klicken auf den **PULL REQUEST** Knopf.

![pull-request](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/start-collaboration-pull-request.jpg "Pull request")

Admin Design Kompilierung
-------------------------
Damit alle styles kompiliert werden, benötigen Sie folgende Programme / Plugins:

* [Compass](http://compass-style.org/install/) (gem install compass)
* [Autoprefixer-rails](autoprefixer-rails) (gem install autoprefixer-rails)

*Bei Berechtigungsfehlern kannst du die oben genannten Befehle mit "sudo" ausführen, oder die Berechtigung im Installationsverzeichniss von ruby anpassen.*

Wenn die oben genannten Befehle erfolgreich ausgeführt wurden, kannst du nun in das gewünschte Modul (Unterordner ressources/) wechseln und folgenden Befehl ausführen

```
    compass watch
```

oder

```
compass compile
```

*Der "compile" Befehl kompiliert alle styles einmalig und muss bei Änderungen erneut ausgeführt werden. Der "watch" Befehl kompiliert automatisch sobald eine Datei geändert wurde.*

*Jedes Modul hat eine eigene Compass Konfiguration (config.rb). Daher muss auch der oben genannte Befehl in jedem Modul (Unterordner ressources/) einzeln ausgeführt werden.*

Admin Design Aufteilung
-----------------------
Alle CMS relevanten Styles werden im SCSS Format erfasst. Dabei muss man sich an die Richtlinien der [cssguidelines](http://cssguidelin.es) halten.

Je nach Element werden die Styles aus anderen Modulen geladen. Aktuell unterscheidet man zwischen **admin** und **cmsadmin**.

**admin**

Liefert die styles für Navigation, CRUD, Benutzerinformationen und weiteres. Ausserdem definiert es die Erscheinung von wiederverwendeten Elementen (z.B. Formularelemente).

**cmsadmin**

Liefert alle styles für die Inhaltsverwaltung im CMS. z.B. Treeview, Seiten, Placeholders, Blöcke etc.

Step-by-Step Beschreibung Luya-Branching/Forking
------------------------------------------------
Sobald du mit deinen Veränderungen fertig bist, empfiehlt es sich als erstes mit git status eine Übersicht über alle getätigten Veränderungen zu verschaffen. Ungewollte Veränderungen kannst du mit 
```
git checkout /Pfad/zur/Datei.xyz 
```
verwerfen.

**1. Rebase**

Im Luya-Projekt-Verzeichnis, im dem Unterordner /scripts findest du ein shell-Skript das dir diesen Schritt erleichtert. Um dieses auszuführen wechselst du in der Console in das besagte Verzeichnis und führst das rebasemaster-Skript aus(./rebasemaster).

**2. Einen neuen Branch erstellen**

Um einen neuen Branch mit deinen Veränderungen zu erstellen tippe: 
```
git checkout -b dein-persoenlicher-branch-mit-veraenderungen
```
(WICHTIG: Der Branch-Namen darf keine Leerzeichen enthalten!)

**3. Änderungen hinzufügen**

Um deine Änderungen dem Stage-Verzeichnis hinzuzufügen musst du dich im Root-Verzeichnis befinden und kannst mit dem gewohnten Befehl
```
git add * oder /Pfad/zur/Datei.xyz 
```
hinzufügen.
Nun wird natürlich noch der commit erwartet um die Änderungen dem Lokalen-Repository hinzuzufügen mittels des
```
git commit -m "Meine Commit Message" 
```
Befehls.

**4. Branch verwerfen**

Hierfür verwendest du fast den selben Befehl wie bei der erstellung, lediglich ohne das -b.
```
git checkout dein-persoenlicher-branch-mit-veraenderungen
```

**5. Push!**

Natürlich musst du noch "pushen", hierfür verwendest du den Befehl: 
```
git push origin dein-persoenlicher-branch-mit-veraenderungen
```

Abschliessend begibst du dich auf dein GitHub-Profil zu dem Luya-Fork und betätigst den "Compare and pull request"-Button und bestätigst dies mittels des "Create pull-request" Buttons.
Fertig!
