<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
*/
?>
<?php if (!empty($this->extraValue('fileList'))): ?>
<ul>
	<?php foreach ($this->extraValue('fileList') as $file): ?>
		<li><a target="_blank" href="<?= $file['href']; ?>"><?= $file['caption']; ?><?php if ($this->cfgValue('showType')): ?> (<?= $file['extension'];?>)<?php endif; ?></a></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>