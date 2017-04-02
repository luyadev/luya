<div class="row">
    <div class="col-md-12">
        <a href="<?= $model->getCategoryUrl()?>"><i class="fa fa-fw fa-chevron-left"></i> Zurück zur Kategorie "<?= $model->getCategoryName() ?>"</a>
        <br />
        <br />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <img class="responsive-img" src="<?= Yii::$app->storage->getImage($model->cover_image_id)->applyFilter('gallery-image-thumbnail')->source; ?>" />
        <br />
        <br />
    </div>

    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <h1><?= $model->title; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $model->description; ?>
            </div>
        </div>
    </div>
</div>

<div class="image-grid">
    <div class="row">
        <?php foreach ($model->images() as $image): ?>
            <div class="col-md-3">
                <a class="image-grid__image swipebox" href="<?= Yii::$app->storage->getImage($image['image_id'])->applyFilter('lightbox')->source; ?>" rel="gallery">
                    <img src="<?= Yii::$app->storage->getImage($image['image_id'])->applyFilter('medium-crop')->source; ?>" />
                    <div class="image-grid__overlay">
                        <i class="image-grid__icon [ fa fa-fw fa-expand ]"></i>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>