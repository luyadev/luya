<?php
/* @var $this \luya\web\View */
/* @var $model \luya\news\models\Article */
?>
<h1><?= $model->title; ?></h1>
<ol>
<?php foreach ($model->tags as $tag): ?>
<li><?php print_r($tag->toArray()); ?><?= $tag->name; ?></li>
<?php endforeach; ?>
</ol>


<?php foreach ($model->findTags() as $tag): ?>
<?= $tag->name; ?><br />
<?php endforeach; ?>