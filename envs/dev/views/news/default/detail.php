<?php
/* @var $this \luya\web\View */
/* @var $model \luya\news\models\Article */
?>
<h1><?= $model->title; ?></h1>
<ol>
<? foreach ($model->tags as $tag): ?>
<li><? print_r($tag->toArray()); ?><?= $tag->name; ?></li>
<? endforeach; ?>
</ol>


<? foreach ($model->findTags() as $tag): ?>
<?= $tag->name; ?><br />
<? endforeach; ?>