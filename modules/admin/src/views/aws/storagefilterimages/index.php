<?php
use luya\admin\ngrest\aw\CallbackButtonWidget;
use yii\base\Widget;

/* @var $model \luya\admin\models\StorageFilter */
?>
<h1><?= $model->name; ?></h1>
<p>Identifier: <?= $model->identifier; ?></p>
<?= CallbackButtonWidget::widget(['label' => 'Remove all generated Filter Images', 'callback' => 'remove']); ?>

<?php if (count($images) == 0): ?>
<div class="alert alert--info">No images has been generated for this filter yet.</div>
<?php endif; ?>
<div class="row">
<?php foreach ($images as $image): /* @var $image \luya\admin\image\Item */?>
    <div class="col s3">
        <div class="card-panel grey lighten-5 z-depth-1">
          <div class="row valign-wrapper">
            <div class="col s2">
              <img src="<?= $image->source; ?>" alt="" class="responsive-img">
            </div>
            <div class="col s10">
              <span class="black-text">
                <small><a target="_blank" href="<?= $image->source; ?>"><?= $image->source; ?></a><br /></small>
                Caption: <?= $image->caption; ?>
              </span>
            </div>
          </div>
        </div>
    </div>
<?php endforeach; ?>
</div>