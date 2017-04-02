<div class="row">
    <div class="col-md-12">
        <a href="<?= $this->url('gallery/cat/index');?>"><i class="fa fa-fw fa-chevron-left"></i> Kategorieübersicht</a>
        <br />
        <br />
    </div>
</div>
<?php if (count($albenData) == 0): ?>
<div class="alert alert-info">Es wurden noch keine Bilder zu dieser Kategorie hinterlegt.</div>
<?php else: ?>
<div class="albums">
    <div class="row">
        <?php foreach ($albenData as $item): ?>
            <div class="album col-xs-12 col-sm-6 col-md-4">
                <a class="album__link" href="<?= $item->getDetailUrl(); ?>">
                    <img class="album__image" src="<?= Yii::$app->storage->getImage($item->cover_image_id)->source; ?>" />
                    <div class="album__overlay">
                        <div class="album__text">
                            <i class="album__icon fa fa-fw fa-camera-retro"></i> <br />
                            <?= $item->description; ?>
                        </div>
                    </div>
                </a>
                <div class="album__title"><h2 class="text-center"><?= $item->title; ?></h2></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>