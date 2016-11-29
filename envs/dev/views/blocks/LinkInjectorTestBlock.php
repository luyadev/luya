<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>

<a href="<?= $this->extraValue('link')?>" target="<?= $this->extraValue('link')->target?>">asfd</a><p>asdf</p>

<?php if ($this->context->getVarValue('link')): ?>
   
    <h1><?= $this->context->getExtraValue('Title', 'Not Found'); ?></h1>
<?php endif; ?>