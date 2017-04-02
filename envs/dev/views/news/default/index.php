<?php
use yii\widgets\LinkPager;

/* @var $this \luya\web\View */
/* @var $provider \yii\data\ActiveDataProvider */
?>
<h2>News Overview</h2>
<?php foreach ($provider->models as $item): ?>
    <?php /* @var $item \luya\news\models\Article */ ?>
    <pre>
        <?php print_r($item->toArray()); ?>
    </pre>
    <p>
        <a href="<?= $item->detailUrl; ?>">News Detail Link</a>
    </p>
<?php endforeach; ?>

<?= LinkPager::widget(['pagination' => $provider->pagination]); ?>