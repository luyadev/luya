<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>
<?php if (!empty($this->varValue('elements'))): ?>
<<?= $this->extraValue('listType', 'ul'); ?>>
    <?php foreach ($this->varValue('elements') as $item): ?>
    <li><?= $item['value']; ?></li>
    <?php endforeach; ?>
</<?= $this->extraValue('listType', 'ul'); ?>>
<?php endif; ?>