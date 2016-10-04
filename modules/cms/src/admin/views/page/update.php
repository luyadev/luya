<?php
use luya\cms\admin\Module;

?>
<script type="text/ng-template" id="recursion.html">
<div class="accordion__header" ng-mouseenter="mouseEnter()" ng-click="toggleOpen()"><i class="material-icons">expand_more</i> {{placeholder.label}}</div>
<div class="accordion__body" ng-class="{ 'accordion__body--empty' : !placeholder.__nav_item_page_block_items.length }">
    <div class="page__drop">
        <div class="page__drop-zone" ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="0" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()'}">
        </div>
    </div>

    <div ng-show="!placeholder.__nav_item_page_block_items.length">
        <p class="accordion__empty-message"><?php echo Module::t('view_update_drop_blocks'); ?></p>
    </div>

    <div ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController">
        <div class="block clearfix" ng-class="{ 'block--edit' : edit , 'block--config' : config ,'block--is-hidden': block.is_hidden==1,'block--is-dirty' : !block.is_dirty && isEditable() && !block.is_container, 'block--is-container': block.is_container, 'block--first': $first, 'block--last': $last }" data-drag="true" jqyoui-draggable="{placeholder: 'keep', onStart : 'onStart', onStop : 'onStop'}" data-jqyoui-options="{revert: true, refreshPositions : true, snapTolerance : 40, handle : '.block__move', delay: 200, cursor:'move', cursorAt: { top: 0, left: 0 } }" ng-model="block">
            <div class="block__toolbar">
                <div class="left">
                    <i class="block__move material-icons">open_with</i>
                    <div class="block__title" ng-bind-html="safe(block.full_name)" ng-click="toggleEdit()"></div>
                </div>
                <div class="right">
                    <i ng-click="copyBlock()" alt="Copy" title="Copy" class="material-icons block__tollbar__icon">content_copy</i>
                    <i ng-click="toggleHidden()" alt="Visible" title="Visible" class="material-icons block__toolbar__icon" ng-show="block.is_hidden==0">visibility</i>
                    <i ng-click="toggleHidden()" alt="Invisible" title="Invisible" class="material-icons block__toolbar__icon" ng-show="block.is_hidden==1">visibility_off</i>
                    <i ng-show="isEditable()" alt="Edit" title="Edit" class="material-icons block__toolbar__icon" ng-class="{ 'block__toolbar__icon--active' : edit }" ng-click="toggleEdit()" title="Edit">edit</i>
                    <i ng-show="isConfigable()" alt="Config" title="Config" class="material-icons block__toolbar__icon" ng-class="{ 'block__toolbar__icon--active' : config }"ng-click="toggleConfig()" title="Confi">settings</i>
                    <i ng-show="!edit && !config" alt="Delete" title="Delete" class="material-icons block__toolbar__icon" ng-click="removeBlock(block)">delete</i>
                    <i ng-show="edit || config" alt="Close" title="Close" class="material-icons block__toolbar__icon" ng-click="toggleBlockSettings()">close</i>
                </div>
            </div>
            <div class="block__body block-styles" ng-click="toggleEdit()" ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)"></div>
            <form class="block__edit" ng-if="edit || config">
                <div class="block__edit-content">
                    <div class="row" ng-repeat="field in block.vars">
                        <div class="block__help help help--is-right-aligned" ng-if="hasInfo(field.var)">
                            <div class="help__button">
                                <i class="help__icon material-icons">help_outline</i>
                            </div>
                            <div class="help__text" ng-bind="getInfo(field.var)"></div>
                        </div>
                        <zaa-injector dir="field.type" options="field.options" fieldid="{{field.id}}" fieldname="{{field.var}}" initvalue="{{field.initvalue}}" placeholder="{{field.placeholder}}" label="{{field.label}}" model="data[field.var]"></zaa-injector>
                    </div>
                </div>
                <div class="block__config-content">
                    <p class="block__config__text"><span class="block__config__text-section"><?php echo Module::t('view_update_configs'); ?></span></p>
                    <div class="row" ng-repeat="cfgField in block.cfgs">
                        <div class="block__help help help--is-right-aligned" ng-if="hasInfo(cfgField.var)">
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
                            <button class="[ waves-effect waves-light ] btn btn--small red" ng-click="toggleBlockSettings()"><i class="material-icons left">cancel</i><?php echo Module::t('view_update_btn_cancel'); ?></button>
                                <button class="[ waves-effect waves-light ] btn btn--small" ng-click="save()"><i class="material-icons left">done</i><?php echo Module::t('view_update_btn_save'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <ul ng-if="block.__placeholders.length" class="accordion" >
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
    <div class="row" ng-show="isEditAvailable()">
        <div class="input input--select col s12">
            <label class="input__label"><?php echo Module::t('view_index_page_version_chooser'); ?></label>
            <div class="input__field-wrapper" ng-show="parent.typeData!==undefined">
                <select ng-model="data.nav_item_type_id" ng-options="version.id as version.version_alias for version in parent.typeData" ng-change="typeDataCopy.nav_item_type_id=parent.itemCopy.nav_item_type_id" />
            </div>
        </div>
    </div>
</script>
<!-- /UPDATE PAGE FORM -->

<!-- UPDATE MODULE FORM -->
<script type="text/ng-template" id="updateformmodule.html">
    <div class="row">
        <div class="input input--text col s12">
            <label class="input__label"><?php echo Module::t('view_index_module_select'); ?></label>
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
            <label class="input__label"><?php echo Module::t('view_index_redirect_type'); ?></label>
            <div class="input__field-wrapper">
                <input type="radio" ng-model="data.type" value="1"><label ng-click="data.type = 1"><?php echo Module::t('view_index_redirect_internal'); ?></label> <br />
                <input type="radio" ng-model="data.type" value="2"><label ng-click="data.type = 2"><?php echo Module::t('view_index_redirect_external'); ?></label>
            </div>
        </div>
    </div>

    <div class="row" ng-switch on="data.type">
        <div class="col s12" ng-switch-when="1">
            <p><?php echo Module::t('view_index_redirect_internal_select'); ?></p>
            <menu-dropdown class="menu-dropdown" nav-id="data.value" />
        </div>

        <div class="col s12" ng-switch-when="2">

            <div class="input input--text col s12">
                <label class="input__label"><?php echo Module::t('view_index_redirect_external_link'); ?></label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.value" placeholder="http://" />
                    <small><?php echo Module::t('view_index_redirect_external_link_help'); ?></small>
                </div>
            </div>
        </div>
    </div>
</script>
<!-- /UPDATE REDIRECT FORM -->

<div ng-controller="NavController" ng-if="!isDeleted">

    <div class="cms">
        <div class="cms__pages">

            <div class="row">
                <div class="col s12">

                    <div class="toolbar [ grey lighten-3 ]">
                        <div class="row">
                            <div class="col s12">

                                <!-- LEFT TOOLBAR -->
                                <div class="toolbar__left">
                                    <!-- CONFIG BUTTON -->
                                    <div class="toolbar__group toolbar__group--settings" ng-show="propertiesData.length && navData.is_draft == 0">
                                        <a class="[ btn-flat btn--small ][ grey-text text-darken-2 ]" ng-click="togglePropMask()">
                                            <i class="material-icons cms__prop-toggle">settings</i>
                                        </a>
                                    </div>
                                    <!-- /CONFIG BUTTON -->
                                    
                                    <!-- ACTIONS -->
                                    <div class="toolbar__group">
                                        <a ng-click="showActions=!showActions" class="[ waves-effect waves-blue ][ btn-flat btn--small ][ grey-text text-darken-2 ]"><i class="material-icons">more_vert</i></a>
                                    </div>
                                    <!--  /ACTIONS -->

                                    <!-- DELETE BUTTON -->
                                    <div class="toolbar__group toolbar__group--delete">
                                        <a ng-click="trash()" class="[ waves-effect waves-blue ][ btn-flat btn--small ][ grey-text text-darken-2 ]"><i class="material-icons">delete</i></a>
                                    </div>
                                    <!-- /DELETE BUTTON -->

                                    <!-- PLACEHOLDER TOGGLE -->
                                    <div class="toolbar__group toolbar__group--placeholder-state">
                                        <div class="switch">
                                            <label>
                                                <span ng-if="placeholderState"><?php echo Module::t('view_update_holder_state_on'); ?></span>
                                                <span ng-if="!placeholderState"><?php echo Module::t('view_update_holder_state_off'); ?></span>
                                                <input type="checkbox" ng-model="placeholderState" ng-true-value="1" ng-false-value="0">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /PLACEHOLDER TOGGLE -->

                                </div> <!-- /LEFT TOOLBAR -->

                                <!-- RIGHT TOOLBAR -->
                                <div class="toolbar__right">

                                    <div class="toolbar__group" ng-show="isDraft == true">
                                        <div class="toolbar__group">
                                            <div class="switch">
                                                <label>
                                                    <span><b><?php echo Module::t('view_update_is_draft_mode'); ?></b></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IS_HOME SWITCH -->
                                    <div class="toolbar__group  toolbar__group--homepage" ng-show="isDraft == false">
                                        <div class="switch">
                                            <label title="Setzt diese Seite als Startseite." ng-if="!navData.is_home">
                                                <?php echo Module::t('view_update_is_homepage'); ?>
                                                <input type="checkbox" ng-model="navData.is_home" ng-true-value="1" ng-false-value="0">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                        <span class="grey-text text-darken-2" ng-if="navData.is_home">
                                            <i class="material-icons cms__prop-toggle green-text text-darken-1" style="vertical-align: middle; margin-right: 3px;">check_circle</i>
                                            <span  style="vertical-align: bottom"><?= Module::t('view_update_is_homepage'); ?></span>
                                        </span>
                                    </div>
                                    <!-- /IS_HOME SWITCH -->

                                    <!-- VISIBILITY SWITCH -->
                                    <div class="toolbar__group  toolbar__group--visibility" ng-show="isDraft == false">
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
                                    <div class="toolbar__group toolbar__group--online" ng-show="isDraft == false">
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
                                    <div class="toolbar__group toolbar__group--langswitch langswitch" ng-show="navData.is_draft == 0">
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
            
            <div class="row" ng-if="showActions">
                <div class="col s12">
                    <div class="card-panel">
                        <p><?= Module::t('page_update_actions_deepcopy_text'); ?></p>
                        <p><button type="button" class="btn" ng-click="createDeepPageCopy()"><?= Module::t('page_update_actions_deepcopy_btn'); ?></button></p>
                    </div>
                </div>
            </div>

            <div class="row" ng-if="showPropForm">
                <div class="col s12">
                    <div class="card-panel">
                    <h5><?php echo Module::t('view_update_properties_title'); ?></h5>
                    <div ng-show="!hasValues" class="alert alert--info"><?php echo Module::t('view_update_no_properties_exists'); ?></div>
                        <div class="row" ng-repeat="prop in propertiesData">
                            <div ng-if="prop.i18n">
                             <ul>
                              <li ng-repeat="lang in languagesData">
                               <zaa-injector dir="prop.type" options="prop.option_json" fieldid="{{prop.var_name}}" fieldname="{{prop.var_name}}" initvalue="{{prop.default_value}}" label="{{lang.name}}: {{prop.label}}" model="propValues[prop.id][lang.short_code]"></zaa-injector>
                              </li>
                             </ul>

                            </div>
                            <div ng-if="!prop.i18n">
                                <zaa-injector dir="prop.type" options="prop.option_json" fieldid="{{prop.var_name}}" fieldname="{{prop.var_name}}" initvalue="{{prop.default_value}}" label="{{prop.label}}" model="propValues[prop.id]"></zaa-injector>
                             </div>
                        </div>

                        <br />
                        <div class="modal__footer">
                            <div class="row">
                                <div class="input-field col s12">
                                    <div class="right">
                                        <button type="button" ng-click="togglePropMask()" class="btn red"><?php echo Module::t('btn_abort'); ?> <i class="material-icons left">cancel</i></button>
                                        <button type="button" ng-click="storePropValues()" class="btn" ng-show="hasValues"><?php echo Module::t('btn_refresh'); ?> <i class="material-icons right">check</i></button>
                                        <button type="button" ng-click="storePropValues()" class="btn" ng-show="!hasValues"><?php echo Module::t('btn_save'); ?> <i class="material-icons right">check</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s{{(12/AdminLangService.selection.length)}}" ng-repeat="lang in languagesData" ng-if="AdminLangService.isInSelection(lang.short_code)" ng-controller="NavItemController">
                    <!-- PAGE -->
                    <div class="page" ng-show="!isTranslated && navData.is_draft == 1">
                        <div class="alert alert--info"><?php echo Module::t('view_update_draft_no_lang_error'); ?></div>
                    </div>
                    <div class="alert alert--info" ng-show="!loaded">
                        <p><?php echo Module::t('view_index_language_loading'); ?></p>
                    </div>
                    <div class="page" ng-show="!isTranslated && navData.is_draft == 0 && loaded">
                        <div class="row">
                            <div class="col s12">
                                <div class="alert alert--info">
                                    <?php echo Module::t('view_update_no_translations'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12" ng-controller="CopyPageController">
                                <div class="card-panel">
                                    <h5><?php echo Module::t('view_index_add_page_from_language'); ?></h5>
                                    <p><?php echo Module::t('view_index_add_page_from_language_info'); ?></p>
                                    <p><button ng-click="loadItems()" ng-show="!isOpen" class="btn">Ja</button></p>
                                    <div ng-show="isOpen">
                                        <hr />
                                        <ul>
                                            <li ng-repeat="item in items"><input type="radio" ng-model="selection" value="{{item.id}}"><label ng-click="select(item);">{{item.lang.name}} <i>&laquo; {{ item.title }} &raquo;</i></label></li>
                                        </ul>
                                        <div ng-show="itemSelection">
                                            <div class="row">
                                                <div class="input input--text col s12">
                                                    <label class="input__label"><?php echo Module::t('view_index_page_title'); ?></label>
                                                    <div class="input__field-wrapper">
                                                        <input name="text" type="text" class="input__field" ng-change="aliasSuggestion()" ng-model="itemSelection.title" />
                                                    </div>
                                                </div>
                                            <div class="row">
                                            </div>
                                                <div class="input input--text col s12">
                                                    <label class="input__label"><?php echo Module::t('view_index_page_alias'); ?></label>
                                                    <div class="input__field-wrapper">
                                                        <input name="text" type="text" class="input__field" ng-model="itemSelection.alias" />
                                                    </div>
                                                </div>
                                            </div>

                                            <button ng-click="save()" class="btn"><?php echo Module::t('view_index_page_btn_save'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12" ng-controller="CmsadminCreateInlineController">
                                <div class="card-panel">
                                    <h5><?php echo Module::t('view_index_add_page_empty'); ?></h5>
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
                                            <a ng-href="{{homeUrl}}preview/{{item.id}}?version={{currentPageVersion}}" target="_blank" class="right" ng-show="!liveEditState">
                                                <i class="material-icons [ waves-effect waves-blue ]">open_in_new</i>
                                            </a>
                                            <a ng-click="openLiveUrl(item.id, currentPageVersion)" ng-show="liveEditState" class="right"><i class="material-icons [ waves-effect waves-blue ]">open_in_new</i></a>
                                        </span>
                                        <span ng-hide="!settings">
                                            <a ng-click="toggleSettings()"  class="right"><i class="material-icons">close</i></a>
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
                                    <label class="input__label"><?php echo Module::t('view_index_page_title'); ?></label>
                                    <div class="input__field-wrapper">
                                        <input type="text" class="input__field validate" ng-model="itemCopy.title" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input input--text col s12">
                                    <label class="input__label"><?php echo Module::t('view_index_page_alias'); ?></label>
                                    <div class="input__field-wrapper">
                                        <input type="text" class="input__field validate" ng-model="itemCopy.alias" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input input--text col s12">
                                    <label class="input__label"><?php echo Module::t('view_index_page_meta_description'); ?></label>
                                    <div class="input__field-wrapper">
                                        <textarea class="input__field validate" ng-model="itemCopy.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input input--text col s12">
                                    <label class="input__label"><?php echo Module::t('view_index_page_meta_keywords'); ?></label>
                                    <div class="input__field-wrapper">
                                        <textarea class="input__field validate" ng-model="itemCopy.keywords"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input input--radios col s12">
                                    <label class="input__label"><?php echo Module::t('view_index_add_type'); ?></label>
                                    <div class="input__field-wrapper">
                                        <input type="radio" ng-model="itemCopy.nav_item_type" value="1"><label ng-click="itemCopy.nav_item_type = 1"><?php echo Module::t('view_index_type_page'); ?></label> <br />
                                        <input type="radio" ng-model="itemCopy.nav_item_type" value="2"><label ng-click="itemCopy.nav_item_type = 2"><?php echo Module::t('view_index_type_module'); ?></label> <br />
                                        <input type="radio" ng-model="itemCopy.nav_item_type" value="3"><label ng-click="itemCopy.nav_item_type = 3"><?php echo Module::t('view_index_type_redirect'); ?></label>
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
                                            <button class="btn waves-effect waves-light red" type="button" ng-click="toggleSettings()"><?php echo Module::t('btn_abort'); ?> <i class="material-icons left">cancel</i></button>
                                            <button class="btn waves-effect waves-light" type="button" ng-click="save(itemCopy, typeDataCopy)"><?php echo Module::t('btn_save'); ?> <i class="material-icons right">check</i></button>
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
                        <div class="page__content" ng-if="!settings" ng-switch on="item.nav_item_type">
                            <div class="row">
                                <div class="col s12 page__no-padding" ng-switch-when="1">
                                    <!-- Versions -->
                                    <div class="page__versions" ng-controller="PageVersionsController" ng-init="createVersionModalState=true;">
                                        <span class="page__versions-label"><?= Module::t('versions_selector'); ?>: </span>
                                        <button class="page__version" ng-class="{'page__version--visible': currentPageVersion == versionItem.id, 'page__version--in-use': versionItem.id == item.nav_item_type_id}" ng-repeat="versionItem in typeData" ng-init="modalState=true" title="{{ versionItem.version_alias }}" ng-click="switchVersion(versionItem.id);">
                                            {{$index+1}}
                                            <div class="page__version-popup">
                                                <strong>{{ versionItem.version_alias}}</strong>
                                                <span class="page__version-popup-buttons">
                                                    <i class="material-icons" ng-click="toggleVersionEdit(versionItem.id);">edit</i>
                                                    <i ng-show="item.nav_item_type_id != versionItem.id" ng-click="toggleRemoveVersion(versionItem.id)" class="material-icons">delete</i></span>
                                                    <span class="page__version-popup-mouse-bridge"></span>
                                                </span>
                                            </div>
                                        </button>
                                        <button class="page__version page__version--add" ng-click="createVersionModalState=false">
                                            <i class="material-icons left">add</i>
                                        </button>
                                        <!-- Edit version modal -->
                                        <modal is-modal-hidden="editVersionModalState">
                                            <div class="modal__header modal__header--light modal__header--for-form">
                                                <div class="row">
                                                    <div class="col s12">
                                                        <h3><?= Module::t('version_edit_title'); ?></h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal__content">
                                                <div class="input input--text">
                                                    <label class="input__label" for="edit-version-modal-name"><?= Module::t('version_input_name'); ?></label>
                                                    <div class="input__field-wrapper">
                                                        <input class="input__field" id="edit-version-modal-name" name="edit-version-modal-name" type="text" ng-model="currentVersionInformation.version_alias" />
                                                    </div>
                                                </div>
                                                <div class="input input--select">
                                                    <label class="input__label" for="edit-version-modal-layout"><?= Module::t('version_input_layout'); ?></label>
                                                    <select class="input__field" id="edit-version-modal-layout" name="edit-version-modal-layout" ng-model="currentVersionInformation.layout_id" ng-options="lts.id as lts.name for lts in layoutsData"></select>
                                                </div>
                                            </div>

                                            <div class="modal__footer">
                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="right">
                                                            <button class="btn" type="submit" ng-click="changeVersionLayout(currentVersionInformation)">
                                                                <?php echo Module::t('button_update_version'); ?> <i class="material-icons right">check</i>
                                                            </button>
                                                            <button class="btn red" type="button" ng-click="closeEditModal()">
                                                                <i class="material-icons left">cancel</i> <?php echo \luya\admin\Module::t('button_abort'); ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </modal>
                                        <!-- /Edit version modal -->

                                        <!-- Add version modal -->
                                        <modal is-modal-hidden="createVersionModalState" ng-init="copyExistingVersion=true">
                                            <div class="modal__header modal__header--light modal__header--for-form">
                                                <div class="row">
                                                    <div class="col s12">
                                                        <h3><?= Module::t('version_create_title'); ?></h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal__content">

                                                <div class="input input--text">
                                                    <label class="input__label" for="create-version-modal-name"></label>
                                                    <div class="input__field-wrapper">
                                                        <div class="alert alert--info">
                                                            <i class="material-icons">info</i>
                                                            <p><?= Module::t('version_create_info'); ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input input--text">
                                                    <label class="input__label" for="create-version-modal-name"><?= Module::t('version_input_name'); ?></label>
                                                    <div class="input__field-wrapper">
                                                        <input class="input__field" id="create-version-modal-name" name="create-version-modal-name" type="text" ng-model="create.versionName" />
                                                    </div>
                                                </div>

                                                <div class="input input--radios">
                                                    <label class="input__label"></label>
                                                    <div class="input__field-wrapper">
                                                        <input type="radio" ng-checked="create.copyExistingVersion"><label ng-click="create.copyExistingVersion=true"><?= Module::t('version_create_copy'); ?></label> <br />
                                                        <input type="radio" ng-checked="!create.copyExistingVersion"><label ng-click="create.copyExistingVersion=false"><?= Module::t('version_create_new'); ?></label> <br />
                                                    </div>
                                                </div>

                                                <div class="input input--select" ng-show="create.copyExistingVersion">
                                                    <label class="input__label" for="edit-version-modal-layout"><?= Module::t('version_input_copy_chooser'); ?></label>
                                                    <select class="input__field" id="edit-version-modal-layout" name="edit-version-modal-layout" ng-model="create.fromVersionPageId" ng-options="versionItem.id as versionItem.version_alias for versionItem in typeData"></select>
                                                </div>

                                                <div class="input input--select" ng-show="!create.copyExistingVersion">
                                                    <label class="input__label" for="create-version-modal-layout"><?= Module::t('version_input_layout'); ?></label>
                                                    <select class="input__field" id="create-version-modal-layout" name="create-version-modal-layout" ng-model="create.versionLayoutId" ng-options="lts.id as lts.name for lts in layoutsData"></select>
                                                </div>

                                            </div>

                                            <div class="modal__footer">
                                                <div class="row">
                                                    <div class="col s12">
                                                        <div class="right">
                                                            <button class="btn" type="submit" ng-click="createNewVersionSubmit(create)">
                                                                <?php echo Module::t('button_create_version'); ?> <i class="material-icons right">check</i>
                                                            </button>
                                                            <button class="btn red" type="button" ng-click="closeCreateModal()">
                                                                <i class="material-icons left">cancel</i> <?php echo \luya\admin\Module::t('button_abort'); ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </modal>
                                        <!-- /Add version modal -->

                                    </div>
                                    <!-- /Versions -->

                                    <div ng-show="container.length == 0" class="page__no-version-warning alert alert--warning alert--icon-no-margin">
                                        <p><?= Module::t('page_has_no_version'); ?></p>
                                    </div>

                                    <ul class="page__list" ng-show="container.nav_item_page.id">
                                        <li class="page__placeholder accordion__entry--open" ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'"></li>
                                    </ul>
                                </div>
                                <div class="col s12" ng-switch-when="2">
                                    <p><?php echo Module::t('view_update_page_is_module'); ?></p>
                                </div>
                                <div class="col s12" ng-switch-when="3">
                                    <div ng-switch on="typeData.type">
                                        <div ng-switch-when="1">
                                            <p><?php echo Module::t('view_update_page_is_redirect_internal'); ?></p>
                                        </div>
                                        <div ng-switch-when="2">
                                            <p><?php echo Module::t('view_update_page_is_redirect_external'); ?>.</p>
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
                    <div class="blockholder__group blockholder__group--clipboard" ng-show="copyStack.length > 0">
                        <b class="blockholder__group-title blockholder__group-title--clipboard"><i class="material-icons left">content_copy</i> <span><?php echo Module::t('view_update_blockholder_clipboard') ?></span></b>
                        <div class="blockholder__block" ng-repeat="stackItem in copyStack" data-drag="true" data-copy="true" jqyoui-draggable="{placeholder: 'keep', onStart : 'onStart', onStop : 'onStop'}" ng-model="stackItem" data-jqyoui-options="{revert: false, refreshPositions : true, snapTolerance : 40, helper : 'clone', cursor:'move', cursorAt: { top: 0, left: 0 }}">
                            <span>{{stackItem.name}}</span>
                        </div>
                        <span ng-click="clearStack()" class="blockholder__clear-clipboard"><i class="material-icons">clear</i></span>
                    </div>
                    <div class="blockholder__search" ng-class="{'blockholder__search--active': searchQuery}" zaa-esc="searchQuery=''"">
                        <input class="blockholder__input" type="text" ng-model="searchQuery" value="" id="blockholderSearch" />
                        <label class="blockholder__icon blockholder__icon--search" for="blockholderSearch"><i class="material-icons">search</i></label>
                        <label class="blockholder__icon blockholder__icon--cancel" for="blockholderCancel">
                            <div ng-show="searchQuery.length > 0" ng-click="searchQuery=''"><i class="material-icons">close</i></div>
                        </label>
                    </div>
                    <div class="blockholder__group" ng-repeat="item in blocksData | orderBy:'groupPosition'" ng-class="{'blockholder__group--favorite' : item.group.is_fav}">
                        <b class="blockholder__group-title" ng-click="toggleGroup(item.group)" ng-class="{'blockholder__group-title--collapsed': !item.group.toggle_open}">
                            <i class="material-icons blockholder__group-toggler left" ng-click="toggleItem(data)" ng-class="{'blockholder__group-toggler--rotated': !item.group.toggle_open}">arrow_drop_down</i>
                            <i class="material-icons right" ng-if="item.group.is_fav">favorite</i>
                            <span>{{item.group.name}}</span>
                        </b>
                        <div class="blockholder__block" ng-show="item.group.toggle_open" ng-repeat="block in item.blocks | orderBy:'name' | filter:{name:searchQuery}" data-drag="true" jqyoui-draggable="{placeholder: 'keep', onStart : 'onStart', onStop : 'onStop'}" ng-model="block" data-jqyoui-options="{revert: false, refreshPositions : true, snapTolerance : 40, helper : 'clone', cursor:'move', cursorAt: { top: 0, left: 0 }}">
                            <span ng-bind-html="safe(block.full_name)"></span>
                            <i class="material-icons blockholder__fav-icon" ng-click="addToFav(block)" ng-if="!item.group.is_fav && !block.favorized">favorite_border</i>
                            <i class="material-icons blockholder__fav-icon blockholder__fav-icon--red" ng-click="removeFromFav(block)" ng-if="!item.group.is_fav && block.favorized">favorite</i>
                            <i class="material-icons blockholder__fav-icon blockholder__fav-icon--red" ng-click="removeFromFav(block)" ng-if="item.group.is_fav">remove</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
