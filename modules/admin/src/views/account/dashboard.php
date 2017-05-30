<?php
use luya\admin\Module;
use luya\helpers\Url;
?>

<div class="luya__content">
    <h1>Account</h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#entries" role="tab">
                <i class="material-icons">list</i>
                <span>Entries</span>
            </a>
        </li>
        <li class="nav-item mr-auto"> <!-- THE LAST ONE OF THE REGULAR CRUD TABS NEEDS TO HAVE THE MR-AUTO CLASS -->
            <a class="nav-link" data-toggle="tab" href="#add" role="tab">
                <i class="material-icons">add_box</i>
                <span>Add new</span>
            </a>
        </li>

    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="entries" role="tabpanel">
            <div class="tab-padded">
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" ng-controller="AccountController">
    <br />
    <div class="row">
        <div class="col s8">
            <div class="card-panel">
                <div class="row">
                    <div class="col s12">
                        <h4 class="input-offset"><span ng-bind="profile.firstname"></span> <span ng-bind="profile.lastname"></span></h4>
                    </div>
                </div>
                <form ng-submit="changePersonData(profile)">
                    <div class="row">
                        <div class="col s12">
                            <div class="input input--select">
                                <label class="input__label" for="title"><?= Module::t('mode_user_title'); ?></label>
                                <div class="input__select-wrapper">
                                    <select class="input__field" id="title" ng-model="profile.title">
                                        <option ng-value="1"><?= Module::t('model_user_title_mr'); ?></option>
                                        <option ng-value="2"><?= Module::t('model_user_title_mrs'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input input--text">
                                <label class="input__label" for="firstname"><?= Module::t('mode_user_firstname'); ?></label>
                                <div class="input__field-wrapper">
                                    <input class="input__field" id="firstname" ng-model="profile.firstname" type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input input--text">
                                <label class="input__label" for="firstname"><?= Module::t('mode_user_lastname'); ?></label>
                                <div class="input__field-wrapper">
                                    <input class="input__field" id="lastname" ng-model="profile.lastname" type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input input--text">
                                <label class="input__label" for="email"><?= Module::t('mode_user_email'); ?></label>
                                <div class="input__field-wrapper">
                                    <input class="input__field" id="email" ng-model="profile.email" type="text" />
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <input style="margin-top:20px;"  type="submit" value="<?= Module::t('layout_rightbar_savebtn'); ?>" class="btn right">
                        </div>
                    </div>
                </form>
            </div>
            <br />
            <div class="card-panel">
                <div class="row">
                    <div class="col s12">
                        <h4 class="input-offset"><?= Module::t('mode_user_password'); ?></h4>
                    </div>
                </div>
                <form ng-submit="changePassword(pass)" class="clearfix">
                    <div class="row">
                        <div class="col s12 l6">
                            <div class="input input--text">
                                <label class="input__label" for="newpass"><?= Module::t('aws_changepassword_new_pass'); ?></label>
                                <div class="input__field-wrapper">
                                    <input class="input__field" id="newpass" ng-model="pass.newpass" type="password" />
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l6">
                            <div class="input input--text">
                                <label class="input__label" for="newpassrepeat"><?= Module::t('aws_changepassword_new_pass_retry'); ?></label>
                                <div class="input__field-wrapper">
                                    <input class="input__field" id="newpassrepeat" ng-model="pass.newpassrepeat" type="password" />
                                </div>
                            </div>
                        </div>
                        <div class="col s12" ng-show="pass.newpass && pass.newpassrepeat">
                            <div class="input input--text">
                                <label class="input__label" for="oldpass"><?= Module::t('model_user_oldpassword'); ?></label>
                                <div class="input__field-wrapper">
                                    <input class="input__field" id="oldpass" ng-model="pass.oldpass" type="password" />
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <input style="margin-top:20px;" type="submit" value="<?= Module::t('layout_rightbar_savebtn'); ?>" class="btn right">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s3">
            <div class="card-panel grey lighten-3">
                <p><a href="<?= Url::toRoute(['/admin/default/logout']); ?>" class="btn btn--full-width red"><?= Module::t('layout_btn_logout'); ?></a></p>
                <br />
                <div ng-init="settings.lang='<?=Yii::$app->adminuser->interfaceLanguage;?>'">
                    <div class="row">
                        <div class="col s12">
                            <div class="input input--select input--vertical">
                                <label class="input__label black-text" for="layout-changer" style="margin-bottom:5px;"><?= Module::t('layout_rightbar_languagelabel')?></label>
                                <div class="input__select-wrapper">
                                    <select id="layout-changer" class="input__field" ng-model="settings.lang" ng-change="updateUserProfile(settings)">
                                        <?php foreach ($this->context->module->interfaceLanguageDropdown as $key => $lang): ?>
                                            <option value="<?= $key; ?>" <?php if (Yii::$app->adminuser->interfaceLanguage == $key): ?>selected<?php endif; ?>><?= $lang;?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>