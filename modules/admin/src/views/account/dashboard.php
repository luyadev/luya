<?php
use luya\admin\Module;

?>
<div class="luya-content" ng-controller="AccountController">
    <h1>
        <span><span ng-bind="profile.firstname"></span> <span ng-bind="profile.lastname"></span></span>
    </h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                	<h2>Personalien</h2>
                    <form ng-submit="changePersonData(profile)">
                        <zaa-select model="profile.title" label="<?= Module::t('mode_user_title'); ?>" options="[{value:1, label:'<?= Module::t('model_user_title_mr'); ?>'}, {value:2, label:'<?= Module::t('model_user_title_mrs'); ?>'}]" />
                        <zaa-text label="<?= Module::t('mode_user_firstname'); ?>" model="profile.firstname" />
                        <zaa-text label="<?= Module::t('mode_user_lastname'); ?>" model="profile.lastname" />
                        <zaa-text label="<?= Module::t('mode_user_email'); ?>" model="profile.email" />
                        <button class="btn btn-save btn-icon" type="submit"><?= Module::t('layout_rightbar_savebtn'); ?></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2><?= Module::t('mode_user_password'); ?></h2>
                    <form ng-submit="changePassword(pass)">
                            <zaa-password label="<?= Module::t('aws_changepassword_new_pass'); ?>" model="pass.newpass" />
                            <zaa-password label="<?= Module::t('aws_changepassword_new_pass_retry'); ?>" model="pass.newpassrepeat" />
                            <zaa-password label="<?= Module::t('model_user_oldpassword'); ?>" model="pass.oldpass" />
                           <button class="btn btn-save btn-icon" type="submit"><?= Module::t('layout_rightbar_savebtn'); ?></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2>General</h2>
                    <div class="form-group form-side-by-side">
                        <div class="form-side form-side-label">
                            <label for="layout-changer"><?= Module::t('layout_rightbar_languagelabel')?></label>
                        </div>
                        <div class="form-side">
                            <select id="layout-changer" class="form-control" ng-model="settings.luyadminlanguage">
                                <?php foreach ($this->context->module->interfaceLanguageDropdown as $key => $lang): ?>
                                    <option value="<?= $key; ?>"><?= $lang;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-side-by-side">
                        <div class="form-side form-side-label">
                            <label for="layout-changer">Developer Mode</label>
                        </div>
                        <div class="form-side">
                            <input type="checkbox" ng-model="settings.isDeveloper" id="userSettings.isDeveloper" />
                            <label for="userSettings.isDeveloper"></label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-save btn-icon" ng-click="changeSettings(settings)">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>