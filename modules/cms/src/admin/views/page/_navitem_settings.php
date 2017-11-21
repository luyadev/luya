<?php
use luya\cms\admin\Module;
use luya\admin\helpers\Angular;

?>
<modal is-modal-hidden="settingsOverlayVisibility" modal-title="{{item.title}} <?= Module::t('cmsadmin_settings_modal_title'); ?>">
<div class="row" ng-if="!settingsOverlayVisibility">
    <div class="col-md-3">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link nav-link-icon" ng-click="changeTab(1)" ng-class="{'active':tab==1}"><i class="material-icons">title</i><span><?= Module::t('cmsadmin_item_settings_titleslug'); ?></a>
            </li>
            <li class="nav-item" ng-show="!isDraft && item.nav_item_type == 1">
                <a class="nav-link nav-link-icon" ng-click="changeTab(3)" ng-class="{'active':tab==3}"><i class="material-icons">change_history</i><span><?= Module::t('version_create_title'); ?></span></a>
            </li>
            <li class="nav-item" ng-show="!isDraft && item.nav_item_type == 1">
                <a class="nav-link nav-link-icon" ng-click="changeTab(2)" ng-class="{'active':tab==2}"><i class="material-icons">track_changes</i><span><?= Module::t('versions_selector'); ?></span></a>
            </li>
            <li ng-show="!isDraft && item.nav_item_type == 1"><hr /></li>
            <li ng-show="!isDraft && item.nav_item_type == 1" ng-repeat="(key, versionItem) in typeData">
                <a class="nav-link" ng-class="{'active' : editVersionItem.id == versionItem.id && tab == 4}" ng-click="editVersion(versionItem)"><span class="badge" ng-class="{'badge-secondary': item.nav_item_type_id!=versionItem.id, 'badge-primary': item.nav_item_type_id==versionItem.id}">V{{$index+1}}</span> {{versionItem.version_alias}}</a>
            </li>
        </ul>
    </div>
    <div class="col-md-9" ng-switch="tab">
        <div ng-switch-when="1">
            <h1><?= Module::t('cmsadmin_item_settings_titleslug'); ?></h1>
            <form ng-submit="updateNavItemData(itemCopy, typeDataCopy)" ng-switch on="itemCopy.nav_item_type">
                <zaa-text model="itemCopy.title" label="<?= Module::t('view_index_page_title'); ?>" />
                <zaa-text model="itemCopy.alias" label="<?= Module::t('view_index_page_alias'); ?>" />
                <zaa-text model="itemCopy.title_tag" label="<?= Module::t('model_navitem_title_tag_label'); ?>" />
                <zaa-textarea model="itemCopy.description" label="<?= Module::t('view_index_page_meta_description'); ?>" />
                <zaa-textarea model="itemCopy.keywords" label="<?= Module::t('view_index_page_meta_keywords'); ?>" />
                <?= Angular::datetime('itemCopy.timestamp_create', Module::t('view_index_page_meta_timestamp_create'), ['resetable' => false]); ?>
                <?= Angular::radio('itemCopy.nav_item_type', Module::t('view_index_add_type'), [
                    1 => Module::t('view_index_type_page'),
                    2 => Module::t('view_index_type_module'),
                    3 => Module::t('view_index_type_redirect'),
                ]); ?>
                <div ng-switch-when="1">
                    <update-form-page data="typeDataCopy"></update-form-page>
                </div>
                <div ng-switch-when="2">
                    <update-form-module data="typeDataCopy"></update-form-module>
                </div>
                <div ng-switch-when="3">
                    <update-form-redirect data="typeDataCopy"></update-form-redirect>
                </div>
                <button type="submit" class="btn btn-icon btn-save"><?= Module::t('btn_save'); ?></button>
            </form>
        </div>
        <div ng-switch-when="2">
            <h1><?= Module::t('versions_selector'); ?></h1>
            <div class="table-responsive-wrapper">
                <table class="table table-bordered">
                    <tr>
                        <th><?= Module::t('version_input_name'); ?></th>
                        <th><?= Module::t('version_input_layout'); ?></th>
                        <th colspan="3"><?= Module::t('cmsadmin_created_at'); ?></th>
                    </tr>
                    <tr ng-repeat="versionItem in typeData">
                        <td>{{versionItem.version_alias}} <span class="badge badge-primary" ng-if="item.nav_item_type_id == versionItem.id"><?= Module::t('view_index_page_version_chooser'); ?></span></td>
                        <td>{{versionItem.contentAsArray.nav_item_page.layout_name}}</td>
                        <td>{{versionItem.timestamp_create | date :'short'}}</td>
                        <td>
                            <button type="button" class="btn btn-symbol btn-sm btn-outline-secondary" ng-click="editVersion(versionItem)"><i class="material-icons">edit</i></button>
                            <button type="button" class="btn btn-delete btn-icon btn-nolabel" ng-if="item.nav_item_type_id != versionItem.id" ng-click="removeVersion(versionItem)"></button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div ng-switch-when="4">
            <h1><?= Module::t('version_edit_title'); ?> <span class="badge" ng-class="{'badge-secondary': item.nav_item_type_id!=editVersionItem.id, 'badge-primary': item.nav_item_type_id==editVersionItem.id}">{{editVersionItem.version_alias}}</span></h1>
            <h2></h2>
            <zaa-text model="editVersionItem.version_alias" label="<?= Module::t('version_input_name'); ?>" />
            <zaa-select model="editVersionItem.layout_id" label="<?= Module::t('version_input_layout'); ?>" options="layoutsData" optionsvalue="id" optionslabel="name" />
            <button type="button" class="btn btn-save btn-icon" ng-click="editVersionUpdate(editVersionItem)"><?= Module::t('btn_save'); ?></button>
        </div>
        <div ng-switch-when="3" ng-controller="PageVersionsController">
            <form ng-submit="createNewVersionSubmit(create)">
                <h2><?= Module::t('version_create_title'); ?></h2>
                <div class="alert alert-info"><?= Module::t('version_create_info'); ?></div>
                <zaa-text model="create.versionName" label="<?= Module::t('version_input_name'); ?>" />

                <div class="form-group">
                    <div class="form-check">
                        <input id="copyExistingVersion" name="radio" type="radio" ng-checked="create.copyExistingVersion" />
                        <label for="copyExistingVersion" ng-click="create.copyExistingVersion=true"><?= Module::t('version_create_copy'); ?></label>
                    </div>
                    <div class="form-check">
                        <input id="createNewVersion" name="radio" type="radio" ng-checked="!create.copyExistingVersion" />
                        <label for="createNewVersion" ng-click="create.copyExistingVersion=false"><?= Module::t('version_create_new'); ?></label>
                    </div>
                </div>

                <div ng-show="create.copyExistingVersion" class="form-group">
                    <label><?= Module::t('version_input_copy_chooser'); ?></label>
                    <select class="form-control" ng-model="create.fromVersionPageId" ng-options="versionItem.id as versionItem.version_alias for versionItem in typeData"></select>
                </div>
                <zaa-select ng-show="!create.copyExistingVersion" model="create.versionLayoutId" label="<?= Module::t('version_input_layout'); ?>" options="layoutsData" optionslabel="name" optionsvalue="id" />
                <button class="btn btn-save btn-icon" type="submit"><?= Module::t('button_create_version'); ?></button>
            </form>
        </div>
    </div>
</div>
</modal>