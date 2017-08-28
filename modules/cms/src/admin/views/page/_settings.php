<?php
use luya\cms\admin\Module;

?>
<modal is-modal-hidden="settingsOverlay" modal-title="Settings">
    <div ng-if="!settingsOverlay" class="row" ng-init="tab=1">
        <div class="col-md-3">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" ng-click="tab=1" ng-class="{'active':tab==1}">Dasboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-click="tab=2" ng-class="{'active':tab==2}"><?= Module::t('view_update_properties_title'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-click="tab=3" ng-class="{'active':tab==3}"><?= Module::t('page_update_actions_layout_title'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-click="tab=4" ng-class="{'active':tab==4}"><?= Module::t('page_update_actions_deepcopy_title'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-click="tab=5" ng-class="{'active':tab==5}">Startseite</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-click="tab=6" ng-class="{'active':tab==6}">Remove</a>
                </li>
            </ul>
        </div>
        <div class="col-md-9" ng-switch="tab">
            <div ng-switch-when="1">
                <h1>Dashboard</h1>
            </div>
            <div ng-switch-when="2">
                <h1><?= Module::t('view_update_properties_title'); ?></h1>
                <div ng-show="!hasValues" class="alert alert-info"><?= Module::t('view_update_no_properties_exists'); ?></div>
                <div class="row" ng-repeat="prop in propertiesData">
                    <div ng-if="prop.i18n" class="col">
                        <ul>
                            <li ng-repeat="lang in languagesData">
                                <zaa-injector dir="prop.type" options="prop.option_json" fieldid="{{prop.var_name}}" fieldname="{{prop.var_name}}" initvalue="{{prop.default_value}}" label="{{lang.name}}: {{prop.label}}" model="propValues[prop.id][lang.short_code]"></zaa-injector>
                            </li>
                        </ul>
                	</div>
                    <div ng-if="!prop.i18n" class="col">
                        <zaa-injector dir="prop.type" options="prop.option_json" fieldid="{{prop.var_name}}" fieldname="{{prop.var_name}}" initvalue="{{prop.default_value}}" label="{{prop.label}}" model="propValues[prop.id]"></zaa-injector>
                    </div>
                </div>
                <button type="button" ng-click="storePropValues()" class="btn btn-primary" ng-show="hasValues"><?= Module::t('btn_refresh'); ?></button>
                <button type="button" ng-click="storePropValues()" class="btn btn-primary" ng-show="!hasValues"><?= Module::t('btn_save'); ?></button>
            </div>
            <div ng-switch-when="3">
                <h1><?= Module::t('page_update_actions_layout_title'); ?></h1>
                <p><?= Module::t('page_update_actions_layout_text'); ?></p>
                <form ng-submit="submitNavForm()">
                <div class="row">
                    <div class="input input--text col s12">
                        <label class="input__label"><?= Module::t('page_update_actions_layout_file_field'); ?></label>
                        <div class="input__field-wrapper">
                            <input type="text" class="input__field validate" ng-model="navData.layout_file" />
                        </div>
                    </div>
                </div>
                <p><button class="btn waves-effect waves-light" type="submit"><?= Module::t('btn_save'); ?></button></p>
                </form>
            </div>
            <div ng-switch-when="4">
                <h1><?= Module::t('page_update_actions_deepcopy_title'); ?></h1>
                <p><?= Module::t('page_update_actions_deepcopy_text'); ?></p>
                <p><button type="button" class="btn" ng-click="createDeepPageCopy()"><?= Module::t('page_update_actions_deepcopy_btn'); ?></button></p>
            </div>
            <div ng-switch-when="5">
                <h1>Startseite</h1>
                <p><?= Module::t('view_update_homepage_info'); ?></p>
                <!-- OLD CODE -->
                <div class="switch switch--with-icons">
                    <label tooltip tooltip-text="<?= Module::t('view_update_homepage_info'); ?>" ng-if="!navData.is_home">
                        <?= Module::t('view_update_is_homepage'); ?>
                        <input type="checkbox" ng-model="navData.is_home" ng-true-value="1" ng-false-value="0">
                        <span class="lever switch__lever"></span>
                    </label>
                </div>
                <span class="grey-text text-darken-2" ng-if="navData.is_home">
                    <i class="material-icons cms__prop-toggle green-text text-darken-1" style="vertical-align: middle; margin-right: 3px;">check_circle</i>
                    <span  style="vertical-align: bottom"><?= Module::t('view_update_is_homepage'); ?></span>
                </span>
            </div>
            <div ng-switch-when="6">
                <h1>Remove</h1>
                <p>Remove this page.</p>
                <p><a ng-click="trash()" class="btn btn-icon btn-delete btn-nolabel"></a></p>
            </div>
        </div>
    </div>
</modal>