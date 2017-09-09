# LUYA News Module

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

The news module will provided you a basic news system with categories and tags.

## Installation

In order to install the news module you have to require the `luyadev/luya-module-news`. To add the modules to your composer run:

```sh
composer require luyadev/luya-module-news:1.0.0-RC4
```

This will add the packages to your composer.json and run the update command. So now you have the modules in your vendor folder. Now you have the configure them in your configration (the `configs` folder) file:

```php
'modules' => [
    // ...
    'news' => 'luya\news\frontend\Module',
    'newsadmin' => 'luya\news\admin\Module',
]
```

The modules are now available in your project. Now you have to run the migration and import command and you will be able to access the news administration to add news articles.

migration command:

```sh
./vendor/bin/luya migrate
```

and import command:

```sh
./vendor/bin/luya import
```

After adding the persmissions to your group you will be able to edit and add new news articles.

## Example Views

As the module will try to render a view for the news overview, here is what this could look like this in a very basic way:

#### views/news/default/index.php

```php
<?php
use yii\widgets\LinkPager;

/* @var $this \luya\web\View */
/* @var $provider \yii\data\ActiveDataProvider */
?>
<h2>Latest News Articles</h2>
<?php foreach($provider->models as $item): ?>
    <?php /* @var $item \luya\news\models\Article */ ?>
    <pre>
        <?php print_r($item->toArray()); ?>
    </pre>
    <p>
        <a href="<?= $item->detailUrl; ?>">News Detail Link</a>
    </p>
<?php endforeach; ?>

<?= LinkPager::widget(['pagination' => $provider->pagination]); ?>
```

#### views/news/default/detail.php

```php
<?php
/* @var $this \luya\web\View */
/* @var $model \luya\news\models\Article */
?>
<h1><?= $model->title; ?></h1>
<pre>
<?php print_r($model->toArray()); ?>
</pre>
```

The above examples will just dump all the data from the model active records.