<?php
use yii\widgets\DetailView;
use yii\base\Widget;

?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'options' => ['class' => 'striped highlight bordered responsive-table'],
]); ?>