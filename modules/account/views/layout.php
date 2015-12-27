<?php
use luya\helpers\Url;
?>
<div class="container">
    <?php echo $content; ?>
</div>
<div class="container" style="margin-top:20px; border-top:1px solid #F0F0F;">
    <ul style="margin-top:20px;">
        <?php if ($this->context->isGuest()): ?>
        <li><a href="<?= Url::toManager('account/default/index'); ?>">Login</a></li>
        <li><a href="<?= Url::toManager('account/register/index'); ?>">Registration</a></li>
        <li><a href="<?= Url::toManager('account/default/lostpass'); ?>">Passwort verloren</a></li>
        <?php else: ?>
        <li><a href="<?= Url::toManager('account/default/logout'); ?>">Logout</a></li>
        <li><a href="<?= Url::toManager('account/settings/index'); ?>">Settings</a></li>
        <?php endif; ?>
    </ul>
</div>