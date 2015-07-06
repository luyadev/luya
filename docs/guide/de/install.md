Dein Luya Projekt
=================
Mit diesen wenigen Schritten kannst du ganz einfach ein eigenes Luya Projekt erstellen. Um Luya zu installiert musst du `composer` auf deinem Mac, Linux oder Unix Compuer installiert haben.

Damit wir bower Datein installieren können musst du als erstes das `composer-asset-plugin` global registrieren:
```
composer global require "fxp/composer-asset-plugin:~1.0"
```

Als nächstes erstellen wir ein `kickstater` Projekte mit hilfe des `composer create-project` befehls. Dafür musst du lediglich dein *Terminal* öffnen und den folgenden befehl eingeben:
```
composer create-project zephir/luya-kickstarter:dev-master 
```
dies wird dir ein Verzeichniss **luya-kickstarter** erstellen.


Konfiguration
-------------
Als nächsten werden wir die Konfigurations Dateien für dein Luya Projekt erstellen. Dazu gehst du in deinen `luya-kickstarter/configs` Ordner wo du due *.dist* Datei siehst.
Du kannst nun diese *.dist* Dateien umbennen und die *.dist* Endung entfernen.

> Achtung: Du solltest die dist Datein nach wie vor im Ordner belassen. So können auch andere Leute mit denen du zusammenarbeitetst schnell die Konfigurations Dateien erstellen.

Im Terminal könntest du so die Daten kopieren:
```
cp server.php.dist server.php
cp prep.php.dist prep.php
cp local.php.dist local.php
```

Jede Konfiguration hat Ihren Zweck:

| Name          | Beschreibung
| --------      | -------------
| server.php    | Diese Datei ist auf .gitignore und includiert die aktuelle laufende Umgebung (prep, prod)
| prep.php      | Steht für *Preproduction*, also dein Lokales System
| prod.php      | Dies ist die Konfiguration auf dem Server wo das System Produktiv läuft.
| local.php     | Dies sind deine Einstellungen von deiner Entwicklungsmaschine, welche mit der *prep.php* gmerged werden.

Datenbank
----------
Du kannst nun in der *local.php* (welche du aus dem dist file kopiert hast) deine Datenbank Verbindung hinterlegen. Danach gehen wir wieder in das *Terminal* und begeben uns in das `public_html` Verzeichniss.
```
cd luya-kickstarter/public_html
```
Dort führen wir auf der index.php der Migrations Befehl aus:
```
php index.php presql
```
Du musst nun allen Migrationsdaten zustimmen, diese werden ausgeführt un deine Datenbank ist startklar.

Setup
-----
Als nächstes führen wir den Setup-Befehl aus welcher einen Benutzer und Gruppe erstellt. Dazu gehen wir wieder ins Terminal:
```
php index.php exec/setup
```
Nach dem eingeben deiner Daten kannst du nun die Administration im Browser öffnen. Wenn du das Projekt in deinem `htdocs` Hauptverzeichniss erstellt hast könnte die Adresse zum Beispiel so aussehen `http://localhost/luya-kickstarter/admin`.

Wenn du dich eingeloggt hast kannst nun der *Administrator* Gruppe alle *Berechtigungen* erteilen.

Viel Spass!