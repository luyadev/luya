<?php
/**
 * @var $model The dynamc model
 */
?>
<h2><?= Yii::$app->siteTitle;?> contact request</h2>
<p>Date: <?= date("d.m.Y H:i"); ?></p>
<table border="0" cellpadding="5" cellspacing="2" width="100%">
    <?php foreach ($model->getAttributes() as $key => $value): ?>
    	<tr><td width="150" style="border-bottom:1px solid #F0F0F0"><?= $model->getAttributeLabel($key); ?>:</td><td style="border-bottom:1px solid #F0F0F0"><?= nl2br($value); ?></td>
    <?php endforeach; ?>
</table>