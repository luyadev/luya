<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
*/
?>
<ul>
<?php foreach ($this->extraValue('items', []) as $item): ?>
    <li><a href="<?= $item->getDetailUrl($this->cfgValue('nav_item_id')); ?>"><?= $item->title; ?></a></li>
<?php endforeach; ?>
</ul>