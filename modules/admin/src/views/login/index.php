<?php
use luya\admin\Module;
?>

<div class="login-panel">
    <div class="login-logo"></div>
    <form class="login-form" method="post" id="loginForm">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div class="login-inputs">
            <h1 class="login-title"><?= Module::t('login_pre_title', ['title' => Yii::$app->siteTitle]); ?></h1>
            <input class="login-input" id="email" name="login[email]" type="email" tabindex="1" placeholder="<?= Module::t('login_mail'); ?>" />
            <input class="login-input" id="password" name="login[password]" type="password" tabindex="2" placeholder="<?= Module::t('login_password'); ?>" />
            <button class="login-btn" type="submit"  tabindex="3">
                <?= Module::t('login_btn_login'); ?>
            </button>
        </div>
    </form>
</div>
