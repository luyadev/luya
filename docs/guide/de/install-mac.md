Max OSX und MAMP
================
Um *LUYA* auf einem Mac OSX mit dem Webserver *MAMP* zu installieren sind folgende Arbeitsschritte nötig.

Datenbank DSN
-------------
Bei der Datenbankverbindung in der *local.php* Konfigurations-Datei muss beim DSN den `unix_socket` gesetzt werden.
```
'dsn' => 'mysql:host=localhost;dbname=luyaweb;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
```

PHP CLI VERSION
---------------
Das Mac OSX Betriebsystem verfügt über eine sehr alte PHP Version welche vorinstalliert ist. Mit folgendem Befehl kannst du sehen ob dein MAMP die Kontroller für *cli* commands hat oder die Vorinstalliert MAC OSX Version:
```
which php
```
Falls diese Ausgabe nicht auf dein *MAMP* Verzeichnis zeigt kannst du in deinem Home-Ornder eine `.bash_profile` Datei anlegen. Hierfür gehst du zuerst in dein Home Folder:
```
cd ~
```
und erstellt eine `.bash_profile` Datei mit dem Inhalt
```
export PATH=/Applications/MAMP/bin/php/php5.6.2/bin:$PATH
```
> Wobei du die PHP Version deiner Umgebung eventuel noch anpassen musst.
Logge dich nun einmal aus und wieder ein und prüfe nun mit dem `which php` Befehl erneut welche deine PHP Version für das CLI ist.

ZSA
---
Wenn du [ZSH](https://github.com/robbyrussell/oh-my-zsh)  installiert hast füge die `export` Zeile an das Ende deiner `.zshrc` Datei hinzu (~/.zshrc).