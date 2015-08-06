Seiten Crawler
==============

*(since 1.0.0-alpha13 release)*

Um das Cralwer Module einzufügen gibts du folgende konfiguration an:

```php
'crawler' => [
    'class' => 'crawler\Module',
    'baseUrl' => 'http://luya.io',
],
'crawleradmin' => 'crawleradmin\Module',
```

wobie die `baseUrl` der URL entspricht welche deinen Such-Index aufbauen soll.

Ausführen
---------

Damit deine suche gestartet wird erstellst du am besten einen *Cron-job* der jede Nacht läuft mit dem auszuführenden COmmand:

```sh
php index.php command crawler crawl
```