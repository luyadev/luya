<?php
use luya\admin\Module;
?>
<div class="login-frame">
    <div class="login-logo">
        <img src="<?= $this->getAssetUrl("luya\admin\assets\Login") .'/images/luyalogo.png' ?>" />
    </div>
    <form class="login-form" method="post" id="loginForm">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div class="login-inputs">
            <div class="login-form-field form-group">
                <input class="login-input" id="email" name="login[email]" type="email" tabindex="1" required />
                <label for="email" class="login-input-label"><?= Module::t('login_mail'); ?></label>
            </div>
            <div class="login-form-field form-group">
                <input class="login-input" id="password" name="login[password]" type="password" tabindex="2" required />
                <label for="password" class="login-input-label"><?= Module::t('login_password'); ?></label>
            </div>
            <div class="login-status alert alert-danger" id="errorsContainer" style="display: none"></div>
            <div class="login-buttons login-buttons-right">
                <button class="btn btn-primary login-btn" type="submit"  tabindex="3">
                    <?= Module::t('login_btn_login'); ?>
                </button>
            </div>
        </div>
    </form>
    <!-- end of normal login in form -->
    <!-- secure login in form -->
    <form class="login-form hidden" method="post" id="secureForm">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div class="login-inputs">
            <div class="login-form-field">
                <label class="input-label login-secure-token-label" for="secure_token"><?= Module::t('login_securetoken_info'); ?></label>
                <input class="login-input" id="secure_token" name="secure_token" type="text" tabindex="1" placeholder="<?= Module::t('login_securetoken'); ?>" />
            </div>
            <div class="login-status" id="errorsContainer" style="display: none"></div>
            <div class="login-buttons">
                <button class="btn btn-primary login-btn login-btn-50" type="submit"  tabindex="2">
                    <?= Module::t('button_send'); ?>
                </button>
                <button class="btn btn-primary login-btn login-btn-50" id="abortToken" type="submit"  tabindex="3">
                    <?= Module::t('button_abort'); ?>
                </button>
            </div>
        </div>
    </form>
        <!-- end of secure login in form -->
</div>

<div class="login-info">
    <h1 class="login-title"><?= Module::t('login_pre_title', ['title' => Yii::$app->siteTitle]); ?></h1>
    <span class="login-info-text">Blub blub blubber</span>
</div>

<div class="login-links">
    <ul class="login-link-list">
        <li class="login-link-item">
            <a href="#" class="login-link">@luyadev</a>
        </li>
    </ul>
</div>
