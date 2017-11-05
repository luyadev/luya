# Page Crawler

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Build Status](https://travis-ci.org/luyadev/luya-module-crawler.svg?branch=master)](https://travis-ci.org/luyadev/luya-module-crawler)
[![Coverage Status](https://coveralls.io/repos/github/luyadev/luya-module-crawler/badge.svg?branch=master)](https://coveralls.io/github/luyadev/luya-module-crawler?branch=master)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-crawler/downloads)](https://packagist.org/packages/luyadev/luya-module-crawler)

An easy to use Full-Website page crawler to make provide search results on your page. The crawlermodule gather all informations about the sides on the configured domain and stores the index in the database. From there you can now create search querys to provide search results, there are also helper methods which provides inteligent search results by spliting the input into multiple search querys (used by default).

## Install

Add the package to your composer file

```sh
composer require luyadev/luya-module-crawler:1.0.0-RC4
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

### Running the Crawler

To execute the command (and run the crawler proccess) use the crawler command `crawl`, you should put this command in cronjob to make sure your index is up-to-date:

> Make sure your page is in utf8 mode (`<meta charset="utf-8"/>`).

```sh
./vendor/bin/luya crawler/crawl
```

> In order to provide current crawl results you should create a cronjob which crawls the page each night: `cd httpdocs/current && ./vendor/bin/luya crawler/crawl`

You can also get statistic Results enabling a cronjob executing each week:
 
```
./vendor/bin/luya crawler/statistic
```


## Create search form

Make a post request with `query` to the `crawler/default/index` route and render the view as follows:

```php
<?php
use luya\helpers\Url;
use yii\widgets\LinkPager;

/* @var $query string The lookup query encoded */
/* @var $this \luya\web\View */
/* @var $provider \yii\data\ActiveDataProvider */
?>

<form class="searchpage__searched-form" action="<?= Url::toRoute(['/crawler/default/index']); ?>" method="get">
    <input id="search" name="query" type="search" value="<?= $query ?>">
    <input type="submit" value="Search"/>
</form>

<h2><?= $provider->totalCount; ?> Results</h2>
<?php foreach($provider->models as $item): /* @var $item \luya\crawler\models\Index */ ?>
    <h3><?= $item->title; ?></h3>
    <p><?= $item->preview($query); ?></p>
    <a href="<?= $item->url; ?>"><?= $item->url; ?></a>
<?php endforeach; ?>
<?= LinkPager::widget(['pagination' => $provider->pagination]); ?>
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
