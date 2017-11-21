<?php
use luya\cms\admin\Module;
use luya\admin\helpers\Angular;

?>
<modal is-modal-hidden="pageSettingsOverlayHidden" modal-title="<?= Module::t('cmsadmin_settings_modal_title'); ?>">
    <div ng-if="!pageSettingsOverlayHidden" class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item" ng-show="propertiesData.length > 0">
                    <a class="nav-link nav-link-icon" ng-click="pageSettingsOverlayTab=2" ng-class="{'active':pageSettingsOverlayTab==2}"><i class="material-icons">settings</i><span><?= Module::t('view_update_properties_title'); ?></span></a>
                </li>
                <li class="nav-item" ng-show="!isDraft">
                    <a class="nav-link nav-link-icon" ng-click="pageSettingsOverlayTab=7" ng-class="{'active':pageSettingsOverlayTab==7}"><i class="material-icons">timelapse</i><span><?= Module::t('cmsadmin_settings_time_title'); ?></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" ng-click="pageSettingsOverlayTab=4" ng-class="{'active':pageSettingsOverlayTab==4}"><i class="material-icons">content_copy</i><span><?= Module::t('page_update_actions_deepcopy_title'); ?></span></a>
                </li>
                <li class="nav-item" ng-show="!isDraft">
                    <a class="nav-link nav-link-icon" ng-click="pageSettingsOverlayTab=5" ng-class="{'active':pageSettingsOverlayTab==5}"><i class="material-icons">home</i><span><?= Module::t('cmsadmin_settings_homepage_title'); ?></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" ng-click="pageSettingsOverlayTab=3" ng-class="{'active':pageSettingsOverlayTab==3}"><i class="material-icons">web</i><span><?= Module::t('page_update_actions_layout_title'); ?></span></a>
                </li>
                <?php if (Yii::$app->adminuser->canRoute(Module::ROUTE_PAGE_DELETE)): ?>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" ng-click="pageSettingsOverlayTab=6" ng-class="{'active':pageSettingsOverlayTab==6}"><i class="material-icons">delete</i><span><?= Module::t('cmsadmin_settings_trashpage_title'); ?></span></a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="col-md-9" ng-switch="pageSettingsOverlayTab">
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
                <button type="button" ng-click="storePropValues()" class="btn btn-save btn-icon" ng-show="hasValues"><?= Module::t('btn_refresh'); ?></button>
                <button type="button" ng-click="storePropValues()" class="btn btn-save btn-icon" ng-show="!hasValues"><?= Module::t('btn_save'); ?></button>
            </div>
            <div ng-switch-when="3">
                <h1><?= Module::t('page_update_actions_layout_title'); ?></h1>
                <p><?= Module::t('page_update_actions_layout_text'); ?></p>
                <form ng-submit="submitNavForm({layout_file: navData.layout_file})">
	                <zaa-text model="navData.layout_file" label="<?= Module::t('page_update_actions_layout_file_field'); ?>" />
	                <button class="btn btn-save btn-icon" type="submit"><?= Module::t('btn_save'); ?></button>
                </form>
            </div>
            <div ng-switch-when="4">
                <h1><?= Module::t('page_update_actions_deepcopy_title'); ?></h1>
                <p><?= Module::t('page_update_actions_deepcopy_text'); ?></p>
                <p><button type="button" class="btn btn-save btn-icon" ng-click="createDeepPageCopy()"><?= Module::t('page_update_actions_deepcopy_btn'); ?></button></p>
            </div>
            <div ng-switch-when="5" ng-show="!isDraft">
                <h1><?= Module::t('cmsadmin_settings_homepage_title'); ?></h1>
                <p><?= Module::t('view_update_homepage_info'); ?></p>
                <!-- OLD CODE -->
                <label ng-if="!navData.is_home">
                    <button type="button" ng-click="navData.is_home=1" class="btn btn-save btn-icon"><?= Module::t('view_update_set_as_homepage_btn'); ?></button>
                </label>
                <button type="button" class="btn btn-success btn-disabled" disabled ng-if="navData.is_home"><?= Module::t('view_update_is_homepage'); ?></button>
            </div>
            <?php if (Yii::$app->adminuser->canRoute(Module::ROUTE_PAGE_DELETE)): ?>
            <div ng-switch-when="6">
                <h1><?= Module::t('cmsadmin_settings_trashpage_title'); ?></h1>
                <p><a ng-click="trash()" class="btn btn-delete btn-icon">Remove Page</a></p>
            </div>
            <?php endif; ?>
            
            <div ng-switch-when="7">
                <h1><?= Module::t('cmsadmin_settings_time_title'); ?></h1>
                <form ng-submit="submitNavForm({publish_from: navData.publish_from, publish_till: navData.publish_till})">
                	<?= Angular::datetime('navData.publish_from', Module::t('cmsadmin_settings_time_title_from')); ?>
                	<?= Angular::datetime('navData.publish_till', Module::t('cmsadmin_settings_time_title_till')); ?>
	                <button class="btn btn-save btn-icon" type="submit"><?= Module::t('btn_save'); ?></button>
                </form>
            </div>
        </div>
    </div>
</modal>