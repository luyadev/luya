<?php
use luya\admin\Module;

$spinner = '<svg version="1.1" 
                id="svg-spinner"
                xmlns="http://www.w3.org/2000/svg" 
                xmlns:xlink="http://www.w3.org/1999/xlink" 
                x="0px" 
                y="0px"
                viewBox="0 0 120 120" 
                xml:space="preserve">
            
                <path
                    id="spinner" 
                    fill="#fff" 
                    d="M40,72C22.4,72,8,57.6,8,40C8,22.4,
                    22.4,8,40,8c17.6,0,32,14.4,32,32c0,1.1-0.9,2-2,2
                    s-2-0.9-2-2c0-15.4-12.6-28-28-28S12,24.6,12,40s12.6,
                    28,28,28c1.1,0,2,0.9,2,2S41.1,72,40,72z"
                >
                    <animateTransform
                        attributeType="xml"
                        attributeName="transform"
                        type="rotate"
                        from="0 40 40"
                        to="360 40 40"
                        dur="0.6s"
                        repeatCount="indefinite"
                    />
                </path>
            </svg>';
?>
<div class="login-frame">
    <div class="login-logo">
        <img src="<?= $this->getAssetUrl("luya\admin\assets\Login") .'/images/luyalogo.png' ?>" alt="<?= Module::t('login_pre_title', ['title' => Yii::$app->siteTitle]); ?>" />
    </div>
    <!-- normal login form -->
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
                    <?= '<span class="login-spinner">' . $spinner . '</span>' . '<span class="login-btn-label">' . Module::t('login_btn_login') . '</span>'; ?>
                </button>
            </div>
        </div>
    </form>
    <!-- end of normal login form -->
    <!-- secure login form -->
    <form class="login-form hidden" method="post" id="secureForm">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div class="login-inputs">
            <div class="login-form-field">
                <label class="input-label login-secure-token-label" for="secure_token"><?= Module::t('login_securetoken_info'); ?></label>
                <input class="login-input" id="secure_token" name="secure_token" type="text" tabindex="1" placeholder="<?= Module::t('login_securetoken'); ?>" />
            </div>
            <div class="login-status alert alert-danger" id="errorsSecureContainer" style="display: none"></div>
            <div class="login-buttons">
                <button class="btn btn-secondary login-btn login-btn-50" id="abortToken" type="button"  tabindex="3">
                    <?= Module::t('button_abort'); ?>
                </button>
                <button class="btn btn-primary login-btn login-btn-50" type="submit"  tabindex="2">
                   <?= '<span class="login-spinner">' . $spinner . '</span>' . '<span class="login-btn-label">' . Module::t('button_send') . '</span>'; ?>
                </button>
            </div>
        </div>
    </form>
    <!-- end of secure login form -->
    <div class="login-success hidden" id="success">
        <i class="material-icons login-success-icon">check_circle</i>
    </div>
</div>

<div class="login-info">
    <h1 class="login-title"><?= Yii::$app->siteTitle; ?></h1>
    <span class="login-info-text"><?php if (Yii::$app->request->isSecureConnection): ?><i class="material-icons">verified_user</i><?endif; ?><?= Yii::$app->request->hostInfo; ?></span>
</div>

<div class="login-links">
    <ul>
        <li>
            <a href="https://twitter.com/luyadev" target="_blank" class="login-link">@luyadev</a>
        </li>
    </ul>
</div>
