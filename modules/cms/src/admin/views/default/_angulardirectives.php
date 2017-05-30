<?php
use luya\cms\admin\Module;
?>
<script type="text/ng-template" id="createform.html">
    <form ng-switch on="data.nav_item_type">
        <div class="row">
            <div class="input input--radios col s12">
                <label class="input__label"><?= Module::t('view_index_add_type'); ?></label>
                <div class="input__field-wrapper">
                    <input type="radio" ng-checked="data.nav_item_type == 1"><label ng-click="data.nav_item_type = 1"><?= Module::t('view_index_type_page'); ?></label><br />
                    <input type="radio" ng-checked="data.nav_item_type == 2"><label ng-click="data.nav_item_type = 2; data.is_draft = 0"><?= Module::t('view_index_type_module'); ?></label><br />
                    <input type="radio" ng-checked="data.nav_item_type == 3"><label ng-click="data.nav_item_type = 3; data.is_draft = 0"><?= Module::t('view_index_type_redirect'); ?></label><br />
                </div>
            </div>
        </div>

        <hr style="margin:10px 0px; background-color:#F0F0F0; color:#F0F0F0; height:1px; border:0px;" />

        <div class="row" ng-show="data.nav_item_type == 1 && !data.isInline">
            <div class="input input--text col s12">
                <label class="input__label"><?= Module::t('view_index_as_draft'); ?></label>
                <div class="input__field-wrapper">
                    <?= Module::t('view_index_as_draft_help'); ?><br />
                    <input type="radio" ng-checked="data.is_draft == 0"><label ng-click="data.is_draft = 0"><?= Module::t('view_index_no'); ?></label><br />
                    <input type="radio" ng-checked="data.is_draft == 1"><label ng-click="data.is_draft = 1"><?= Module::t('view_index_yes'); ?></label><br />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input input--text col s12">
                <label class="input__label"><?= Module::t('view_index_page_title'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.title" ng-change="aliasSuggestion()" focus-me="true" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input input--text col s12">
                <label class="input__label"><?= Module::t('view_index_page_alias'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.alias" />
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0">
            <div class="input input--text col s12">
                <label class="input__label"><?= Module::t('view_index_page_meta_description'); ?></label>
                <div class="input__field-wrapper">
                    <textarea class="input__field validate" ng-model="data.description"></textarea>
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0" ng-hide="data.isInline || navcontainer.length == 1 || data.parent_nav_id!=0">
            <div class="input input--select col s12">
                <label class="input__label"><?= Module::t('view_index_page_nav_container'); ?></label>
                <div class="input__field-wrapper">
                    <select class="input__field browser-default" ng-model="data.nav_container_id" ng-options="item.id as item.name for item in navcontainers"></select>
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0 && !data.isInline">
            <div class="input input--select col s12">
                <label class="input__label"><?= Module::t('view_index_page_parent_page'); ?></label>
                <div class="input__field-wrapper">
                    <input id="[checkbox-id]" ng-model="data.parent_nav_id" value="0" ng-true-value="0" type="checkbox"/>
                    <label for="[checkbox-id]"><?= Module::t('view_index_page_parent_root'); ?></label>
                    <menu-dropdown class="menu-dropdown" nav-id="data.parent_nav_id" />
                </div>
            </div>
        </div>

        <hr style="margin:10px 0px; background-color:#F0F0F0; color:#F0F0F0; height:1px; border:0px;" />

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
</script>

<!-- CREATE PAGE FORM -->
<script type="text/ng-template" id="createformpage.html">
        <div class="row" ng-show="!data.isInline">
            <div class="input input--text col s12"> 
                <label class="input__label"><?= Module::t('view_index_page_use_draft'); ?></label>
                <div class="input__field-wrapper">
                    <input type="radio" ng-checked="data.use_draft == 0"><label ng-click="data.use_draft = 0; data.from_draft_id = 0"><?= Module::t('view_index_no'); ?></label><br />
                    <input type="radio" ng-checked="data.use_draft == 1"><label ng-click="data.use_draft = 1; data.layout_id = 0"><?= Module::t('view_index_yes'); ?></label><br />
                </div>
            </div>
        </div>

    <div class="row"ng-show="data.use_draft==1">
        <div class="input input--select col s12">
            <label class="input__label"><?= Module::t('view_index_page_select_draft'); ?></label>
            <div class="input__field-wrapper">
                <select class="input__field browser-default" ng-model="data.from_draft_id" convert-to-number>
                    <option value="0"><?= \luya\cms\admin\Module::t('view_index_create_page_please_choose'); ?></option>
                    <option value="">-----</option>
                    <option ng-repeat="draft in drafts" value="{{draft.id}}">{{draft.title}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input input--select col s12"  ng-show="data.use_draft==0">
            <label class="input__label"><?= Module::t('view_index_page_layout'); ?></label>
            <div class="input__field-wrapper">
                <select class="input__field" ng-model="data.layout_id" convert-to-number>
                    <option value="0"><?= \luya\cms\admin\Module::t('view_index_create_page_please_choose'); ?></option>
                    <option value="">-----</option>
                    <option ng-repeat="item in layouts" value="{{item.id}}">{{item.name}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
        </div>
    </div>
</script>
<!-- /CREATE PAGE FORM -->

<!-- CREATE MODULE FORM -->
<script type="text/ng-template" id="createformmodule.html">
    <div class="row">
        <div class="input input--text col s12">
            <label class="input__label"><?= Module::t('view_index_module_select'); ?></label>
            <div class="input__field-wrapper">
                <select ng-model="data.module_name" class="input__field">
                    <option value=""><?= \luya\cms\admin\Module::t('view_index_create_page_please_choose'); ?></option>
                    <option value="">- - - - -</option>
                    <option ng-repeat="item in modules" value="{{item.value}}">{{item.label}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
        </div>
    </div>
</script>
<!-- /CREATE MODULE FORM -->

<!-- CREATE MODULE FORM -->
<script type="text/ng-template" id="createformredirect.html">
    <div class="row">
        <div class="input input--radios col s12">
            <label class="input__label"><?php echo \luya\admin\Module::t('view_index_redirect_type'); ?></label>
            <div class="input__field-wrapper">
                <input type="radio" ng-model="data.redirect_type" ng-value="1"><label ng-click="data.redirect_type = 1"><?php echo \luya\admin\Module::t('view_index_redirect_internal'); ?></label> <br />
                <input type="radio" ng-model="data.redirect_type" ng-value="2"><label ng-click="data.redirect_type = 2"><?php echo \luya\admin\Module::t('view_index_redirect_external'); ?></label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12" ng-show="data.redirect_type==1">
            <p><?php echo \luya\admin\Module::t('view_index_redirect_internal_select'); ?></p>
            <menu-dropdown class="menu-dropdown" nav-id="data.redirect_type_value" />
        </div>

        <div class="col s12" ng-show="data.redirect_type==2">

            <div class="input input--text col s12">
                <label class="input__label"><?php echo \luya\admin\Module::t('view_index_redirect_external_link'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.redirect_type_value" placeholder="http://" />
                    <small><?php echo \luya\admin\Module::t('view_index_redirect_external_link_help'); ?></small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
        </div>
    </div>
</script>
<!-- /CREATE MODULE FORM -->

<!-- CREATE DRAFT FORM -->
<script type="text/ng-template" id="createformdraft.html">
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()"><?= Module::t('view_index_page_btn_save'); ?></button>
        </div>
    </div>
</script>
<!-- /CREATE DRAF FORM -->

<!-- treeview item -->
<script type="text/ng-template" id="reverse.html">

    <div data-drag="true" jqyoui-draggable data-jqyoui-options="{revert: true, delay: 200, scroll : false, handle : '.treeview__link--draggable'}" ng-model="data">

        <div class="treeview__drop" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onBeforeDrop()', multiple : true}">
        </div>
        <a ng-if="data.is_editable" class="treeview__button treeview__link" title="id={{data.id}}" alt="id={{data.id}}" ng-class="{'treeview__link--active' : isCurrentElement(data), 'treeview__link--is-online' : data.is_offline == '0', 'treeview__link--is-hidden' : data.is_hidden == '1', 'treeview__link--draggable' : showDrag, 'treeview__link--hidden' : data.is_hidden == '1'}" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__link--hover' }" jqyoui-droppable="{onDrop: 'onChildDrop()', multiple : true}">
            <div class="treeview__icon-holder">

                <i class="material-icons treeview__toggler" ng-click="toggleItem(data)" ng-hide="(menuData.items|menuparentfilter:catitem.id:data.id).length == 0" ng-class="{'treeview__toggler--subnav-closed': data.toggle_open!=1}">arrow_drop_down</i>

            </div>

            <span ng-if="isLocked('cms_nav_item', data.id)" style="cursor: not-allowed;">
               {{data.title}} <small>(locked)</small>
            </span>
            <span ng-if="!isLocked('cms_nav_item', data.id)" ng-click="!showDrag && go(data)">
                {{data.title}}
            </span>

            <div class="treeview__info-icons">
                <i ng-show="data.is_home==1" class="material-icons treeview__text-icon">home</i>
            </div>
        </a>

        <a ng-if="!data.is_editable" class="treeview__button treeview__link" style="cursor: not-allowed;" ng-class="{'treeview__link--active' : isCurrentElement(data), 'treeview__link--is-online' : data.is_offline == '0', 'treeview__link--is-hidden' : data.is_hidden == '1', 'treeview__link--hidden' : data.is_hidden == '1'}">
            <div class="treeview__icon-holder">

                <i class="material-icons treeview__toggler" ng-click="toggleItem(data)" ng-hide="(menuData.items|menuparentfilter:catitem.id:data.id).length == 0" ng-class="{'treeview__toggler--subnav-closed': data.toggle_open!=1}">arrow_drop_down</i>

            </div>
            <span style="cursor: not-allowed;">{{data.title}}</span>
            <div class="treeview__info-icons">
                <i ng-show="data.is_home==1" class="material-icons treeview__text-icon">home</i>
            </div>
        </a>

        <ul class="treeview__list" role="menu" ng-if="data.toggle_open==1">
            <li class="treeview__item" role="menuitem" ng-repeat="data in menuData.items | menuparentfilter:catitem.id:data.id" ng-include="'reverse.html'"></li>
        </ul>


        <div class="treeview__drop" ng-show="$last" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onAfterDrop()', multiple : true}">
        </div>

    </div>

</script>
<!-- /treeview item -->

<!-- /SCRIPT TEMPLATES -->