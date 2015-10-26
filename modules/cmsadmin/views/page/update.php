<script type="text/ng-template" id="recursion.html">
<div class="accordion__header" ng-mouseenter="mouseEnter()" ng-click="toggleOpen()"><i class="material-icons">expand_more</i> {{placeholder.label}}</div>
<div class="accordion__body" ng-class="{ 'accordion__body--empty' : !placeholder.__nav_item_page_block_items.length }">
    
    <div class="page__drop">
        <div class="page__drop-zone" ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="0" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()'}">
        </div>
    </div>

    <div ng-show="!placeholder.__nav_item_page_block_items.length">
        <p>Inhaltsblöcke hier platzieren</p>
    </div>

    <div ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController">
        <div class="block" ng-class="{ 'block--edit' : edit , 'block--is-dirty' : !block.is_dirty && isEditable() }" data-drag="true" jqyoui-draggable="{onStart : 'onStart', onStop : 'onStop'}" data-jqyoui-options="{snapTolerance : 40, handle : '.block__move', delay: 200, cursor:'move', cursorAt: { top: 0, left: 0 }, revert:true }" ng-model="block">
            <div class="block__toolbar">
                <div class="left">
                    <i class="block__move material-icons">open_with</i>
                    <div class="block__title" ng-bind-html="safe(block.full_name)" ng-click="toggleEdit()"></div>
                </div>
                <div class="right">
                    <i ng-show="!edit && isEditable()" class="mdi-editor-mode-edit [ waves-effect waves-blue ]" ng-click="toggleEdit()"></i>
                    <i ng-show="!edit" class="mdi-action-delete [ waves-effect waves-blue ]" ng-click="removeBlock(block)"></i>
                    <i ng-show="edit" class="mdi-navigation-close [ waves-effect waves-blue ]" ng-click="toggleEdit()"></i>
                </div>
            </div>
            <div class="block__body cmsadmin-tags" ng-click="toggleEdit()" ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)"></div>
            <div class="block__edit">
                <div class="row" ng-repeat="field in block.vars">
                     <zaa-injector dir="field.type" options="field.options" fieldid="{{field.id}}" fieldname="{{field.var}}" initvalue="{{field.initvalue}}" placeholder="{{field.placeholder}}" label="{{field.label}}" model="data[field.var]"></zaa-injector>
                </div>

                <div class="row">
                    <div class="col s12">
                        <ul class="collapsible" data-collapsible="accordion" ng-show="block.cfgs.length">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">settings</i> Erweiterte Einstellungen</div>
                                <div class="collapsible-body">
                                    <br />
                                    <div class="row" ng-repeat="cfgField in block.cfgs">
                                        <zaa-injector dir="cfgField.type" placeholder="{{cfgField.placeholder}}" fieldid="{{cfgField.id}}" fieldname="{{cfgField.var}}" initvalue="{{cfgField.initvalue}}" options="cfgField.options" label="{{cfgField.label}}"  model="cfgdata[cfgField.var]"></zaa-injector>
                                    </div>
                                    <br /><br />
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <div class="right">
                            <button class="[ waves-effect waves-light ] btn btn--small teal" ng-click="save()"><i class="material-icons left">done</i> Speichern</button>
                        </div>
                    </div>
                </div>
            </div>
            <ul ng-show="block.__placeholders.length" class="accordion" >
                <li class="accordion__entry" ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'" ng-class="{ 'accordion__entry--open' : isOpen }"></li>
            </ul>
        </div>

        <div class="page__drop">
            <div class="page__drop-zone" ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="{{key+1}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()'}">
            </div>
        </div>

    </div>
