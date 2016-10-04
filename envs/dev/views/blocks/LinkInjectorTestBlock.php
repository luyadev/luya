<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>

<?php if ($this->context->getVarValue('link')): ?>
    <h1><?= $this->context->getExtraValue('Title', 'Not Found'); ?></h1>
<?php endif; ?>