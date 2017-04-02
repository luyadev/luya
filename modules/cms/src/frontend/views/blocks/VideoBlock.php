<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
*/
?>
<?php if ($this->extraValue('url')): ?>
	<?php if ($this->cfgValue('width')): ?>
	<div style="width:<?= $this->cfgValue('width'); ?>px">
	<?php endif; ?>
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="<?= $this->extraValue('url'); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    </div>
    <?php if ($this->cfgValue('width')): ?>
	</div>
	<?php endif; ?>
<?php endif; ?>