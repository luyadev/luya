
<script type="text/ng-template" id="createform.html">
    <form ng-switch on="data.nav_item_type">
        

        <div class="row">
            <div class="input input--radios col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_add_type'); ?></label>
                <div class="input__field-wrapper">
                    <input type="radio" ng-checked="data.nav_item_type == 1"><label ng-click="data.nav_item_type = 1"><?= \cmsadmin\Module::t('view_index_type_page'); ?></label><br />
                    <input type="radio" ng-checked="data.nav_item_type == 2"><label ng-click="data.nav_item_type = 2; data.is_draft = 0"><?= \cmsadmin\Module::t('view_index_type_module'); ?></label><br />
                    <input type="radio" ng-checked="data.nav_item_type == 3"><label ng-click="data.nav_item_type = 3; data.is_draft = 0"><?= \cmsadmin\Module::t('view_index_type_redirect'); ?></label><br />
                </div>
            </div>
        </div>

<hr style="margin:50px 0px; background-color:#F0F0F0; color:#F0F0F0; height:1px; border:0px;" />

        <div class="row" ng-show="data.nav_item_type == 1 && !data.isInline">
            <div class="input input--text col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_as_draft'); ?></label>
                <div class="input__field-wrapper">
                    <?= \cmsadmin\Module::t('view_index_as_draft_help'); ?><br />
                    <input type="radio" ng-checked="data.is_draft == 0"><label ng-click="data.is_draft = 0"><?= \cmsadmin\Module::t('view_index_no'); ?></label><br />
                    <input type="radio" ng-checked="data.is_draft == 1"><label ng-click="data.is_draft = 1"><?= \cmsadmin\Module::t('view_index_yes'); ?></label><br />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="input input--text col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_title'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.title" ng-change="aliasSuggestion()" focus-me="true" />
                </div>
            </div>
        <div class="row">
        </div>    
            <div class="input input--text col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_alias'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.alias" />
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0">
            <div class="input input--text col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_meta_description'); ?></label>
                <div class="input__field-wrapper">
                    <textarea class="input__field validate" ng-model="data.description"></textarea>
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0" ng-hide="data.isInline || navcontainer.length == 1">
            <div class="input input--select col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_nav_container'); ?></label>
                <div class="input__field-wrapper">
                    <select class="input__field browser-default" ng-model="data.nav_container_id" ng-options="item.id as item.name for item in navcontainers"></select>
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0 && !data.isInline">
            <div class="input input--select col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_parent_page'); ?></label>
                <div class="input__field-wrapper">
                    <select class="input__field browser-default" ng-model="data.parent_nav_id">
                        <option value="0"><?= \cmsadmin\Module::t('view_index_page_parent_root'); ?></option>
                        <option ng-repeat="nav in navitems" value="{{nav.id}}">{{nav.title}}</option>
                    </select>
                </div>
            </div>
        </div>
        
<hr style="margin:50px 0px; background-color:#F0F0F0; color:#F0F0F0; height:1px; border:0px;" />

        <div ng-switch-when="1">
            <create-form-page data="data"></create-form-page>
        </div>

        <div ng-switch-when="2">
            <create-form-module data="data"></create-form-module>
        </div>

        <div ng-switch-when="3">
            <create-form-redirect data="data"></create-form-redirect>
        </div>

        <!-- SUCCESS -->
        <div ng-show="success">
            <div class="alert alert--success">
                <i class="material-icons">check</i>
                <p><?= \cmsadmin\Module::t('view_index_page_success'); ?></p>
            </div>
        </div>
        <!-- /SUCCESS -->

        <!-- ERROR -->
        <div class="alert alert--danger" ng-show="error.length != 0">
            <i class="material-icons">error</i>
            <ul>
                <li ng-repeat="err in error">{{ err[0] }}</li>
            </ul>
        </div>
        <!-- /ERROR -->

    </form>
</script>

