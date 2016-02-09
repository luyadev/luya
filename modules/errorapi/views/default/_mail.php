<?php
/**
 * @var $model
 */
?>
<h1 style="color: #f00;"><?php echo $model->message; ?></h1>
<p style="color: #800000;">from <strong><?php echo $model->serverName; ?></strong></p>
<a href="https://github.com/zephir/luya/issues/new?title=<?php echo urlencode('#'. $model->identifier . ' ' . $model->message);?>"><?php echo errorapi\Module::t('mail_create_issue') ?></a>
<table cellspacing="2" cellpadding="6" border="0" width="1200">
<?php foreach ($model->errorArray as $key => $value): ?>
<tr>
    <td width="150" style="background-color:#F0F0F0;"><strong><?php echo $key; ?>:</strong></td>
    <td width="1050" style="background-color:#F0F0F0;">
        <?php if ($key === 'trace'): ?>
            <table border="0" cellpadding="4" cellspacing="2" width="100%">
                <?php foreach ($value as $number => $trace): ?>
                <tr>
                    <td style="background-color:#e1e1e1; text-align:center;" width="40">
                        #<?php echo $number; ?>
                    </td>
                    <td style="background-color:#e1e1e1;">
                        <table cellspacing="0" cellpadding="4" border="0">
                            <?php foreach ($trace as $k => $v): ?>
                            <tr>
                                <td><?php echo $k; ?>:</td><td><?php echo $v; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (is_array($value)): ?>
            <table cellspacing="0" cellpadding="4" border="0">
                <?php foreach ($value as $k => $v): ?>
                <tr>
                    <td><?php echo $k; ?>:</td><td><?php echo (is_array($v)) ?  print_r($v, true) : $v; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <?php echo $value; ?>
        <?php endif;?>
</tr>
<?php endforeach; ?>
</table>