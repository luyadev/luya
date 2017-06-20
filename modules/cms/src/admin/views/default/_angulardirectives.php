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
    <div  class="card-block">
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
<div class="form-group">
    <label><?= Module::t('view_index_module_select'); ?></label>
    <select ng-model="data.module_name" class="form-control">
        <option value=""><?= \luya\cms\admin\Module::t('view_index_create_page_please_choose'); ?></option>
        <option value="">- - - - -</option>
        <option ng-repeat="item in modules" value="{{item.value}}">{{item.label}}</option>
    </select>
</div>
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
    <input class="form-control" type="text" class="input__field" ng-model="data.redirect_type_value" placeholder="http://" />
    <small class="form-text text-muted"><?php echo \luya\admin\Module::t('view_index_redirect_external_link_help'); ?></small>
</div>
<button type="button" class="btn btn-success" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>
<!-- CREATE DRAFT FORM -->
<script type="text/ng-template" id="createformdraft.html">
<button type="button" class="btn btn-success" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
</script>
<!-- treeview item -->
<script type="text/ng-template" id="reverse.html">
 <div data-drag="true" jqyoui-draggable data-jqyoui-options="{revert: true, delay: 200, scroll : false, handle : '.treeview-link--draggable'}" ng-model="data">
    <div class="treeview-drop" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview-drop--hover' }" jqyoui-droppable="{onDrop: 'onBeforeDrop()', multiple : true}">
    </div>
    <a ng-if="data.is_editable" class="treeview-button treeview-link" title="id={{data.id}}" alt="id={{data.id}}" ng-class="{'treeview-link--active' : isCurrentElement(data), 'treeview-link--is-online' : data.is_offline == '0', 'treeview-link--is-hidden' : data.is_hidden == '1', 'treeview-link--draggable' : showDrag, 'treeview-link--hidden' : data.is_hidden == '1'}" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview-link--hover' }" jqyoui-droppable="{onDrop: 'onChildDrop()', multiple : true}">
        <div class="treeview-icon-holder">
            <i class="material-icons treeview-toggler" ng-click="toggleItem(data)" ng-hide="(menuData.items|menuparentfilter:catitem.id:data.id).length == 0" ng-class="{'treeview-toggler--subnav-closed': data.toggle_open!=1}">arrow_drop_down</i>
        </div>

        <span ng-if="isLocked('cms_nav_item', data.id)" style="cursor: not-allowed;">
           {{data.title}} <small>(locked)</small>
        </span>
        <span ng-if="!isLocked('cms_nav_item', data.id)" ng-click="!showDrag && go(data)">
            {{data.title}}
        </span>

        <div class="treeview-info-icons">
            <i ng-show="data.is_home==1" class="material-icons treeview-text-icon">home</i>
        </div>
    </a>
    <a ng-if="!data.is_editable" class="treeview-button treeview-link" style="cursor: not-allowed;" ng-class="{'treeview-link--active' : isCurrentElement(data), 'treeview-link--is-online' : data.is_offline == '0', 'treeview-link--is-hidden' : data.is_hidden == '1', 'treeview-link--hidden' : data.is_hidden == '1'}">
        <div class="treeview-icon-holder">
            <i class="material-icons treeview-toggler" ng-click="toggleItem(data)" ng-hide="(menuData.items|menuparentfilter:catitem.id:data.id).length == 0" ng-class="{'treeview-toggler--subnav-closed': data.toggle_open!=1}">arrow_drop_down</i>
        </div>
        <span style="cursor: not-allowed;">{{data.title}}</span>
        <div class="treeview-info-icons">
            <i ng-show="data.is_home==1" class="material-icons treeview-text-icon">home</i>
        </div>
    </a>
    <ul class="treeview-list" role="menu" ng-if="data.toggle_open==1">
        <li class="treeview-item" role="menuitem" ng-repeat="data in menuData.items | menuparentfilter:catitem.id:data.id" ng-include="'reverse.html'"></li>
    </ul>
    <div class="treeview-drop" ng-show="$last" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview-drop--hover' }" jqyoui-droppable="{onDrop: 'onAfterDrop()', multiple : true}">
    </div>
</div>
</script>