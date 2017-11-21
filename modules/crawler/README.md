# Page Crawler

<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/internals/images/luya_logo_rc4.png" alt="LUYA Logo"/>
</p>

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Build Status](https://travis-ci.org/luyadev/luya-module-crawler.svg?branch=master)](https://travis-ci.org/luyadev/luya-module-crawler)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-module-crawler/v/stable)](https://packagist.org/packages/luyadev/luya-module-crawler)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-crawler/downloads)](https://packagist.org/packages/luyadev/luya-module-crawler)
[![Slack Support](https://github.com/luyadev/luya/tree/master/docs/guide/img/icons/Slack_Mark_Monochrome_Black.svg)](https://luyadev.slack.com/)

An easy to use full-website page crawler to make provide search results on your page. The crawler module gather all information about the sites on the configured domain and stores the index in the database. From there you can now create search queries to provide search results. There are also helper methods which provide intelligent search results by splitting the input into multiple search queries (used by default).

## Installation

For the installation of modules Composer is required.

### Composer

```sh
composer require luyadev/luya-module-crawler:1.0.0-RC4
```

### Configuration

After installation via Composer include the module to your configuration file within the modules section.

```php
'crawler' => [
    'class' => 'luya\crawler\frontend\Module',
    'baseUrl' => 'http://luya.io',
],
'crawleradmin' => 'luya\crawler\admin\Module',
```

Where `baseUrl` is the domain you want to crawler all information.

### Initialization
After setup the module in your config you have to run the migrations and import command (to setup permissions):

```sh
./vendor/bin/luya migrate
./vendor/bin/luya import
```

## Running the Crawler

To execute the command (and run the crawler proccess) use the crawler command `crawl`, you should put this command in cronjob to make sure your index is up-to-date:

> Make sure your page is in utf8 mode (`<meta charset="utf-8"/>`).

```sh
./vendor/bin/luya crawler/crawl
```

> In order to provide current crawl results you should create a cronjob which crawls the page each night: `cd httpdocs/current && ./vendor/bin/luya crawler/crawl`

You can also get statistic results enabling a cronjob executing each week:
 
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

To make async search queries use the rest controller route (jquery example):


```php
var url = '<?= Url::toInternal(['crawler/rest/index']); ?>';

$.ajax({
    url : url 
}).done(function(response) {
    console.log(response);
});
```

## Crawler Settings

Set the language in your html markup.

```html
<html lang="<?= Yii::$app->composition->language; ?>">
```

Partially ignore a content from the crawler:

```html
<div>
    <!-- [CRAWL_IGNORE] -->
    <p>The crawler will never see and store this information</p>
    <!-- [/CRAWL_IGNORE] -->
</div>
```

Ignore a page complete:

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
