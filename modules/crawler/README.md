Page Crawler
==============

An easy to use page crawler to make an internal search field on your page. The crawlermodule gather all informations about the sides on the configured domain.

### Install

Add to composer json:

```
"luyadev/luya-module-crawler" : "1.0.0-beta5"
```

Add the module to your configuration

```php
'crawler' => [
    'class' => 'crawler\Module',
    'baseUrl' => 'http://luya.io',
],
'crawleradmin' => 'crawleradmin\Module',
```

Where `baseUrl` is the domain you want to crawler all informations.

After setup the module in your config you have to run the migrations:

```sh
./vendor/bin/luya migrate`
```

### Execute

To execute the command (and run the crawler proccess) use the crawler command `crawl`, you should put this command in cronjob to make sure your index is up-to-date:

```sh
./vendor/bin/luya crawler crawl
```

Create search form
------------------

Make a post request with `query` to the `crawler/default/index` route and render the view as follows

```php
<h1>Search</h1>
<p>You where looking for <b><?= $query; ?></b>.</p>

<h2><?= count($results); ?> results</h2>
<ul>
<? foreach($results as $item): ?>
    <li>
    	<a href="<?= $item->url; ?>"><?= $item->title; ?></a>
        <p style="background-color:red;"><?= $item->preview($query); ?></p>
    </li>
<? endforeach; ?>
</ul>
```


### ASYNC Request

To make async search queries use the restcontroller route (jquery example):


```php

var url = '<?= Url::toInternal(['crawler/rest/index']);?>;

$.ajax({
	url : url 
}).done(function(response) {
	console.log(response);
});
```

Crawler Settings
------------------

Set the language in your html markup

```
<html lang="<?= $composition->getKey('langShortCode'); ?>">
```

Partial ignore a content from the crawler:

```
<div>
	<!-- [CRAWL_IGNORE] -->
	<p>The crawler will never see and store this information</p>
	<!-- [/CRAWL IGNORE] -->
</div>
```

Ignore a page complet:

```
<div>
	<!-- [CRAWL_FULL_IGNORE] --> 
	<p>Diese gesamte Seite wird ignoriert.</p>
</div>
