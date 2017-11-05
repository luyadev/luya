<?php
use yii\widgets\DetailView;

?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'options' => ['class' => 'table table-bordered table-striped table-responsive'],
]); ?>