<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>
<div class="row<?= $this->cfgValue('rowDivClass', null, ' {{rowDivClass}}');?>">
    <div class="<?= $this->extraValue('leftWidth', null, 'col-md-{{leftWidth}}') . $this->cfgValue('leftColumnClasses', null, ' {{leftColumnClasses}}'); ?>">
        <?= $this->placeholderValue('left'); ?>
    </div>
    <div class="<?= $this->extraValue('rightWidth', null, 'col-md-{{rightWidth}}') . $this->cfgValue('rightColumnClasses', null, ' {{rightColumnClasses}}'); ?>">
        <?= $this->placeholderValue('right'); ?>
    </div>
</div>