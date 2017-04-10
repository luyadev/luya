# Gallery Module

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

The gallery module allows you create folders and collection and upload images to the collections. Its an easy way to create a gallery very quick and create your own view files.

## Installation

Require the modules in your composer.json

```
"luyadev/luya-module-gallery" : "^1.0@dev"
```

Now add the modules to your configuration in the modules section:

```php
'modules' => [
	// ...
	'gallery' => 'luya\gallery\frontend\Module',
	'galleryadmin' => 'luya\gallery\admin\Module',
]
```

After runing the `composer update` command you have to run the migration command in order to setup the database:

```sh
./vendor/bin/luya migrate
```

and import the module to your database:

```sh
./vendor/bin/luya import
```

You can now login to your administration area and setup the permissions in order to see the gallery module in your administration area. To integrate the module to your page you can create a page with *type* module or use the *module block*.


## View files

As the modules are not shipped with default view files you can use the following examples:

#### cat/index.php

```php
<?php foreach($catData as $item): ?>
    <div class="well">
        <h1><?php echo $item->title; ?></h1>
        <a href="<?php echo \luya\helpers\Url::toRoute(['/gallery/alben/index', 'catId' => $item->id, 'title' => \yii\helpers\Inflector::slug($item->title)]); ?>">Alben anzeigen</a>
    </div>
<?php endforeach; ?>
```

#### alben/index.php

```php
<table border="1">
<?php foreach($albenData as $item): ?>
<tr>
    <td><img src="<?php echo Yii::$app->storage->getImage($item->cover_image_id)->applyFilter('medium-thumbnail'); ?>" border="0" /></td>
    <td>
        <pre>
            <?php print_r($item->toArray()); ?>
        </pre>
        <h2><?php echo $item->title; ?></h2>
        <p><?php echo $item->description; ?></p>
        <p><a href="<?php echo $item->getDetailUrl(); ?>"><?php echo $item->getDetailUrl(); ?></a>
    </td>
</tr>
<?php endforeach; ?>
</table>
```

#### album/index.php

```php
<div class="well">
<table border="1">
<tr>
    <td><img src="<?php echo Yii::$app->storage->getImage($item->cover_image_id)->applyFilter('medium-thumbnail'); ?>" border="0" /></td>
    <td>
        <h2><?php echo $model->title; ?></h2>
        <p><?php echo $model->description; ?></p>
        <p><a href="<?php echo $model->getDetailUrl(); ?>"><?php echo $model->getDetailUrl(); ?></a>
        
        <h3>Bilder</h3>
        <div class="row">
            <?php foreach($model->images() as $image): ?>
                <div class="col-md-3">
                    <img class="img-responsive" src="<?php echo Yii::$app->storage->getImage($item->cover_image_id)->applyFilter('medium-thumbnail'); ?>" border="0" />
                </div>
            <?php endforeach; ?>
        </div>
        
    </td>
</tr>
</table>
</div>
```