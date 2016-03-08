Seiten Crawler
==============

*(since 1.0.0-alpha13 release)*

Crawler via Composer-Require beindung hinzufügen:

```
"luyadev/luya-module-crawler" : "dev-master"
```

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
./vendor/bin/luya command crawler crawl
```

Ausgabe
-------

render view beispiel `crawler/default/index`:

```php
<h1>Suchen</h1>
<p>Sie haben nach <b><?= $query; ?></b> gesucht.</p>

<h2><?= count($results); ?> Resultate</h2>
<ul>
<? foreach($results as $item): ?>
    <li><a href="<?= $item->url; ?>"><?= $item->title; ?></a>
    
        <p style="background-color:red;"><?= $item->preview($query); ?></p>
    </li>
<? endforeach; ?>
</ul>
```


ASYNC Request
--------------

Für Async Searchs kann der Restcontroller verwendet werden, hier ein Jquery beispiel:

> Achtung die Url Composition prefix muss gegen sein für mehrsprachige Urls.

```javascript

var url = 'http://luya.io/en/crawler/rest/;

$.ajax({
	url : url 
}).done(function(response) {
	console.log(response);
});
```

Eigenschaften
------------------

Für den Crawler die Sprache setzen:

```
<html lang="<?= $composition->getKey('langShortCode'); ?>">
```

Eine Teil für den Crawler ignorieren:

```
<div>
	<!-- [CRAWL_IGNORE] -->
	<p> Ich werde ignoriert vom Crawler</p>
	<!-- [/CRAWL IGNORE] -->
</div>
```

Die gesamte Seite ingorieren:

```
<div>
	<!-- [CRAWL_FULL_IGNORE] --> 
	<p>Diese gesamte Seite wird ignoriert.</p>
</div>