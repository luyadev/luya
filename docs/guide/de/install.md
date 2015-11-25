Luya installieren
=================

> Bei Problemen mit `composer update`, aktualisiere Dein `fxp/composer-asset-plugin` auf die Version **1.1.0** mit dem Befehl: `composer global require "fxp/composer-asset-plugin:~1.1.1"`.

Mit diesen wenigen Schritten kannst Du ganz einfach ein eigenes Luya-Projekt erstellen. Um Luya installieren zu können, musst du [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) auf deinem Mac-, Linux- oder Windows- Computer installiert haben. Natürlich musst Du über eine Webserver-Umgebung mit [PHP](http://php.net) (ab Version 5.4) verfügen (zbsp. [MAMP](https://www.mamp.info/de/) oder [XAMPP](https://www.apachefriends.org/index.html)).

Composer
--------
Als erstes registrieren wir das `fxp/composer-asset-plugin` global für deine gesamte Arbeitsumgebung. Luya benötigt dies um [BOWER](http://bower.io) Pakete (zbsp. Jquery, Angular, etc.) in deinem Vendor Ordner zu speichern.

```sh
composer global require "fxp/composer-asset-plugin:~1.1.1"
```

Als nächstes erstellen wir ein `Kickstarter` Projekte mit Hilfe des `composer create-project` Befehls. Dafür musst du lediglich dein *Terminal* öffnen und den folgenden Befehl eingeben:

```sh
composer create-project zephir/luya-kickstarter:1.0.0-beta1
```

> Die installation und all ihrere abhängigkeiten welche noch nicht im cache sind kann durchaus mehrere Minuten dauern.

> Die Frage `Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]?` Kannst du mit Ja `Y` beantworten da du das kickstarter repo nicht für dein Luya Projekt bruachst.

Dies wird dir ein Verzeichniss **luya-kickstarter** erstellen.


Konfiguration
-------------
Als nächsten werden wir die Konfigurations-Dateien für dein Luya Projekt erstellen. Dazu gehst du in deinen `luya-kickstarter/configs` Ordner wo, du die *.dist* Datei siehst.
Du kannst nun die *.dist* Dateien umbennen und dabei die *.dist* Endung entfernen.

> Achtung: Du solltest die dist Datein nach wie vor im Ordner belassen. So können auch andere Leute mit denen du zusammen arbeitest schnell die Konfigurations Dateien erstellen.

Im Terminal kannst du die *dist* Datein wie folgt kopieren:

```sh
cp server.php.dist server.php
cp local.php.dist local.php
```

Jede Konfigurationsdatei hat eine Funktion:

|Name          |Beschreibung
|--------      |-------------
|server.php    |Diese Datei ist auf .gitignore und inkludiert die aktuelle laufende Umgebung (prep, prod)
|prep.php      |Steht für *Preproduction*, also dein Lokales System
|prod.php      |Dies ist die Konfiguration auf dem Server (*Production*) auf dem das System produktiv läuft.
|local.php     |Dies sind deine Einstellungen von deiner Entwicklungsmaschine enthalten, welche mit der *prep.php* gemerged werden.


Datenbank
----------

Du kannst nun in der *local.php* (welche du aus dem dist file kopiert hast) deine Datenbank Verbindung festlegen. Luya verfügt über eine *bin* Datei welche im Verzeichniss `vendor/bin/` liegt. Auf diese Bind Datei kannst du alle [Konsolen Befehl](luya-console.md) ausführen. So auch der Migration command.


> Wichtig die Datenbank muss vor dem migrate erstellt sein und Mac-User sollten noch den [UNIX-Socket sowie den Datenbanknamen](install-mac.md) setzen.  

Nun führen wir den Migration befehl aus:

```sh
./vendor/bin/luya migrate
```

Du musst nun allen Migrationsdaten zustimmen, diese werden ausgeführt und deine Datenbank ist startklar.

Import
------
Nun importieren wir alle Projekt Daten in die Datenbank mit dem `import` Befehl:

```sh
./vendor/bin/luya import
```

Setup
-----
Nun können wir einmalig den Setup Befehl ausführen welcher Benutzer und Gruppen erstellt.

```sh
./vendor/bin/luya setup
```

Health Check
------------
Um Ordner und Datein und dere Zustand zu prüfen führen wir nun noch den `health` Command aus:

```sh
./vendor/bin/luya health
```

Nach dem Eingeben deiner Daten kannst du nun die Administration im Browser öffnen. Wenn du das Projekt in deinem `htdocs` Hauptverzeichniss erstellt hast könnte die Adresse zum Beispiel so ausehen:

```
http://localhost/luya-kickstarter/admin
```

Wenn du dich eingeloggt hast, kannst nun der *Administrator* Gruppe alle *Berechtigungen* erteilen.

PHP Einstellungen
-----------------

Bitte beachte, ob du in deiner PHP-Konfiguration **short_open_tags** aktiviert ist ( `<?` anstelle von `<?php` ), da diese in den *Views* verwendet werden.

|Konfiguration |Wert
|--- |----
|short_open_tags | 1
|memory_limit |512
|max_execution_time|60
|post_max_size|16M
|upload_max_filesize|16M
