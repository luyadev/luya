<?php
use luya\admin\filters\MediumThumbnail;

/**
 * @var $this \luya\cms\base\PhpBlockView
*/
?>
<?php if ($album = $this->extraValue('album')): ?>
<h1><?= $album->title; ?></h1>
<p><?= $album->description; ?></p>
    <?php if ($album->cover_image_id): ?>
    <p>
        <a href="<?= $album->getDetailUrl($this->cfgValue('nav_item_id')); ?>">
            <img class="img-responsive img-rounded" src="<?= Yii::$app->storage->getImage($album->cover_image_id)->applyFilter(MediumThumbnail::identifier())->httpSource; ?>" border="0" />
        </a>
    <?php endif; ?>
<?php endif; ?>