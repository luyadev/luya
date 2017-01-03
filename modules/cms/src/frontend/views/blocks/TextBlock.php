<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
*/
?>
<?php if ($this->varValue('textType') == 0): ?>
<p<?= $this->cfgValue('cssClass', null, ' class="{{cssClass}}"'); ?>><?= $this->extraValue('text'); ?></p>
<?php else: ?>
<?= $this->extraValue('text'); ?>
<?php endif; ?>