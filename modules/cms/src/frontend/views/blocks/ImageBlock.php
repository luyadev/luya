<?php
use yii\helpers\Html;

/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>
<?php if ($this->extraValue('image')): ?>
<div class="image<?= $this->cfgValue('divCssClass', null, ' {{divCssClass}}'); ?>">
	<figure>
		<?php if ($this->extraValue('link')): ?>
			<a class="text-teaser" href="<?= $this->extraValue('link')->href; ?>" target="<?= $this->extraValue('link')->target; ?>">
		<?php endif; ?>
		<?= Html::tag('img', '', [
            'src' => $this->extraValue('image')['source'],
            'alt' => $this->varValue('caption', ''),
            'title' => $this->varValue('caption', null),
            'width' => $this->cfgValue('width', null),
            'height' => $this->cfgValue('height', null),
            'class' => 'img-responsive' . $this->cfgValue('cssClass', null, ' {{cssClass}}'),
        ]); ?>
		<?php if ($this->extraValue('link')): ?>
			</a>
		<?php endif; ?>
		<?= $this->extraValue('text', null, '<figcaption>{{text}}</figcaption>')?>
	</figure>
</div>
<?php endif; ?>