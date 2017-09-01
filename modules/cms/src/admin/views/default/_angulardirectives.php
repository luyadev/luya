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
                    <div class="form-check form-check-inline">
                      <label class="form-check-label" ng-click="data.is_draft = 0">
                        <input class="form-check-input" ng-checked="data.is_draft == 0" type="radio" name="inlineRadioOptions"> <?= Module::t('view_index_no'); ?>
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label" ng-click="data.is_draft = 1">
                        <input class="form-check-input" ng-checked="data.is_draft == 1" type="radio" name="inlineRadioOptions"> <?= Module::t('view_index_yes'); ?>
                      </label>
                    </div>
                </div>
                <div class="form-group">
                    <label><?= Module::t('view_index_page_title'); ?></label>
                    <input name="text" type="text" class="form-control" ng-model="data.title" ng-change="aliasSuggestion()" focus-me="true" />
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
                <div ng-show="success">
                    <div class="alert alert--success">
                        <i class="material-icons">check</i>
                        <p><?= Module::t('view_index_page_success'); ?></p>
                    </div>
                </div>
                <div class="alert alert--danger" ng-show="error.length != 0">
                    <i class="material-icons">error</i>
                    <ul>
                        <li ng-repeat="err in error">{{ err[0] }}</li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</script>

<!-- CREATE PAGE FORM -->
<script type="text/ng-template" id="createformpage.html">
    <div class="form-group" ng-show="!data.isInline">
        <label class="input__label"><?= Module::t('view_index_page_use_draft'); ?></label>
        <div class="form-check form-check-inline">
            <label class="form-check-label" ng-click="data.use_draft = 0; data.from_draft_id = 0">
              <input class="form-check-input" type="radio" ng-checked="data.use_draft == 0"><?= Module::t('view_index_no'); ?>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label" ng-click="data.use_draft = 1; data.layout_id = 0">
              <input class="form-check-input" type="radio" ng-checked="data.use_draft == 1"><?= Module::t('view_index_yes'); ?>
            </label>
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
    <button type="button" class="btn btn-success" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>

<!-- CREATE REDIRECT FORM -->
<script type="text/ng-template" id="createformredirect.html">
    <div class="form-check">
        <label class="form-check-label" ng-click="data.redirect_type = 1">
            <input class="form-check-input" type="radio" ng-model="data.redirect_type" ng-value="1"><?php echo \luya\admin\Module::t('view_index_redirect_internal'); ?>
        </label>
    </div>
    <div class="form-check">
        <label class="form-check-label" ng-click="data.redirect_type = 2">
            <input class="form-check-input" type="radio" ng-model="data.redirect_type" ng-value="2"><?php echo \luya\admin\Module::t('view_index_redirect_external'); ?>
        </label>
    </div>
    <div class="form-group" ng-show="data.redirect_type==1">
        <label><?php echo \luya\admin\Module::t('view_index_redirect_internal_select'); ?></label>
        <menu-dropdown class="menu-dropdown" nav-id="data.redirect_type_value" />
    </div>
    <div class="form-group" ng-show="data.redirect_type==2">
        <label><?php echo \luya\admin\Module::t('view_index_redirect_external_link'); ?></label>
        <input class="form-control" type="text" class="input__field" ng-model="data.redirect_type_value" placeholder="https://" />
        <small class="form-text text-muted"><?php echo \luya\admin\Module::t('view_index_redirect_external_link_help'); ?></small>
    </div>
    <button type="button" class="btn btn-success" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>

<!-- CREATE DRAFT FORM -->
<script type="text/ng-template" id="createformdraft.html">
    <button type="button" class="btn btn-success" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>

<!-- PAGE UPDATE FORM -->
<script type="text/ng-template" id="updateformpage.html">
    <div class="row" ng-show="isEditAvailable()">
        <div class="input input--select col s12">
            <label class="input__label"><?php echo Module::t('view_index_page_version_chooser'); ?></label>
            <div class="input__field-wrapper" ng-show="parent.typeData!==undefined">
                <select ng-model="data.nav_item_type_id" ng-options="version.id as version.version_alias for version in parent.typeData" ng-change="typeDataCopy.nav_item_type_id=parent.itemCopy.nav_item_type_id" />
            </div>
        </div>
    </div>
</script>

<!-- UPDATE MODULE FORM -->
<script type="text/ng-template" id="updateformmodule.html">
    <zaa-select model="data.module_name" label="<?= Module::t('view_index_module_select'); ?>" options="modules" />
</script>
