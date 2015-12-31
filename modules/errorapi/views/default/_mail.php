<?php
/**
 * @var $model
 */
?>
<h1>Error Report from <?= $model->serverName; ?></h1>
<p>Message: <?= $model->message; ?></p>
<table cellspacing="2" cellpadding="4" border="0" width="500">
<?php foreach($model->errorArray as $key => $value): ?>
<tr>
    <td width="100"><strong><?= $key; ?></strong></td>
    <td width="400"><?= (is_array($value)) ? print_r($value, true) : $value; ?></td>
</tr>
<?php endforeach; ?>
</table>