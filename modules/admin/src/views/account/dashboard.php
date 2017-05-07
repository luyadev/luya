<?php
use luya\admin\Module;
use luya\helpers\Url;
?>
<div class="container" ng-controller="AccountController">
    <h1><?= $user->firstname; ?> <?= $user->lastname; ?></h1>
    <p><a href="<?= Url::toRoute(['/admin/default/logout']); ?>" class="btn red"><?= Module::t('layout_btn_logout'); ?></a></p>
    <div class="card-panel">
        <div class="row">
          <div class="col s4">
            <h3>Password</h3>
            <form ng-submit="changePassword(pass)">
                <div class="input input--text">
                    <label class="input__label" for="oldpass">Old Password</label>
                    <div class="input__field-wrapper">
                        <input class="input__field" id="oldpass" ng-model="pass.oldpass" type="password" />
                    </div>
                </div>
                <div class="input input--text">
                    <label class="input__label" for="newpass">New Password</label>
                    <div class="input__field-wrapper">
                        <input class="input__field" id="newpass" ng-model="pass.newpass" type="password" />
                    </div>
                </div>
                <div class="input input--text">
                    <label class="input__label" for="newpassrepeat">New Password repeat</label>
                    <div class="input__field-wrapper">
                        <input class="input__field" id="newpassrepeat" ng-model="pass.newpassrepeat" type="password" />
                    </div>
                </div>
                <input style="margin-top:20px;"  type="submit" value="Change Password" class="btn right">
            </form>
          </div>
          <div class="col s4">
            <h3>Settings</h3>
            
            <form ng-submit="updateUserProfile(settings)" method="post" ng-init="settings.lang='<?=Yii::$app->luyaLanguage;?>'">
                <div class="input input--select input--vertical">
                    <label class="input__label" for="layout-changer" style="margin-bottom:5px;"><?= Module::t('layout_rightbar_languagelabel')?></label>
                    <select id="layout-changer" class="input__field-wrapper" ng-model="settings.lang">
                        <?php foreach ($this->context->module->uiLanguageDropdown as $key => $lang): ?>
                        <option value="<?= $key; ?>" <?php if (Yii::$app->luyaLanguage == $key): ?>selected<?php endif; ?>><?= $lang;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input style="margin-top:20px;" type="submit" value="<?= Module::t('layout_rightbar_savebtn'); ?>" class="btn right" />
            </form>
          </div>
          <div class="col s4">
            <h3>Profile</h3>
            <form ng-submit="changePersonData(profile)">
                <div class="input input--select">
                    <label class="input__label" for="title">Title</label>
                    <select class="input__field" id="title" ng-model="profile.title">
                        <option ng-value="1"><?= Module::t('model_user_title_mr'); ?></option>
                        <option ng-value="2"><?= Module::t('model_user_title_mrs'); ?></option>
                    </select>
                </div>
                <div class="input input--text">
                    <label class="input__label" for="firstname">Firstname</label>
                    <div class="input__field-wrapper">
                        <input class="input__field" id="firstname" ng-model="profile.firstname" type="text" />
                    </div>
                </div>
                <div class="input input--text">
                    <label class="input__label" for="firstname">Lastname</label>
                    <div class="input__field-wrapper">
                        <input class="input__field" id="lastname" ng-model="profile.lastname" type="text" />
                    </div>
                </div>
                <div class="input input--text">
                    <label class="input__label" for="email">Email</label>
                    <div class="input__field-wrapper">
                        <input class="input__field" id="email" ng-model="profile.email" type="text" />
                    </div>
                </div>
                <input style="margin-top:20px;"  type="submit" value="<?= Module::t('layout_rightbar_savebtn'); ?>" class="btn right">
            </form>
          </div>
        </div>
    </div>
</div>