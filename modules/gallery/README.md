cat/index.php
=============
```
<?php foreach($catData as $item): ?>
    <div class="well">
        <h1><?php echo $item->title; ?></h1>
        <a href="<?php echo \luya\helpers\Url::toManager('gallery/alben/index', ['catId' => $item->id, 'title' => \yii\helpers\Inflector::slug($item->title)]); ?>">Alben anzeigen</a>
    </div>
<?php endforeach; ?>
```

alben/index.php
===============
```
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

album/index.php
===============
```
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