<?php foreach ($catData as $item): ?>

    <div class="row" style="margin-bottom:40px;">
        <div class="col-md-4">
            <a href="<?= $this->url('gallery/alben/index', ['catId' => $item->id, 'title' => \yii\helpers\Inflector::slug($item->title)]); ?>">
                <img class="img-responsive img-rounded" src="<?= Yii::$app->storage->getImage($item->cover_image_id)->source; ?>" />
            </a>
        </div>

        <div class="col-md-8">
            <h1><?= $item->title; ?></h1>
            <p><?= $item->description; ?></p>
            <a class="btn btn-default" href="<?= $this->url('gallery/alben/index', ['catId' => $item->id, 'title' => \yii\helpers\Inflector::slug($item->title)]); ?>">Alben anzeigen</a>
        </div>
    </div>

<?php endforeach; ?>