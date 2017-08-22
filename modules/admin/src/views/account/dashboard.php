<?php
use luya\admin\Module;
use luya\helpers\Url;

?>
<div class="luya-content" ng-controller="AccountController">
    <h1>
        <span ng-bind="profile.firstname"></span> <span ng-bind="profile.lastname"></span>
        <a href="<?= Url::toRoute(['/admin/default/logout']); ?>" class="btn btn-danger"><?= Module::t('layout_btn_logout'); ?></a>
    </h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                	<h2>Personalien</h2>
                    <form ng-submit="changePersonData(profile)">
                        <div class="form-group form-side-by-side">
                            <div class="form-side form-side-label">
                                <label for="title"><?= Module::t('mode_user_title'); ?></label>
                            </div>
                            <div class="form-side">
                                <select class="form-control" id="title" ng-model="profile.title">
                                    <option ng-value="1"><?= Module::t('model_user_title_mr'); ?></option>
                                    <option ng-value="2"><?= Module::t('model_user_title_mrs'); ?></option>
                                </select>
                            </div>
                        </div>
                            
                        <div class="form-group form-side-by-side">
                            <div class="form-side form-side-label">
                                <label for="firstname"><?= Module::t('mode_user_firstname'); ?></label>
                            </div>
                            <div class="form-side">
                                <input class="form-control" id="firstname" ng-model="profile.firstname" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group form-side-by-side">
                            <div class="form-side form-side-label">
                                <label for="firstname"><?= Module::t('mode_user_lastname'); ?></label>
                            </div>
                            <div class="form-side">
                                <input class="form-control" id="lastname" ng-model="profile.lastname" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group form-side-by-side">
                            <div class="form-side form-side-label">
                                <label for="email"><?= Module::t('mode_user_email'); ?></label>
                            </div>
                            <div class="form-side">
                                <input class="form-control" id="email" ng-model="profile.email" type="text" />
                            </div>
                        </div>
                            
                        <input class="btn btn-primary" type="submit" value="<?= Module::t('layout_rightbar_savebtn'); ?>">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2><?= Module::t('mode_user_password'); ?></h2>
                    <form ng-submit="changePassword(pass)">
                            <div class="form-group form-side-by-side">
                                <div class="form-side form-side-label">
                                    <label for="newpass"><?= Module::t('aws_changepassword_new_pass'); ?></label>
                                </div>
                                <div class="form-side">
                                    <input class="form-control" id="newpass" ng-model="pass.newpass" type="password" />
                                </div>
                            </div>
                            <div class="form-group form-side-by-side">
                                <div class="form-side form-side-label">
                                    <label for="newpassrepeat"><?= Module::t('aws_changepassword_new_pass_retry'); ?></label>
                                </div>
                                <div class="form-side">
                                    <input class="form-control" id="newpassrepeat" ng-model="pass.newpassrepeat" type="password" />
                                </div>
                            </div>
                            
                            <div class="form-group form-side-by-side">
                                <div class="form-side form-side-label">
                                    <label for="oldpass"><?= Module::t('model_user_oldpassword'); ?></label>
                                </div>
                                <div class="form-side">
                                    <input class="form-control" id="oldpass" ng-model="pass.oldpass" type="password" />
                                </div>
                            </div>
                           
                           <input  class="btn btn-primary" type="submit" value="<?= Module::t('layout_rightbar_savebtn'); ?>">
                            
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
                            <input type="checkbox" ng-model="settings.isDeveloper" />
                        </div>
                    </div>
                    <button type="button" class="btn" ng-click="changeSettings(settings)">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>