</div>
</script>
<div ng-controller="NavController" ng-show="!isDeleted">

    <div class="cms" ng-class="{'cms--sidebar-hidden' : !sidebar}">
        <div class="cms__pages">

            <div class="row">
                <div class="col s12">

                    <div class="toolbar [ grey lighten-3 ]">
                        <div class="row">
                            <div class="col s12">

                                <!-- LEFT TOOLBAR -->
                                <div class="left">
                                    <button type="button" class="btn" ng-click="togglePropMask()" style="margin-right:10px;" ng-show="properties.length">Eigenschaften</button>
                                    <!-- LANGUAGE SWITCH -->
                                    <div class="toolbar__group">
                                        <a ng-repeat="lang in AdminLangService.data" ng-click="AdminLangService.toggleSelection(lang)" ng-class="{'[ grey lighten-2 ]' : AdminLangService.isInSelection(lang)}" class="[ waves-effect waves-blue ][ btn-flat btn--small btn--bold ][ teal-text text-darken-2 ]">{{lang.name}}</a>
                                    </div>
                                    <!-- /LANGUAGE SWITCH -->

                                    <!-- PLACEHOLDER TOGGLE -->
                                    <div class="toolbar__group">
                                        <div class="switch">
                                            <label>
                                                <span ng-if="placeholderState">Alle Platzhalter einklappen</span>
                                                <span ng-if="!placeholderState">Alle Platzhalter ausklappen</span>
                                                <input type="checkbox" ng-model="placeholderState" ng-true-value="1" ng-false-value="0">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /PLACEHOLDER TOGGLE -->

                                </div> <!-- /LEFT TOOLBAR -->

                                <!-- RIGHT TOOLBAR -->
                                <div class="right">

                                    <!-- NAVIGATION DROPDOWN -->
                                    <div class="toolbar__group">
                                        <select class="browser-default" ng-model="navData.cat_id" ng-options="item.id as item.name for item in menuCats" />
                                    </div>
                                    <!-- /NAVIGATION DROPDOWN -->

                                    <!-- DELETE BUTTON -->
                                    <div class="toolbar__group">
                                        <a ng-click="trash()" class="[ waves-effect waves-blue ][ btn-flat btn--small ][ grey-text text-darken-2 ]"><i class="material-icons">delete</i></a>
                                    </div>
                                    <!-- /DELETE BUTTON -->

                                    <!-- VISIBILITY SWITCH -->
                                    <div class="toolbar__group">
                                        <div class="switch">
                                            <label>
                                                Sichtbar
                                                <input type="checkbox" ng-model="navData.is_hidden" ng-true-value="0" ng-false-value="1">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /VISIBILITY SWITCH -->
                                    
                                    <!-- OFFLINE SWITCH -->
                                    <div class="toolbar__group">
                                        <div class="switch">
                                            <label>
                                                Online
                                                <input type="checkbox" ng-model="navData.is_offline" ng-true-value="0" ng-false-value="1">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /OFFLINE SWITCH -->

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
                    <h5>Seiten Eigenschaften</h5>
                    <div ng-show="!hasValues" class="alert alert--info">Es wurden noch keine Eigenschaften gespeichert.</div>
                        <div class="row" ng-repeat="prop in properties">
                            <zaa-injector dir="prop.type" options="prop.option_json" fieldid="{{prop.var_name}}" fieldname="{{prop.var_name}}" initvalue="{{prop.default_value}}" label="{{prop.label}}" model="propValues[prop.id]"></zaa-injector>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button type="button" ng-click="storePropValues()" class="btn" ng-show="hasValues">Werte aktualisieren</button>
                                <button type="button" ng-click="storePropValues()" class="btn" ng-show="!hasValues">Speichern</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">

                <div class="col s{{(12/AdminLangService.selection.length)}}" ng-repeat="lang in langs" ng-show="AdminLangService.isInSelection(lang) && showContainer" ng-controller="NavItemController">
                    <!-- PAGE -->
                    <div class="page" ng-show="!isTranslated">
                        <div class="row">
                            <div class="col s12">
                                <div class="alert alert--info">
                                    Diese Seite wurde noch nicht in {{lang.name}} übersetzt.
                                </div>
                            </div>
                        </div>
                        <div ng-controller="CmsadminCreateInlineController">
                            <create-form data="data"></create-form>
                        </div>
                    </div>
                    <div class="page {{AdminClassService.getClassSpace('onDragStart')}}" ng-show="isTranslated">
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

                        <!-- PAGE__CONTENT -->
                        <div class="page__content" ng-show="settings" ng-switch on="item.nav_item_type">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input ng-model="itemCopy.title" type="text" class="validate">
                                    <label>Seitenname</label>
                                </div>
                                <div class="input-field col s6">
                                    <input ng-model="itemCopy.rewrite"  type="text" class="validate">
                                    <label>Url</label>
                                </div>
                            </div>
                            
                            <div ng-switch-when="1" class="row">
                                <div class="input-field col s12">
                                    <select class="browser-default" ng-model="typeDataCopy.layout_id" ng-options="lts.id as lts.name for lts in layouts"></select>
                                    <label>Layout</label>
                                </div>
                            </div>
                    
                            <div ng-switch-when="2" class="row">
                                <p>Module Settings.</p>
                            </div>
                            
                            <div ng-switch-when="3" class="row">
                                <p>Redirect Settings</p>
                            </div>
                            
                            <div class="row">
                                <div class="col s12">
                                    <button class="btn waves-effect waves-light" type="button" ng-click="toggleSettings()">Abbrechen <i class="material-icons right">clear</i></button>
                                    <button class="btn waves-effect waves-light" type="button" ng-click="save(itemCopy, typeDataCopy)">Speichern <i class="material-icons right">send</i></button>
                                </div>
                            </div>
                            
                            <div class="alert alert--danger" ng-show="errors.length">
                                <ul>
                                    <li ng-repeat="err in errors">{{err.message}}</li>
                                </ul>
                            </div>
                            
                        </div>
                        <!-- /PAGE__CONTENT -->

                        <!-- PAGE__CONTENT--SETTINGS -->
                        <div class="page__content page__content--settings" ng-show="!settings" ng-switch on="item.nav_item_type">
                            <div class="row">
                                <div class="col s12" ng-switch-when="1" ng-controller="NavItemTypePageController">
                                    <div class="alert alert--danger" ng-show="!container.nav_item_page.id">Das für die Seite definierte Layout wurde nicht (mehr) gefunden. Bitte bearbeiten Sie die Layout Einstellungen diese Seite.</div>
                                    <ul class="accordion" ng-show="container.nav_item_page.id">
                                        <li class="accordion__entry" ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'" ng-class="{ 'accordion__entry--open' : isOpen }"></li>
                                    </ul>
                                </div>
                                <div class="col s12" ng-switch-when="2">
                                    <p>Diese Seite ist als <b>Module</b> hinterlegt.</p>
                                </div>
                                <div class="col s12" ng-switch-when="3">
                                    <p>Diese Seite ist ein <b>Redirect</b>.</p>
                                </div>
                            </div>
                        </div>
                        <!-- /PAGE__CONTENT--SETTINGS -->
                    </div>
                    <!-- /PAGE -->
                </div>

            </div>
        </div>

        <div class="cms__sidebar">

            <div class="blockholder" ng-controller="DroppableBlocksController">
                <div class="col s12">
                    <div class="blockholder__search">
                        <input type="text" ng-model="search"/>
                        <i class="material-icons">search</i>
                    </div>
                    <div class="blockholder__group" ng-repeat="item in DroppableBlocksService.blocks">
                        <b class="blockholder__group-title">{{item.group.name}}</b>
                        <div class="blockholder__block" ng-repeat="block in item.blocks | orderBy:'name' | filter:{name:search}" data-drag="true" jqyoui-draggable="{placeholder: 'keep', onStart : 'onStart', onStop : 'onStop'}" ng-model="block" data-jqyoui-options="{revert: false, refreshPositions : true, snapTolerance : 40, helper : 'clone', cursor:'move', cursorAt: { top: 0, left: 0 }}">
                            <span ng-bind-html="safe(block.full_name)"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cms__sidebar-toggler" ng-click="toggleSidebar()">
                <i class="material-icons" ng-show="sidebar">keyboard_arrow_right</i>
                <i class="material-icons" ng-show="!sidebar">keyboard_arrow_left</i>
            </div>
        </div>
    </div>

</div>
