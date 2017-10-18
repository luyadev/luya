<?php
use yii\helpers\Html;

/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>
<?php if (!empty($this->extraValue('linkData'))): ?>
    <?= Html::a($this->varValue('label'), $this->extraValue('linkData')->getHref(), [
        'class' => $this->extraValue('cssClass', null),
        'target' =>$this->extraValue('linkData')->getTarget(),
    ]); ?>
<?php endif; ?>