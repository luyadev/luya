<script type="text/ng-template" id="recursion.html">
<div class="accordion__header" ng-mouseenter="mouseEnter()" ng-click="toggleOpen()"><i class="material-icons">expand_more</i> {{placeholder.label}}</div>
<div class="accordion__body" ng-class="{ 'accordion__body--empty' : !placeholder.__nav_item_page_block_items.length }">
    
    <div class="page__drop">
        <div class="page__drop-zone" ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="0" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()'}">
        </div>
    </div>

    <div ng-show="!placeholder.__nav_item_page_block_items.length">
        <p class="accordion__empty-message"><?= \cmsadmin\Module::t('view_update_drop_blocks'); ?></p>
    </div>

    <div ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController">
        <div class="block" ng-class="{ 'block--edit' : edit , 'block--config' : config ,'block--is-hidden': block.is_hidden==1,'block--is-dirty' : !block.is_dirty && isEditable() && !block.is_container, 'block--is-container': block.is_container }" data-drag="true" jqyoui-draggable="{onStart : 'onStart', onStop : 'onStop'}" data-jqyoui-options="{snapTolerance : 40, handle : '.block__move', delay: 200, cursor:'move', cursorAt: { top: 0, left: 0 }, revert:true }" ng-model="block">
            <div class="block__toolbar">
                <div class="left">
                    <i class="block__move material-icons">open_with</i>
                    <div class="block__title" ng-bind-html="safe(block.full_name)" ng-click="toggleEdit()"></div>
                </div>
                <div class="right">
                    <i ng-click="toggleHidden()" class="material-icons block__toolbar__icon" ng-show="block.is_hidden==0">visibility</i>
                    <i ng-click="toggleHidden()" class="material-icons block__toolbar__icon" ng-show="block.is_hidden==1">visibility_off</i>
                    <i ng-show="isEditable()" class="material-icons block__toolbar__icon" ng-class="{ 'block__toolbar__icon--active' : edit }" ng-click="toggleEdit()" title="Edit">edit</i>
                    <i ng-show="isConfigable()" class="material-icons block__toolbar__icon" ng-class="{ 'block__toolbar__icon--active' : config }"ng-click="toggleConfig()" title="Confi">settings</i>
                    <i ng-show="!edit && !config" class="material-icons block__toolbar__icon" ng-click="removeBlock(block)">delete</i>
                    <i ng-show="edit || config" class="material-icons block__toolbar__icon" ng-click="toggleBlockSettings()">close</i>
                </div>
            </div>
            <div class="block__body cmsadmin-tags" ng-click="toggleEdit()" ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)"></div>
            <form class="block__edit">
                <div class="block__edit-content">
                    <div class="row" ng-repeat="field in block.vars">
                        <div class="block__help help help--is-right-aligned" ng-show="hasInfo(field.var)">
                            <div class="help__button">
                                <i class="help__icon material-icons">help_outline</i>
                            </div>
                            <div class="help__text" ng-bind="getInfo(field.var)"></div>
                        </div>
                        <zaa-injector dir="field.type" options="field.options" fieldid="{{field.id}}" fieldname="{{field.var}}" initvalue="{{field.initvalue}}" placeholder="{{field.placeholder}}" label="{{field.label}}" model="data[field.var]"></zaa-injector>
                    </div>
                </div>
                <div class="block__config-content">
                    <p class="block__config__text"><span class="block__config__text-section"><?= \cmsadmin\Module::t('view_update_configs'); ?></span></p>
                    <div class="row" ng-repeat="cfgField in block.cfgs">
                        <div class="block__help help help--is-right-aligned" ng-show="hasInfo(cfgField.var)">
                            <div class="help__button">
                                <i class="help__icon material-icons">help_outline</i>
                            </div>
                            <div class="help__text" ng-bind="getInfo(cfgField.var)"></div>
                        </div>
                        <zaa-injector dir="cfgField.type" placeholder="{{cfgField.placeholder}}" fieldid="{{cfgField.id}}" fieldname="{{cfgField.var}}" initvalue="{{cfgField.initvalue}}" options="cfgField.options" label="{{cfgField.label}}"  model="cfgdata[cfgField.var]"></zaa-injector>
                    </div>
                </div>
                <br />
                <div class="modal__footer">
                    <div class="row">
                        <div class="col s12">
                            <div class="right">
                            <button class="[ waves-effect waves-light ] btn btn--small red" ng-click="toggleBlockSettings()"><i class="material-icons left">cancel</i><?= \cmsadmin\Module::t('view_update_btn_cancel'); ?></button>
                                <button class="[ waves-effect waves-light ] btn btn--small" ng-click="save()"><i class="material-icons left">done</i><?= \cmsadmin\Module::t('view_update_btn_save'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <ul ng-show="block.__placeholders.length" class="accordion" >
                <li class="accordion__entry" ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'" ng-class="{ 'accordion__entry--open' : isOpen }"></li>
            </ul>
        </div>

        <div class="page__drop">
            <div class="page__drop-zone" ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="{{key+1}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()'}"></div>
        </div>

    </div>
</div>
</script>

<!-- UPDATE PAGE FORM -->
<script type="text/ng-template" id="updateformpage.html">
    <div class="row">
        <div class="input input--select col s12">
            <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_layout'); ?></label>
            <div class="input__field-wrapper">
                <select class="input__field browser-default" ng-model="data.layout_id" ng-options="lts.id as lts.name for lts in layouts"></select>
            </div>
        </div>
    </div>
</script>
<!-- /UPDATE PAGE FORM -->

<!-- UPDATE MODULE FORM -->
<script type="text/ng-template" id="updateformmodule.html">
    <div class="row">
        <div class="input input--text col s12">
            <label class="input__label"><?= \cmsadmin\Module::t('view_index_module_select'); ?></label>
            <div class="input__field-wrapper">
                <input name="text" type="text" class="input__field" ng-model="data.module_name" />
            </div>
        </div>
    </div>
</script>
<!-- /UPDATE MODULE FORM -->

<!-- UPDATE REDIRECT FORM -->
<script type="text/ng-template" id="updateformredirect.html">
    <div class="row">
        <div class="input input--radios col s12">
            <label class="input__label"><?= \cmsadmin\Module::t('view_index_redirect_type'); ?></label>
            <div class="input__field-wrapper">
                <input type="radio" ng-model="data.type" value="1"><label ng-click="data.type = 1"><?= \cmsadmin\Module::t('view_index_redirect_internal'); ?></label> <br />
                <input type="radio" ng-model="data.type" value="2"><label ng-click="data.type = 2"><?= \cmsadmin\Module::t('view_index_redirect_external'); ?></label>
            </div>
        </div>
    </div>

    <div class="row" ng-switch on="data.type">
        <div class="col s12" ng-switch-when="1">
            <p><?= \cmsadmin\Module::t('view_index_redirect_internal_select'); ?></p>
            <menu-dropdown class="menu-dropdown" nav-id="data.value" />
        </div>

        <div class="col s12" ng-switch-when="2">

            <div class="input input--text col s12">
                <label class="input__label"><?= \cmsadmin\Module::t('view_index_redirect_external_link'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.value" placeholder="http://" />
                    <small><?= \cmsadmin\Module::t('view_index_redirect_external_link_help'); ?></small>
                </div>
            </div>
        </div>
    </div>
</script>
<!-- /UPDATE REDIRECT FORM -->

<div ng-controller="NavController" ng-show="!isDeleted">

    <div class="cms">
        <div class="cms__pages">

            <div class="row">
                <div class="col s12">

                    <div class="toolbar [ grey lighten-3 ]">
                        <div class="row">
                            <div class="col s12">

                                <!-- LEFT TOOLBAR -->
                                <div class="left">
                                    <!-- CONFIG BUTTON -->
                                    <div class="toolbar__group" ng-show="propertiesData.length && navData.is_draft == 0">
                                        <a class="[ btn-flat btn--small ][ grey-text text-darken-2 ]" ng-click="togglePropMask()">
                                            <i class="material-icons cms__prop-toggle">settings</i>
                                        </a>
                                    </div>
                                    <!-- /CONFIG BUTTON -->

                                    <!-- DELETE BUTTON -->
                                    <div class="toolbar__group">
                                        <a ng-click="trash()" class="[ waves-effect waves-blue ][ btn-flat btn--small ][ grey-text text-darken-2 ]"><i class="material-icons">delete</i></a>
                                    </div>
                                    <!-- /DELETE BUTTON -->

                                    <!-- PLACEHOLDER TOGGLE -->
                                    <div class="toolbar__group">
                                        <div class="switch">
                                            <label>
                                                <span ng-if="placeholderState"><?= \cmsadmin\Module::t('view_update_holder_state_on'); ?></span>
                                                <span ng-if="!placeholderState"><?= \cmsadmin\Module::t('view_update_holder_state_off'); ?></span>
                                                <input type="checkbox" ng-model="placeholderState" ng-true-value="1" ng-false-value="0">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /PLACEHOLDER TOGGLE -->

                                </div> <!-- /LEFT TOOLBAR -->

                                <!-- RIGHT TOOLBAR -->
                                <div class="right">

                                
                                    <div class="toolbar__group" ng-show="navData.is_draft == 1">
                                        <div class="toolbar__group">
                                            <div class="switch">
                                                <label>
                                                    <span><b><?= \cmsadmin\Module::t('view_update_is_draft_mode'); ?></b></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IS_HOME SWITCH -->
                                    <div class="toolbar__group" ng-show="navData.is_draft == 0">
                                        <div class="switch">
                                            <label title="Setzt diese Seite als Startseite.">
                                                <?= \cmsadmin\Module::t('view_update_is_homepage'); ?>
                                                <input type="checkbox" ng-model="navData.is_home" ng-true-value="1" ng-false-value="0">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /IS_HOME SWITCH -->
                                    
                                    <!-- VISIBILITY SWITCH -->
                                    <div class="toolbar__group" ng-show="navData.is_draft == 0">
                                        <div class="switch switch--with-icons">
                                            <label title="Schaltet die Seite Sichtbar / Unsichtbar. Beeinflusst die Navigation.">
                                                <i class="switch__icon material-icons" ng-show="!navData.is_hidden">visibility</i>
                                                <i class="switch__icon material-icons" ng-show="navData.is_hidden">visibility_off</i>
                                                <input type="checkbox" ng-model="navData.is_hidden" ng-true-value="0" ng-false-value="1">
                                                <span class="lever switch__lever"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /VISIBILITY SWITCH -->
                                    
                                    <!-- OFFLINE SWITCH -->
                                    <div class="toolbar__group" ng-show="navData.is_draft == 0">
                                        <div class="switch switch--with-icons">
                                            <label title="Schaltet die Seite online / offline. Eine Seite die offline ist, kann nicht aufgerufen werden.">
                                                <i class="switch__icon material-icons green-text" ng-show="!navData.is_offline">cloud_queue</i>
                                                <i class="switch__icon material-icons red-text" ng-show="navData.is_offline">cloud_off</i>
                                                <input type="checkbox" ng-model="navData.is_offline" ng-true-value="0" ng-false-value="1">
                                                <span class="lever switch__lever"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /OFFLINE SWITCH -->

                                    <!-- LANGUAGE SWITCH -->
                                    <div class="toolbar__group langswitch" ng-show="navData.is_draft == 0">
                                        <a ng-repeat="lang in AdminLangService.data" ng-click="AdminLangService.toggleSelection(lang)" ng-class="{'langswitch__item--active' : AdminLangService.isInSelection(lang.short_code)}" class="langswitch__item [ waves-effect waves-blue ][ btn-flat btn--small btn--bold ] ng-binding ng-scope">
                                            <span class="flag flag--{{lang.short_code}}">
                                                <span class="flag__fallback">{{lang.name}}</span>
                                            </span>
                                        </a>
                                    </div>
                                    <!-- /LANGUAGE SWITCH -->

                                </div>
                                <!-- /RIGHT TOOLBAR -->

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row" ng-show="showPropForm">
                <div class="col s12">
                    <div class="card-panel">
                    <h5><?= \cmsadmin\Module::t('view_update_properties_title'); ?></h5>
                    <div ng-show="!hasValues" class="alert alert--info"><?= \cmsadmin\Module::t('view_update_no_properties_exists'); ?></div>
                        <div class="row" ng-repeat="prop in propertiesData">
                            <zaa-injector dir="prop.type" options="prop.option_json" fieldid="{{prop.var_name}}" fieldname="{{prop.var_name}}" initvalue="{{prop.default_value}}" label="{{prop.label}}" model="propValues[prop.id]"></zaa-injector>
                        </div>

                        <br />
                        <div class="modal__footer">
                            <div class="row">
                                <div class="input-field col s12">
                                    <div class="right">
                                        <button type="button" ng-click="togglePropMask()" class="btn red"><?= \cmsadmin\Module::t('btn_abort'); ?> <i class="material-icons left">cancel</i></button>
                                        <button type="button" ng-click="storePropValues()" class="btn" ng-show="hasValues"><?= \cmsadmin\Module::t('btn_refresh'); ?> <i class="material-icons right">check</i></button>
                                        <button type="button" ng-click="storePropValues()" class="btn" ng-show="!hasValues"><?= \cmsadmin\Module::t('btn_save'); ?> <i class="material-icons right">check</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s{{(12/AdminLangService.selection.length)}}" ng-repeat="lang in languagesData" ng-show="AdminLangService.isInSelection(lang.short_code)" ng-controller="NavItemController">
                    <!-- PAGE -->
                    <div class="page" ng-show="!isTranslated && navData.is_draft == 1">
                        <div class="alert alert--info"><?= \cmsadmin\Module::t('view_update_draft_no_lang_error'); ?></div>
                    </div>
                    <div class="alert alert--info" ng-show="!loaded">
                        <p><?= \cmsadmin\Module::t('view_index_language_loading'); ?></p>
                    </div>
                    <div class="page" ng-show="!isTranslated && navData.is_draft == 0 && loaded">
                        <div class="row">
                            <div class="col s12">
                                <div class="alert alert--info">
                                    <?= \cmsadmin\Module::t('view_update_no_translations'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12" ng-controller="CopyPageController">
                                <div class="card-panel">
                                    <h5><?= \cmsadmin\Module::t('view_index_add_page_from_language'); ?></h5>
                                    <p><?= \cmsadmin\Module::t('view_index_add_page_from_language_info'); ?></p>
                                    <p><button ng-click="loadItems()" ng-show="!isOpen" class="btn">Ja</button></p>
                                    <div ng-show="isOpen">
                                        <hr />
                                        <ul>
                                            <li ng-repeat="item in items"><input type="radio" ng-model="selection" value="{{item.id}}"><label ng-click="select(item);">{{item.lang.name}} <i>&laquo; {{ item.title }} &raquo;</i></label></li>
                                        </ul>
                                        <div ng-show="itemSelection">
                                            <div class="row">
                                                <div class="input input--text col s12">
                                                    <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_title'); ?></label>
                                                    <div class="input__field-wrapper">
                                                        <input name="text" type="text" class="input__field" ng-change="aliasSuggestion()" ng-model="itemSelection.title" />
                                                    </div>
                                                </div>
                                            <div class="row">
                                            </div>    
                                                <div class="input input--text col s12">
                                                    <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_alias'); ?></label>
                                                    <div class="input__field-wrapper">
                                                        <input name="text" type="text" class="input__field" ng-model="itemSelection.alias" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button ng-click="save()" class="btn"><?= \cmsadmin\Module::t('view_index_page_btn_save'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12" ng-controller="CmsadminCreateInlineController">
                                <div class="card-panel">
                                    <h5><?= \cmsadmin\Module::t('view_index_add_page_empty'); ?></h5>
                                    <create-form data="data"></create-form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page {{AdminClassService.getClassSpace('onDragStart')}}" ng-show="isTranslated && loaded">
                        <!-- PAGE__HEADER -->
                        <div class="page__header">
                            <div class="row">
                                <div class="col s12">
                                    <h4>
                                        {{item.title}}
                                        <span ng-hide="settings">
                                            <i ng-click="toggleSettings()" class="material-icons right [ waves-effect waves-blue ]">mode_edit</i>
                                            <a ng-href="cms/preview/?itemId={{item.id}}" target="_blank" class="right">
                                                <i class="material-icons [ waves-effect waves-blue ]">open_in_new</i>
                                            </a>
                                        </span>
                                        <span ng-hide="!settings">
                                            <i ng-click="toggleSettings()" class="mdi-navigation-close right [ waves-effect waves-blue ]"></i>
                                        </span>
                                    </h4>
                                    <p>{{lang.name}}</p>
                                </div>
                            </div>
                        </div>
                        <!-- /PAGE__HEADER -->

                        <!-- PAGE__CONTENT--SETTINGS-->
                        <form class="page__content page__content--settings" ng-show="settings" ng-switch on="itemCopy.nav_item_type">

                            <div class="row">
                                <div class="input input--text col s12">
                                    <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_title'); ?></label>
                                    <div class="input__field-wrapper">
                                        <input type="text" class="input__field validate" ng-model="itemCopy.title" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input input--text col s12">
                                    <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_alias'); ?></label>
                                    <div class="input__field-wrapper">
                                        <input type="text" class="input__field validate" ng-model="itemCopy.alias" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input input--text col s12">
                                    <label class="input__label"><?= \cmsadmin\Module::t('view_index_page_meta_description'); ?></label>
                                    <div class="input__field-wrapper">
                                        <textarea class="input__field validate" ng-model="itemCopy.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input input--radios col s12">
                                    <label class="input__label"><?= \cmsadmin\Module::t('view_index_add_type'); ?></label>
                                    <div class="input__field-wrapper">
                                        <input type="radio" ng-model="itemCopy.nav_item_type" value="1"><label ng-click="itemCopy.nav_item_type = 1"><?= \cmsadmin\Module::t('view_index_type_page'); ?></label> <br />
                                        <input type="radio" ng-model="itemCopy.nav_item_type" value="2"><label ng-click="itemCopy.nav_item_type = 2"><?= \cmsadmin\Module::t('view_index_type_module'); ?></label> <br />
                                        <input type="radio" ng-model="itemCopy.nav_item_type" value="3"><label ng-click="itemCopy.nav_item_type = 3"><?= \cmsadmin\Module::t('view_index_type_redirect'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div ng-switch-when="1">
                                <update-form-page data="typeDataCopy"></update-form-page>
                            </div>

                            <div ng-switch-when="2">
                                <update-form-module data="typeDataCopy"></update-form-module>
                            </div>

                            <div ng-switch-when="3">
                                <update-form-redirect data="typeDataCopy"></update-form-redirect>
                            </div>

                            <br />
                            <div class="modal__footer">
                                <div class="row">
                                    <div class="col s12">
                                        <div class="right">
                                            <button class="btn waves-effect waves-light red" type="button" ng-click="toggleSettings()"><?= \cmsadmin\Module::t('btn_abort'); ?> <i class="material-icons left">cancel</i></button>
                                            <button class="btn waves-effect waves-light" type="button" ng-click="save(itemCopy, typeDataCopy)"><?= \cmsadmin\Module::t('btn_save'); ?> <i class="material-icons right">check</i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert--danger" ng-show="errors.length">
                                <ul>
                                    <li ng-repeat="err in errors">{{err.message}}</li>
                                </ul>
                            </div>
                            
                        </form>
                        <!-- /PAGE__CONTENT--SETTINGS -->

                        <!-- PAGE__CONTENT -->
                        <div class="page__content" ng-show="!settings" ng-switch on="item.nav_item_type">
                            <div class="row">
                                <div class="col s12 page__no-padding" ng-switch-when="1">
                                    <ul class="page__list" ng-show="container.nav_item_page.id">
                                        <li class="page__placeholder accordion__entry--open" ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'"></li>
                                    </ul>
                                </div>
                                <div class="col s12" ng-switch-when="2">
                                    <p><?= \cmsadmin\Module::t('view_update_page_is_module'); ?></p>
                                </div>
                                <div class="col s12" ng-switch-when="3">
                                    <div ng-switch on="typeData.type">
                                        <div ng-switch-when="1">
                                            <p><?= \cmsadmin\Module::t('view_update_page_is_redirect_internal'); ?></p>
                                        </div>
                                        <div ng-switch-when="2">
                                            <p><?= \cmsadmin\Module::t('view_update_page_is_redirect_external'); ?>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /PAGE__CONTENT -->
                    </div>
                    <!-- /PAGE -->
                </div>

            </div>
        </div>

        <div class="cms__sidebar">

            <div class="blockholder" ng-controller="DroppableBlocksController">
                <div class="col s12">
                    <div class="blockholder__search" ng-class="{'blockholder__search--active': searchQuery}">
                        <input class="blockholder__input" type="text" ng-model="searchQuery" value="" id="blockholderSearch" />
                        <label class="blockholder__icon blockholder__icon--search" for="blockholderSearch"><i class="material-icons">search</i></label>
                        <label class="blockholder__icon blockholder__icon--cancel" for="blockholderCancel">
                            <div ng-show="searchQuery.length > 0" ng-click="searchQuery=''"><i class="material-icons">close</i></div>
                        </label>
                    </div>
                    <div class="blockholder__group" ng-repeat="item in blocksData">
                        <b class="blockholder__group-title">{{item.group.name}}</b>
                        <div class="blockholder__block" ng-repeat="block in item.blocks | orderBy:'name' | filter:{name:searchQuery}" data-drag="true" jqyoui-draggable="{placeholder: 'keep', onStart : 'onStart', onStop : 'onStop'}" ng-model="block" data-jqyoui-options="{revert: false, refreshPositions : true, snapTolerance : 40, helper : 'clone', cursor:'move', cursorAt: { top: 0, left: 0 }}">
                            <span ng-bind-html="safe(block.full_name)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
