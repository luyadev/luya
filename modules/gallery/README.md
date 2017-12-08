<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# Gallery Module

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-module-gallery/v/stable)](https://packagist.org/packages/luyadev/luya-module-gallery)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-gallery/downloads)](https://packagist.org/packages/luyadev/luya-module-gallery)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

The gallery module allows you create folders and collection and upload images to the collections. Its an easy way to create a gallery very quick and create your own view files.

## Installation

For the installation of modules Composer is required.

```sh
composer require luyadev/luya-module-gallery:1.0.0-RC4
```


### Configuration

After installation via Composer include the module to your configuration file within the modules section.

```php
'modules' => [
    // ...
    'gallery' => 'luya\gallery\frontend\Module',
    'galleryadmin' => 'luya\gallery\admin\Module',
]
```
### Initialization 

After successfully installation and configuration run the migrate, import and setup command to initialize the module in your project.

1.) Migrate your database.

```sh
./vendor/bin/luya migrate
```

2.) Import the module and migrations into your LUYA project.

```sh
./vendor/bin/luya import
```

## View files

As the modules are not shipped with default view files you can use the following examples:

#### cat/index.php

```php
<?php foreach($catData as $item): ?>
    <div class="well">
        <h1><?= $item->title; ?></h1>
        <a href="<?= $item->detailLink; ?>">Alben anzeigen</a>
    </div>
<?php endforeach; ?>
```

#### alben/index.php

```php
<table border="1">
<?php foreach($albenData as $item): ?>
<tr>
    <td><img src="<?= Yii::$app->storage->getImage($item->cover_image_id)->applyFilter('medium-thumbnail'); ?>" border="0" /></td>
    <td>
        <h2><?= $item->title; ?></h2>
        <p><?= $item->description; ?></p>
        <p><?= $item->detailLink; ?></p>
    </td>
</tr>
<?php endforeach; ?>
</table>
```

#### album/index.php

```php
<table border="1">
<tr>
    <td>
        <h2><?= $model->title; ?></h2>
        <p><?= $model->description; ?></p>
        <p><a href="<?= $model->detailLink; ?>"><?= $model->detailLink; ?></a>
        
        <h3>Bilder</h3>
        <div class="row">
            <?php foreach($model->albumImages as $image): ?>
                <div class="col-md-3">
                    <img class="img-responsive" src="<?= $image->source; ?>" border="0" />
                </div>
            <?php endforeach; ?>
        </div>
    </td>
</tr>
</table>
```
