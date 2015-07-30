Dein Luya Projekt
=================

> Bei Problemen mit `composer update` aktualisiere dein `fxp/composer-asset-plugin` auf die Version **1.0.1**. `composer global require "fxp/composer-asset-plugin:1.0.1"`

Mit diesen wenigen Schritten kannst du ganz einfach ein eigenes Luya Projekt erstellen. Um Luya installieren zu können, musst du `composer` auf deinem Mac, Linux oder Unix Computer installiert haben.

```sh
composer global require "fxp/composer-asset-plugin:~1.0.1"
```

Bitte beachte, ob du in deiner PHP-Konfiguration **short_open_tags** aktiviert hast ( `<?` statt `<?php` ), da diese in den *Views* verwendet werden.

Als nächstes erstellen wir ein `Kickstarter` Projekte mit Hilfe des `composer create-project` Befehls. Dafür musst du lediglich dein *Terminal* öffnen und den folgenden Befehl eingeben:

```sh
composer create-project zephir/luya-kickstarter:dev-master 
```

Dies wird dir ein Verzeichniss **luya-kickstarter** erstellen.


Konfiguration
-------------
Als nächsten werden wir die Konfigurations-Dateien für dein Luya Projekt erstellen. Dazu gehst du in deinen `luya-kickstarter/configs` Ordner wo, du die *.dist* Datei siehst.
Du kannst nun die *.dist* Dateien umbennen und dabei die *.dist* Endung entfernen.

> Achtung: Du solltest die dist Datein nach wie vor im Ordner belassen. So können auch andere Leute mit denen du zusammen arbeitest schnell die Konfigurations Dateien erstellen.

Im Terminal könntest du so die Daten kopieren:
```
cp server.php.dist server.php
cp prep.php.dist prep.php
cp local.php.dist local.php
```

Jede Konfiguration hat Ihren Zweck:

| Name          | Beschreibung
| --------      | -------------
| server.php    | Diese Datei ist auf .gitignore und inkludiert die aktuelle laufende Umgebung (prep, prod)
| prep.php      | Steht für *Preproduction*, also dein Lokales System
| prod.php      | Dies ist die Konfiguration auf dem Server auf dem das System produktiv läuft.
| local.php     | Dies sind deine Einstellungen von deiner Entwicklungsmaschine, welche mit der *prep.php* gemerged werden.

Datenbank
----------
Du kannst nun in der *local.php* (welche du aus dem dist file kopiert hast) deine Datenbank Verbindung hinterlegen. Danach gehen wir wieder in das *Terminal* und begeben uns in das `public_html` Verzeichniss.
```
cd luya-kickstarter/public_html
```
Dort führen wir auf der index.php der Migrations Befehl aus:
```
php index.php migrate
```
Du musst nun allen Migrationsdaten zustimmen, diese werden ausgeführt un deine Datenbank ist startklar.

Setup
-----
Als nächstes führen wir den Setup-Befehl aus welcher einen Benutzer und Gruppe erstellt. Dazu gehen wir wieder ins Terminal:
```
php index.php exec/setup
```
Nach dem Eingeben deiner Daten kannst du nun die Administration im Browser öffnen. Wenn du das Projekt in deinem `htdocs` Hauptverzeichniss erstellt hast könnte die Adresse zum Beispiel so aussehen `http://localhost/luya-kickstarter/admin`.

Wenn du dich eingeloggt hast, kannst nun der *Administrator* Gruppe alle *Berechtigungen* erteilen.

Viel Spass!
