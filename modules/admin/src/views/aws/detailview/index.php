<?php
use yii\widgets\DetailView;

?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'options' => ['class' => 'striped highlight bordered responsive-table'],
]); ?>