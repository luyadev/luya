<?php
use yii\helpers\Html;

/**
 * @var $this \luya\cms\base\PhpBlockView
 */
?>
<?php if ($this->extraValue('image') && $this->extraValue('text')): ?>
    <div>
        <?= Html::img($this->extraValue('image')['source'], [
            'class' => ($this->varValue('imagePosition', 'left') == 'left') ? 'pull-left img-responsive' : 'pull-right img-responsive',
            'width' => $this->cfgValue('width', null),
            'height' => $this->cfgValue('height', null),
            'style' => (($this->varValue('imagePosition', 'left') == 'left') ? "margin-right:{$this->cfgValue('margin', '20px')}" : "margin-left:{$this->cfgValue('margin', '20px')}") . $this->cfgValue('margin', '20px', ';margin-bottom:{{margin}};max-width:50%;'),
        ])?>
        <div>
            <?= $this->extraValue('text'); ?>

            <?php if ($this->cfgValue('btnHref') && $this->cfgValue('btnLabel')): ?>
                <br>
                <?= Html::a($this->cfgValue('btnLabel'), $this->cfgValue('btnHref'), [
                    'class' => 'button',
                    'target' => ($this->cfgValue('targetBlank') == 1) ? '_blank' : null,
                ]); ?>
            <?php endif; ?>
        </div>
    </div>
    <div style="clear:both"></div>
<?php endif; ?>