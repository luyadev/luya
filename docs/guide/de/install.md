Luya installieren
=================

> Bei Problemen mit `composer update`, aktualisiere dein `fxp/composer-asset-plugin` auf die Version **1.0.3** mit dem Befehl: `composer global require "fxp/composer-asset-plugin:1.0.3"`.

Mit diesen wenigen Schritten kannst du ganz einfach ein eigenes Luya Projekt erstellen. Um Luya installieren zu können, musst du [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) auf deinem Mac, Linux oder Windows Computer installiert haben. Natürlich musst du über eine Webserver-Umgebung mit [PHP](http://php.net) (ab 5.4) verfügen (zbsp. [MAMP](https://www.mamp.info/de/) oder [XAMPP](https://www.apachefriends.org/index.html)).

Composer
--------
Als erstes registrieren wir das `fxp/composer-asset-plugin` global für deine gesamte Arbeitsumgebung. Luya benötigt dies um [BOWER](http://bower.io) Pakete (zbsp. Jquery, Angular, etc.) in deinem Vendor Ordner zu speichern.

```sh
composer global require "fxp/composer-asset-plugin:~1.0.3"
```

Als nächstes erstellen wir ein `Kickstarter` Projekte mit Hilfe des `composer create-project` Befehls. Dafür musst du lediglich dein *Terminal* öffnen und den folgenden Befehl eingeben:

```sh
composer create-project zephir/luya-kickstarter:dev-master 
```

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
cp prep.php.dist prep.php
cp local.php.dist local.php
```

Jede Konfigurationsdatei hat eine Funktion:

|Name          |Beschreibung
|--------      |-------------
|server.php    |Diese Datei ist auf .gitignore und inkludiert die aktuelle laufende Umgebung (prep, prod)
|prep.php      |Steht für *Preproduction*, also dein Lokales System
|prod.php      |Dies ist die Konfiguration auf dem Server auf dem das System produktiv läuft.
|local.php     |Dies sind deine Einstellungen von deiner Entwicklungsmaschine enthalten, welche mit der *prep.php* gemerged werden.


Datenbank
----------
Du kannst nun in der *local.php* (welche du aus dem dist file kopiert hast) deine Datenbank Verbindung hinterlegen. Danach gehen wir wieder in das *Terminal* und begeben uns in das `public_html` Verzeichniss.

```sh
cd luya-kickstarter/public_html
```

Dort führen wir auf der index.php der Migrations Befehl aus:

```sh
php index.php migrate
```

Du musst nun allen Migrationsdaten zustimmen, diese werden ausgeführt un deine Datenbank ist startklar.

Setup
-----
Als nächstes führen wir den Setup-Befehl aus welcher einen Benutzer und Gruppe erstellt. Dazu gehen wir wieder ins Terminal:

```
php index.php setup
```

Nach dem Eingeben deiner Daten kannst du nun die Administration im Browser öffnen. Wenn du das Projekt in deinem `htdocs` Hauptverzeichniss erstellt hast könnte die Adresse zum Beispiel so aussehen `http://localhost/luya-kickstarter/admin`.

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