<?php
use yii\helpers\Html;

/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>
<?php if (!empty($this->extraValue('linkData'))): ?>
    <?= Html::a($this->varValue('label'), $this->extraValue('linkData')->href, [
        'class' => $this->extraValue('cssClass', null),
        'target' => $this->cfgValue('targetBlank') ? '_blank' : null,
    ]); ?>
<?php endif; ?>