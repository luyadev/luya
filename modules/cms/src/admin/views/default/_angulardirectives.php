<?php
use luya\cms\admin\Module;

?>
<script type="text/ng-template" id="createform.html">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" ng-class="{'active' : data.nav_item_type == 1}" ng-click="data.nav_item_type = 1"><?= Module::t('view_index_type_page'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-class="{'active' : data.nav_item_type == 2}" ng-click="data.nav_item_type = 2;  data.is_draft = 0"><?= Module::t('view_index_type_module'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-class="{'active' : data.nav_item_type == 3}" ng-click="data.nav_item_type = 3;  data.is_draft = 0"><?= Module::t('view_index_type_redirect'); ?></a>
                </li>
            </ul>
        </div>
        <div  class="card-body">
            <form ng-switch on="data.nav_item_type">
                <div class="form-group" ng-show="data.nav_item_type == 1 && !data.isInline">
                    <label for="exampleInputEmail1"><?= Module::t('view_index_as_draft'); ?></label>
                    <div class="form-check">
                        <input class="form-check-input" ng-checked="data.is_draft == 1" type="radio" name="inlineRadioOptions" id="update-as-draft-yes" />
                        <label class="form-check-label" ng-click="data.is_draft = 1" for="update-as-draft-yes"><?= Module::t('view_index_yes'); ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" ng-checked="data.is_draft == 0" type="radio" name="inlineRadioOptions" id="update-as-draft-no" />
                        <label class="form-check-label" ng-click="data.is_draft = 0" for="update-as-draft-no"><?= Module::t('view_index_no'); ?></label>
                    </div>
                </div>
                <div class="form-group" ng-init="showFocus=true">
                    <label><?= Module::t('view_index_page_title'); ?></label>
                    <input name="text" type="text" class="form-control" ng-model="data.title" ng-change="aliasSuggestion()" focus-me="showFocus" />
                </div>
                <div class="form-group">
                    <label><?= Module::t('view_index_page_alias'); ?></label>
                    <input name="text" type="text" class="form-control" ng-model="data.alias" />
                </div>
                <div class="form-group" ng-show="data.is_draft==0">
                    <label><?= Module::t('view_index_page_meta_description'); ?></label>
                    <textarea class="form-control" ng-model="data.description"></textarea>
                </div>
                <div class="form-group" ng-show="data.is_draft==0" ng-hide="data.isInline || navcontainer.length == 1 || data.parent_nav_id!=0">
                    <label><?= Module::t('view_index_page_nav_container'); ?></label>
                    <select class="form-control" ng-model="data.nav_container_id" ng-options="item.id as item.name for item in navcontainers"></select>
                </div>
                <div class="form-group" ng-show="data.is_draft==0 && !data.isInline">
                    <label><?= Module::t('view_index_page_parent_page'); ?></label>
                    <input id="[checkbox-id]" ng-model="data.parent_nav_id" value="0" ng-true-value="0" type="checkbox"/>
                    <label for="[checkbox-id]"><?= Module::t('view_index_page_parent_root'); ?></label>
                    <menu-dropdown class="menu-dropdown" nav-id="data.parent_nav_id" />
                </div>
                <hr />
                <div ng-switch-when="1">
                    <create-form-page data="data"></create-form-page>
                </div>
                <div ng-switch-when="2">
                    <create-form-module data="data"></create-form-module>
                </div>
                <div ng-switch-when="3">
                    <create-form-redirect data="data"></create-form-redirect>
                </div>
                <div class="alert alert-success mt-3 mb-0" ng-show="success">
                    <i class="material-icons">check_circle</i> <?= Module::t('view_index_page_success'); ?>
                </div>
                <ul class="list-group mt-3" ng-show="error.length != 0">
                    <li class="list-group-item list-group-item-danger" ng-repeat="err in error">{{ err[0] }}</li>
                </ul>
            </form>
        </div>
    </div>
</script>

