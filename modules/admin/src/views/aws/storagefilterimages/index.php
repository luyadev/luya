<?php
use luya\admin\ngrest\aw\CallbackButtonWidget;

/* @var $model \luya\admin\models\StorageFilter */
?>

<div class="card text-white bg-secondary mb-3" style="max-width: 20rem;">
    <div class="card-header">Filter: <?= $model->name; ?></div>
    <div class="card-body">
        <p>Identifier: <?= $model->identifier; ?></p>

        <?= CallbackButtonWidget::widget(['label' => '<i class="material-icons">clear</i><span>Remove generated Images</span>', 'callback' => 'remove', 'options' => ['class' => 'btn btn-delete']]); ?>
    </div>
</div>

<?php if (count($images) == 0): ?>
    <div class="alert alert--info">No images has been generated for this filter yet.</div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th style="width: 200px;">Image</th>
            <th>Path</th>
            <th>Caption</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($images as $image): /* @var $image \luya\admin\image\Item */?>
            <tr>
                <th>
                    <img style="max-width: 200px;" src="<?= $image->source; ?>" alt="" class="responsive-img">
                </th>
                <td><a target="_blank" href="<?= $image->source; ?>"><?= $image->source; ?></a></td>
                <td><?= $image->caption; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>