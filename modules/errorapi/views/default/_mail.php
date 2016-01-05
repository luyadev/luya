<?php
/**
 * @var $model
 */
?>
<h1 style="color: #f00;"><?= $model->message; ?></h1>
<p style="color: #800000;">from <strong><?= $model->serverName; ?></strong></p>
<table cellspacing="2" cellpadding="6" border="0" width="1200">
<?php foreach($model->errorArray as $key => $value): ?>
<tr>
    <td width="150" style="background-color:#F0F0F0;"><strong><?= $key; ?>:</strong></td>
    <td width="1050" style="background-color:#F0F0F0;">
        <?php if($key === 'trace'): ?>
            <table border="0" cellpadding="4" cellspacing="2" width="100%">
                <?php foreach($value as $number => $trace): ?>
                <tr>
                    <td style="background-color:#e1e1e1; text-align:center;" width="40">
                        #<?= $number; ?>
                    </td>
                    <td style="background-color:#e1e1e1;">
                        <table cellspacing="0" cellpadding="4" border="0">
                            <?php foreach($trace as $k => $v): ?>
                            <tr>
                                <td><?= $k; ?>:</td><td><?= $v; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (is_array($value)): ?>
            <table cellspacing="0" cellpadding="4" border="0">
                <?php foreach($value as $k => $v): ?>
                <tr>
                    <td><?= $k; ?>:</td><td><?= (is_array($v)) ?  print_r($v, true) : $v; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <?= $value; ?>
        <?php endif;?>
</tr>
<?php endforeach; ?>
</table>