<!-- CREATE PAGE FORM -->
<script type="text/ng-template" id="createformpage.html">
    <div class="form-group" ng-show="!data.isInline">
        <label class="input__label"><?= Module::t('view_index_page_use_draft'); ?></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" ng-checked="data.use_draft == 1" id="create-as-draft-yes">
            <label class="form-check-label" ng-click="data.use_draft = 1; data.layout_id = 0" for="create-as-draft-yes"><?= Module::t('view_index_yes'); ?></label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" ng-checked="data.use_draft == 0" id="create-as-draft-no" />
            <label class="form-check-label" ng-click="data.use_draft = 0; data.from_draft_id = 0" for="create-as-draft-no"><?= Module::t('view_index_no'); ?></label>
        </div>
    </div>
    <div class="form-group" ng-show="data.use_draft==1">
        <label class="input__label"><?= Module::t('view_index_page_select_draft'); ?></label>
        <select class="form-control" ng-model="data.from_draft_id" convert-to-number>
            <option value="0"><?= \luya\cms\admin\Module::t('view_index_create_page_please_choose'); ?></option>
            <option value="">-----</option>
            <option ng-repeat="draft in drafts" value="{{draft.id}}">{{draft.title}}</option>
        </select>
    </div>
    <div class="form-group" ng-show="data.use_draft==0">
        <label class="input__label"><?= Module::t('view_index_page_layout'); ?></label>
        <select class="form-control" ng-model="data.layout_id" convert-to-number>
            <option value="0"><?= \luya\cms\admin\Module::t('view_index_create_page_please_choose'); ?></option>
            <option value="">-----</option>
            <option ng-repeat="item in layouts" value="{{item.id}}">{{item.name}}</option>
        </select>
    </div>
    <button type="button" class="btn btn-success" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>

<!-- CREATE MODULE FORM -->
<script type="text/ng-template" id="createformmodule.html">
    <zaa-select model="data.module_name" label="<?= Module::t('view_index_module_select'); ?>" options="modules" />
    <button type="button" class="btn btn-save btn-icon" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>

<!-- CREATE REDIRECT FORM -->
<script type="text/ng-template" id="createformredirect.html">
<div>
    <div class="form-group form-side-by-side">
        <div class="form-side form-side-label">
            <label><?= \luya\admin\Module::t('view_index_redirect_type'); ?></label>
        </div>
        <div class="form-side">
            <input type="radio" ng-model="data.redirect_type" ng-value="1" id="redirect_internal2">
            <label for="redirect_internal2" ng-click="data.redirect_type = 1"><?= \luya\admin\Module::t('view_index_redirect_internal'); ?></label>

            <input type="radio" ng-model="data.redirect_type" ng-value="2" id="redirect_external3">
            <label for="redirect_external3" ng-click="data.redirect_type = 2"><?= \luya\admin\Module::t('view_index_redirect_external'); ?></label>
        </div>
    </div>
    <div class="form-group form-side-by-side">
        <div class="form-side form-side-label"></div>
        <div class="form-side">
            <div ng-switch on="data.redirect_type">
                <div ng-switch-when="1">
                    <p><?= \luya\admin\Module::t('view_index_redirect_internal_select'); ?></p>
                    <menu-dropdown class="menu-dropdown" nav-id="data.redirect_type_value" />
                </div>
                <div ng-switch-when="2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons">link</i></div>
                            <input type="text" class="form-control" ng-model="data.redirect_type_value" placeholder="http://">
                        </div>
                        <small class="form-text text-muted"><?= \luya\admin\Module::t('view_index_redirect_external_link_help'); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-save btn-icon" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>

<!-- CREATE DRAFT FORM -->
<script type="text/ng-template" id="createformdraft.html">
    <button type="button" class="btn btn-save btn-icon" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>

<!-- PAGE UPDATE FORM -->
<script type="text/ng-template" id="updateformpage.html">
<div class="form-group form-side-by-side" ng-show="isEditAvailable()">
	<div class="form-side form-side-label">
    	<label><?= Module::t('view_index_page_version_chooser'); ?></label>
    </div>
	<div class="form-side">
		<select class="form-control" ng-model="data.nav_item_type_id" ng-options="version.id as version.version_alias for version in parent.typeData" ng-change="typeDataCopy.nav_item_type_id=parent.itemCopy.nav_item_type_id" />
	</div>
</div>
</script>

<!-- UPDATE MODULE FORM -->
<script type="text/ng-template" id="updateformmodule.html">
    <zaa-select model="data.module_name" label="<?= Module::t('view_index_module_select'); ?>" options="modules" />
</script>
