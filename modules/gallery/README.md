cat/index.php
=============
```
<? foreach($catData as $item): ?>
    <div class="well">
        <h1><?= $item->title; ?></h1>
        <a href="<?= \luya\helpers\Url::toManager('gallery/alben/index', ['catId' => $item->id, 'title' => \yii\helpers\Inflector::slug($item->title)]); ?>">Alben anzeigen</a>
    </div>
<? endforeach; ?>
```

alben/index.php
===============
```
<table border="1">
<? foreach($albenData as $item): ?>
<tr>
    <td><img src="<?= Yii::$app->storagecontainer->getImage($item->cover_image_id)->applyFilter('medium-thumbnail'); ?>" border="0" /></td>
    <td>
        <pre>
            <? print_r($item->toArray()); ?>
        </pre>
        <h2><?= $item->title; ?></h2>
        <p><?= $item->description; ?></p>
        <p><a href="<?= $item->getDetailUrl(); ?>"><?= $item->getDetailUrl(); ?></a>
    </td>
</tr>
<? endforeach; ?>
</table>
```

album/index.php
===============
```
<div class="well">
<table border="1">
<tr>
    <td><img src="<?= Yii::$app->storagecontainer->getImage($item->cover_image_id)->applyFilter('medium-thumbnail'); ?>" border="0" /></td>
    <td>
        <h2><?= $model->title; ?></h2>
        <p><?= $model->description; ?></p>
        <p><a href="<?= $model->getDetailUrl(); ?>"><?= $model->getDetailUrl(); ?></a>
        
        <h3>Bilder</h3>
        <div class="row">
            <? foreach($model->images() as $image): ?>
                <div class="col-md-3">
                    <img class="img-responsive" src="<?= Yii::$app->storagecontainer->getImage($item->cover_image_id)->applyFilter('medium-thumbnail'); ?>" border="0" />
                </div>
            <? endforeach; ?>
        </div>
        
    </td>
</tr>
</table>
</div>
```