Page Crawler
==============

An easy to use Full-Website page crawler to make provide search results on your page. The crawlermodule gather all informations about the sides on the configured domain and stores the index in the database. From there you can now create search querys to provide search results, there are also helper methods which provides inteligent search results by spliting the input into multiple search querys (used by default).

### Install

Add the package to your composer file

```sh
composer require luyadev/luya-module-crawler:^1.0@dev
```

or add it directly to your composer.json file:

```sh
"luyadev/luya-module-crawler" : "^1.0@dev"
```

Add the modules to your configuration (config) in the modules section:

```php
'crawler' => [
    'class' => 'luya\crawler\frontend\Module',
    'baseUrl' => 'http://luya.io',
],
'crawleradmin' => 'luya\crawler\admin\Module',
```

Where `baseUrl` is the domain you want to crawler all informations.

After setup the module in your config you have to run the migrations and import command (to setup permissions):

```sh
./vendor/bin/luya migrate
./vendor/bin/luya import
```

### Execute

To execute the command (and run the crawler proccess) use the crawler command `crawl`, you should put this command in cronjob to make sure your index is up-to-date:

```sh
./vendor/bin/luya crawler/crawl
```

> In order to provide current crawl results you should create a cronjob which crawls the page each night: `cd httpdocs/current && ./vendor/bin/luya crawler/crawl`

### Statistic Command
 
You can also get statistic Results enabling a cronjob executing each week:
 
```
./vendor/bin/luya crawler/statistic
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
var url = '<?= Url::toInternal(['crawler/rest/index']); ?>';

$.ajax({
	url : url 
}).done(function(response) {
	console.log(response);
});
```

## Crawler Settings


Set the language in your html markup

```html
<html lang="<?= Yii::$app->composition->language; ?>">
```

Partial ignore a content from the crawler:

```html
<div>
	<!-- [CRAWL_IGNORE] -->
	<p>The crawler will never see and store this information</p>
	<!-- [/CRAWL_IGNORE] -->
</div>
```

Ignore a page complet:

```html
<div>
	<!-- [CRAWL_FULL_IGNORE] --> 
	<p>The full page will be ignored by the crawler.</p>
</div>
```

Sometimes you want to group your results by a section of a page, in order to let crawler know about the group/section of your current page just use the `CRAWL_GROUP` tag:

```html
<!-- [CRAWL_GROUP]api[/CRAWL_GROUP] -->
```

Where the above example `api` could be anything you want to let the crawler know for this section. Now you can group your results by the `group` field.

If you want to make sure to always use your customized title you can use the CRAWL_TITLE tag to ensure your title for the page:

```html
<!-- [CRAWL_TITLE]My Title[/CRAWL_TITLE] -->
```