<!-- CREATE PAGE FORM -->
<script type="text/ng-template" id="createformpage.html">
        <div class="row" ng-show="!data.isInline">
            <div class="input input--text col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_use_draft'); ?></label>
                <div class="input__field-wrapper">
                    <input type="radio" ng-checked="data.use_draft == 0"><label ng-click="data.use_draft = 0; data.from_draft_id = 0"><?= \cmsadmin\Module::t('view_index_no'); ?></label><br />
                    <input type="radio" ng-checked="data.use_draft == 1"><label ng-click="data.use_draft = 1; data.layout_id = 0"><?= \cmsadmin\Module::t('view_index_yes'); ?></label><br />
                </div>
            </div>
        </div>

    <div class="row"ng-show="data.use_draft==1">
        <div class="input input--select col s12">
            <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_select_draft'); ?></label>
            <div class="input__field-wrapper">
                <select class="input__field browser-default" ng-model="data.from_draft_id" ng-options="draft.id as draft.title for draft in drafts"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input input--select col s12"  ng-show="data.use_draft==0">
            <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_layout'); ?></label>
            <div class="input__field-wrapper">
                <select class="input__field browser-default" ng-model="data.layout_id" ng-options="lts.id as lts.name for lts in layouts"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()"><?= \cmsadmin\Module::t('view_index_page_btn_save'); ?></button>
        </div>
    </div>
</script>
<!-- /CREATE PAGE FORM -->

<!-- CREATE MODULE FORM -->
<script type="text/ng-template" id="createformmodule.html">
    <div class="row">
        <div class="input input--text col s12">
            <label class="input__label"><?= \cmsadmin\Module::t('view_index_module_select'); ?></label>
            <div class="input__field-wrapper">
                <input name="text" type="text" class="input__field" ng-model="data.module_name" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()"><?= \cmsadmin\Module::t('view_index_page_btn_save'); ?></button>
        </div>
    </div>
</script>
<!-- /CREATE MODULE FORM -->

<!-- CREATE MODULE FORM -->
<script type="text/ng-template" id="createformredirect.html">
    <div class="row">
        <div class="input input--radios col s12">
            <label class="input__label"><?= \cmsadmin\Module::t('view_index_redirect_type'); ?></label>
            <div class="input__field-wrapper">
                <input type="radio" ng-model="data.redirect_type" value="1"><label ng-click="data.redirect_type = 1"><?= \cmsadmin\Module::t('view_index_redirect_internal'); ?></label> <br />
                <input type="radio" ng-model="data.redirect_type" value="2"><label ng-click="data.redirect_type = 2"><?= \cmsadmin\Module::t('view_index_redirect_external'); ?></label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12" ng-show="data.redirect_type==1">
            <p><?= \cmsadmin\Module::t('view_index_redirect_internal_select'); ?></p>
            <menu-dropdown class="menu-dropdown" nav-id="data.redirect_type_value" />
        </div>

        <div class="col s12" ng-show="data.redirect_type==2">

            <div class="input input--text col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_redirect_external_link'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.redirect_type_value" placeholder="http://" />
                    <small><?= \cmsadmin\Module::t('view_index_redirect_external_link_help'); ?></small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()"><?= \cmsadmin\Module::t('view_index_page_btn_save'); ?></button>
        </div>
    </div>
</script>
<!-- /CREATE MODULE FORM -->

<!-- CREATE DRAFT FORM -->
<script type="text/ng-template" id="createformdraft.html">
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()"><?= \cmsadmin\Module::t('view_index_page_btn_save'); ?></button>
        </div>
    </div>
</script>
<!-- /CREATE DRAF FORM -->

<!-- treeview item -->
<script type="text/ng-template" id="reverse.html">

    <div data-drag="true" jqyoui-draggable data-jqyoui-options="{revert: true, delay: 200, scroll : false, handle : '.treeview__link--draggable'}" ng-model="data">

        <div class="treeview__drop" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onBeforeDrop()', multiple : true}">
        </div>
        <a class="treeview__button treeview__link" title="id={{data.id}}" alt="id={{data.id}}" ng-class="{'treeview__link--active' : isCurrentElement(data.id), 'treeview__link--is-online' : data.is_offline == '0', 'treeview__link--is-hidden' : data.is_hidden == '1', 'treeview__link--draggable' : showDrag, 'treeview__link--hidden' : data.is_hidden == '1'}" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__link--hover' }" jqyoui-droppable="{onDrop: 'onChildDrop()', multiple : true}">
            <div class="treeview__icon-holder">

                <i class="material-icons treeview__toggler" ng-click="toggleItem(data)" ng-hide="(menuData.items|menuparentfilter:catitem.id:data.id).length == 0" ng-class="{'treeview__toggler--subnav-closed': data.toggle_open!=1}">arrow_drop_down</i>

            </div>

            <span ng-click="!showDrag && go(data)">
                {{data.title}}
            </span>

            <div class="treeview__info-icons">
                <i ng-show="data.is_home==1" class="material-icons treeview__text-icon">home</i>
            </div>
        </a>

        <ul class="treeview__list" role="menu" ng-show="data.toggle_open==1">
            <li class="treeview__item" role="menuitem" ng-repeat="data in menuData.items | menuparentfilter:catitem.id:data.id" ng-include="'reverse.html'"></li>
        </ul>


        <div class="treeview__drop" ng-show="$last" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onAfterDrop()', multiple : true}">
        </div>

    </div>

