<?php
use luya\admin\Module;
?>

<div class="login-frame">
    <div class="login-panel-left">
        <div class="login-logo"></div>
        <div class="login-system-info">
            <span class="login-version">
                <?= Module::t('login_version'); ?>
            </span>
        </div>
    </div>
    <div class="login-panel-right">
        <!-- normal login in form -->
        <div class="login-status-success-wrapper hidden" id="success">
            <i class="login-status-success material-icons">check_circle</i>
        </div>
        <form class="login-form" method="post" id="loginForm">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken; ?>" />
            <div class="login-inputs">
                <h1 class="login-title"><?= Module::t('login_pre_title', ['title' => Yii::$app->siteTitle]); ?></h1>
                <div class="login-status-wrapper">
                    <div class="login-status" id="errorsContainer" style="display: none"></div>
                </div>
                <div class="login-form-field">
                    <input class="login-input" id="email" name="login[email]" type="email" tabindex="1" required />
                    <label for="email" class="login-input-label"><?= Module::t('login_mail'); ?></label>
                </div>
                <div class="login-form-field">
                    <input class="login-input" id="password" name="login[password]" type="password" tabindex="2" required />
                    <label for="password" class="login-input-label"><?= Module::t('login_password'); ?></label>
                    <a href="#" class="login-reset login-link">
                        Passwort vergessen?
                    </a>
                </div>
                <div class="login-buttons">
                    <button class="login-btn" type="submit"  tabindex="3">
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
                <h1 class="login-title"><?= Module::t('login_pre_title', ['title' => Yii::$app->siteTitle]); ?></h1>
                <div class="login-status-wrapper">
                    <div class="login-status" id="errorsContainer" style="display: none">
                        <span class="login-status-message">blah</span>
                    </div>
                </div>
                <div class="login-form-field">
                    <label class="input-label" for="secure_token"><?= Module::t('login_securetoken_info'); ?></label>
                    <input class="login-input" id="secure_token" name="secure_token" type="text" tabindex="1" placeholder="<?= Module::t('login_securetoken'); ?>" />
                </div>
                <div class="login-buttons">
                    <button class="login-btn login-btn-50" type="submit"  tabindex="2">
                        <?= Module::t('button_send'); ?>
                    </button>
                    <button class="login-btn login-btn-50" id="abortToken" type="submit"  tabindex="3">
                        <?= Module::t('button_abort'); ?>
                    </button>
                </div>
            </div>
        </form>
        <!-- end of secure login in form -->
    </div>
</div>
