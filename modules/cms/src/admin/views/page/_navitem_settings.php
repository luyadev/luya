<?php
use luya\cms\admin\Module;

?>
<modal is-modal-hidden="settingsOverlayVisibility" modal-title="{{item.title}} Settings">
<div class="row" ng-if="!settingsOverlayVisibility">
    <div class="col-md-3">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link" ng-click="tab=1" ng-class="{'active':tab==1}">Title &amp; Slug</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" ng-click="tab=3" ng-class="{'active':tab==3}">Neue Version anlegen</a>
            </li>
            <li><hr /></li>
            <li class="nav-item">
                <a class="nav-link" ng-click="tab=2" ng-class="{'active':tab==2}">Versions</a>
            </li>
            <li class="nav-item" ng-show="editVersionItem">
                <a class="nav-link" ng-click="tab=4" ng-class="{'active':tab==4}">+ {{editVersionItem.version_alias}}</a>
            </li>
        </ul>
    </div>
    <div class="col-md-9" ng-switch="tab">
        <div ng-switch-when="1">
            <h1>Dashboard</h1>
            <form ng-submit="updateNavItemData(itemCopy, typeDataCopy)" ng-switch on="itemCopy.nav_item_type">
                <zaa-text model="itemCopy.title" label="<?= Module::t('view_index_page_title'); ?>" />
                <zaa-text model="itemCopy.alias" label="<?= Module::t('view_index_page_alias'); ?>" />
                <zaa-text model="itemCopy.title_tag" label="<?= Module::t('model_navitem_title_tag_label'); ?>" />
                <zaa-textarea model="itemCopy.description" label="<?= Module::t('view_index_page_meta_description'); ?>" />
                <zaa-textarea model="itemCopy.keywords" label="<?= Module::t('view_index_page_meta_keywords'); ?>" />
                <div ng-switch-when="1">
                    <update-form-page data="typeDataCopy"></update-form-page>
                </div>
                <div ng-switch-when="2">
                    <update-form-module data="typeDataCopy"></update-form-module>
                </div>
                <div ng-switch-when="3">
                    <update-form-redirect data="typeDataCopy"></update-form-redirect>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
        <div ng-switch-when="2">
            <h1>Version</h1>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Layout</th>
                    <th>Erstellt</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
                <tr ng-repeat="versionItem in typeData" ng-class="{'table-success' : currentPageVersion == versionItem.id}">
                    <td>{{versionItem.version_alias}}</td>
                    <td>{{versionItem.contentAsArray.nav_item_page.layout_name}}</td>
                    <td>{{versionItem.timestamp_create}}</td>
                    <td><button type="button" class="btn btn-icon btn-sm btn-outline-secondary" ng-click="editVersion(versionItem)"><i class="material-icons">edit</i></button></td>
                    <td><button type="button" class="btn btn-icon btn-sm btn-outline-danger" ng-click="removeVersion(versionItem)"><i class="material-icons">delete</i></button></td>
                </tr>
            </table>
        </div>
        <div ng-switch-when="4">
            <h1><?= Module::t('version_edit_title'); ?></h1>
            <zaa-text model="editVersionItem.version_alias" label="<?= Module::t('version_input_name'); ?>" />
            <zaa-select model="editVersionItem.layout_id" label="<?= Module::t('version_input_layout'); ?>" options="layoutsData" optionsvalue="id" optionslabel="name" />
            <button type="button" class="btn btn-primary" ng-click="editVersionUpdate(editVersionItem)">Update</button>
        </div>
        <div ng-switch-when="3" ng-controller="PageVersionsController">
            <form ng-submit="createNewVersionSubmit(create)">
                <h2><?= Module::t('version_create_title'); ?></h2>
                <div class="alert alert-info"><?= Module::t('version_create_info'); ?></div>
                <zaa-text model="create.versionName" label="<?= Module::t('version_input_name'); ?>" />
                <div class="form-group">
                    <label class="custom-control custom-radio" ng-click="create.copyExistingVersion=true">
                      <input id="radio1" name="radio" type="radio" class="custom-control-input" ng-checked="create.copyExistingVersion">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description"><?= Module::t('version_create_copy'); ?></span>
                    </label>
                    <label class="custom-control custom-radio" ng-click="create.copyExistingVersion=false">
                      <input id="radio2" name="radio" type="radio" class="custom-control-input" ng-checked="!create.copyExistingVersion">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description"><?= Module::t('version_create_new'); ?></span>
                    </label>
                </div>
                <div ng-show="create.copyExistingVersion" class="form-group">
                    <label><?= Module::t('version_input_copy_chooser'); ?></label>
                    <select class="form-control" ng-model="create.fromVersionPageId" ng-options="versionItem.id as versionItem.version_alias for versionItem in typeData"></select>
                </div>
                <zaa-select ng-show="!create.copyExistingVersion" model="create.versionLayoutId" label="<?= Module::t('version_input_layout'); ?>" options="layoutsData" optionslabel="name" optionsvalue="id" />
                <button class="btn btn-primary" type="submit"><?= Module::t('button_create_version'); ?></button>
            </form>
        </div>
    </div>
</div>
</modal>