</script>
<!-- /treeview item -->

<!-- /SCRIPT TEMPLATES -->

<!-- SIDEBAR -->
<div ng-controller="CmsLiveEdit" style="height: 100%;">
    <div class="luya-container__sidebar sidebar" ng-class="{ 'luya-container__sidebar--liveedit-active': display }">
        <div ng-controller="CmsMenuTreeController">

            <a class="sidebar__button sidebar__button--positive" ui-sref="custom.cmsadd">
                <div class="sidebar__icon-holder">
                    <i class="sidebar__icon material-icons">add</i>
                </div>
                <span class="sidebar__text"><?= \cmsadmin\Module::t('view_index_sidebar_new_page'); ?></span>
            </a>

            <a class="sidebar__button sidebar__button--grey" ui-sref="custom.cmsdraft">
                <div class="sidebar__icon-holder">
                    <i class="sidebar__icon material-icons">receipt</i>
                </div>
                <span class="sidebar__text"><?= \cmsadmin\Module::t('view_index_sidebar_drafts'); ?></span>
            </a>

            <div class="sidebar__button sidebar__button--grey sidebar__button--switch switch" ng-class="{ 'sidebar__button--active': showDrag }">
                <label>
                    <input type="checkbox" ng-model="liveEditStateToggler" ng-true-value="1" ng-false-value="0">
                    <span class="lever"></span>
                    <div class="sidebar__icon-holder">
                        <i class="sidebar__icon material-icons">live_tv</i>
                    </div>
                    <span class="sidebar__text">Auto Preview</span>
                </label>
            </div>

            <div class="sidebar__button sidebar__button--grey sidebar__button--switch switch" ng-class="{ 'sidebar__button--active': showDrag }">
                <label>
                    <input type="checkbox" ng-model="showDrag" ng-true-value="1" ng-false-value="0">
                    <span class="lever"></span>
                    <div class="sidebar__icon-holder">
                        <i class="sidebar__icon material-icons">mouse</i>
                    </div>
                    <span class="sidebar__text"><?= \cmsadmin\Module::t('view_index_sidebar_move'); ?></span>
                </label>
            </div>


            <div class="treeview" ng-repeat="catitem in menuData.containers" ng-class="{ 'treeview--drag-active' : showDrag }">
                <h5 class="sidebar__group-title sidebar__group-title--clickable" ng-click="toggleCat(catitem.id)"><i class="material-icons sidebar__group-title-icon" ng-class="{'sidebar__group-title-icon--closed': toggleIsHidden(catitem.id)}">arrow_drop_down</i> <span>{{catitem.name}}</span></h5>

                <div class="treeview__drop" ng-show="(menuData.items|menuparentfilter:catitem.id:0).length == 0 && !toggleIsHidden(catitem.id)" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{catitem.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onEmptyDrop()', multiple : true}"></div>

                <ul class="treeview__list" ng-hide="toggleIsHidden(catitem.id)">
                    <li class="treeview__item" ng-repeat="data in menuData.items | menuparentfilter:catitem.id:0" ng-include="'reverse.html'"></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /SIDEBAR -->

    <!-- MAIN -->
    <div id="rzLeft" class="luya-container__main" ng-class="{ 'luya-container__main--liveedit-active': display }">

        <div class="col s12">
            <div ui-view></div>
        </div>

    </div>
    <!-- /MAIN -->

    <div id="rzRight" resizer resizer-left="#rzLeft" resizer-cover="#rzCover" resizer-right="#rzRight" class="luya-container__liveedit" ng-class="{ 'luya-container__liveedit--active': display }">
    	<div style="height:100%; width:100%; background-color:rgba(255,255,255,0.5); position:absolute; display:none;" id="rzCover"></div>
    	<iframe  ng-src="{{ url | trustAsResourceUrl:display}}" frameborder="0" width="100%" height="100%" style="border:0px;"></iframe>
    </div>
</div>

