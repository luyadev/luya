<script type="text/ng-template" id="recursion.html">
<div class="collapsible__header collapsible-header"><i class="mdi-navigation-unfold-more"></i> {{placeholder.label}}</div>
<div class="collapsible__body collapsible-body">
    
    <div class="page__drop">
        <div class="page__drop-zone" ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="0" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}">
        </div>
    </div>

    <div ng-show="!placeholder.__nav_item_page_block_items.length">
        <p>Inhaltsblöcke hier platzieren</p>
    </div>

    <div ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController">
        <div class="block" ng-class="{ 'block--edit' : edit , 'blue lighten-5' : !block.is_dirty }" data-drag="true" jqyoui-draggable="{onStart : 'onStart', onStop : 'onStop'}" data-jqyoui-options="{revert: false, handle : '.block__move', helper : 'clone'}" ng-model="block">
            <div class="block__toolbar">
                        <div class="left">
                    <i class="block__move mdi-action-open-with"></i>
                    <div class="block__title"><p ng-click="toggleEdit()" ng-bind-html="safe(block.full_name)"></p></div>
                            </div>
                            <div class="right">
                                <i class="mdi-editor-mode-edit [ waves-effect waves-blue ]" ng-click="toggleEdit()"></i>
                                <i class="mdi-action-delete [ waves-effect waves-blue ]" ng-click="removeBlock(block)"></i>
                                <!--<i class="mdi-navigation-more-vert [ waves-effect waves-blue ]"></i>-->
                            </div>
            </div>
            <div class="block__body" ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)"></div>
            <div class="block__edit">
                <div class="row" ng-repeat="field in block.vars">
                     <zaa-injector dir="field.type" options="field.options" label="{{field.label}}" grid="12" model="data[field.var]"></zaa-injector>
                </div>
                <div ng-show="block.cfgs.length" class="blue lighten-5" style="margin-top:20px; margin-bottom:20px;">
                    <p class="flow-text" style="padding:10px; font-weight:bold;">Konfiguration</p>
                    <div class="row" ng-repeat="cfgField in block.cfgs">
                       <zaa-injector dir="cfgField.type" options="cfgField.options" label="{{cfgField.label}}" grid="12" model="cfgdata[cfgField.var]"></zaa-injector>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="right">
                            <button class="[ waves-effect waves-light ] btn btn--small teal" ng-click="save()"><i class="mdi-action-done left"></i> Speichern</button>
                        </div>
                    </div>
                </div>
            </div>
            <ul ng-show="block.__placeholders.length" class="collapsible" data-collapsible="expandable">
                <li ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'"></li>
            </ul>
        </div>

        <div class="page__drop">
            <div class="page__drop-zone" ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="{{key+1}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}">
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

                                    <!-- LANGUAGE SWITCH -->
                                    <div class="toolbar__group">
                                        <a ng-repeat="lang in AdminLangService.data" ng-click="AdminLangService.toggleSelection(lang)" ng-class="{'[ grey lighten-2 ]' : AdminLangService.isInSelection(lang)}" class="[ waves-effect waves-blue ][ btn-flat btn--small btn--bold ][ teal-text text-darken-2 ]">{{lang.name}}</a>
                                    </div>
                                    <!-- /LANGUAGE SWITCH -->

                                    <!-- PLACEHOLDER TOGGLE -->
                                    <div class="toolbar__group">
                                        <div class="switch">
                                            <label>
                                                Platzhalter offen
                                                <input type="checkbox">
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

                                    <!-- SITE PLACEMENET -->
                                    <div class="toolbar__group">
                                        <select class="browser-default">
                                            <option value="" disabled selected>Seitenplatzierung</option>
                                        </select>
                                    </div>
                                    <!-- /SITE PLACEMENET -->

                                    <!-- DELETE BUTTON -->
                                    <div class="toolbar__group">
                                        <a ng-click="trash()" class="[ waves-effect waves-blue ][ btn-flat btn--small ][ grey-text text-darken-2 ]"><i class="mdi-action-delete"></i></a>
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

                                </div>
                                <!-- /RIGHT TOOLBAR -->

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col s{{(12/AdminLangService.selection.length)}}" ng-repeat="lang in langs" ng-show="AdminLangService.isInSelection(lang)" ng-controller="NavItemController">

                    <!-- PAGE -->

                    <div class="page" ng-if="item.length == 0">
                        <div class="alert alert--info">
                            Diese Seite wurde noch nicht in {{lang.name}} übersetzt.
                        </div>
                        <div ng-controller="CmsadminCreateInlineController">
                            <create-form data="data"></create-form>
                        </div>
                    </div>
                    <div class="page {{AdminClassService.getClassSpace('onDragStart')}}" ng-if="item.length != 0">

                        <!-- PAGE__HEADER -->
                        <div class="page__header">
                            <div class="row">
                                <div class="col s12">
                                    <h4>
                                        {{item.title}} <i ng-click="toggleSettings()" class="mdi-editor-mode-edit right [ waves-effect waves-blue ]"></i>
                                    </h4>
                                    <p>{{lang.name}}</p>
                                </div>
                            </div>
                        </div>
                        <!-- /PAGE__HEADER -->

                        <!-- PAGE__CONTENT -->
                        <div class="page__content" ng-show="settings">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input ng-model="copy.title" type="text" class="validate">
                                    <label>Seitenname</label>
                                </div>
                                <div class="input-field col s6">
                                    <input ng-model="copy.rewrite"  type="text" class="validate">
                                    <label>Url</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <button class="btn waves-effect waves-light" type="button" ng-click="toggleSettings()">Abbrechen <i class="mdi-content-clear right"></i></button>
                                    <button class="btn waves-effect waves-light" type="button" ng-click="save(copy)">Speichern <i class="mdi-content-send right"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- /PAGE__CONTENT -->

                        <!-- PAGE__CONTENT--SETTINGS -->
                        <div class="page__content page__content--settings" ng-show="!settings" ng-switch on="item.nav_item_type">
                            <div class="row">
                                <div class="col s12" ng-switch-when="2">
                                    <p>Diese Seite ist als Module hinterlegt.
                                </div>
                                <div class="col s12" ng-switch-when="1" ng-controller="NavItemTypePageController">

                                    <ul class="collapsible" data-collapsible="expandable">
                                        <li ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'"></li>
                                    </ul>

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
                    <div class="blockholder__group" ng-repeat="item in DroppableBlocksService.blocks">
                        <b class="blockholder__group-title">{{item.group.name}}</b>
                        <div class="blockholder__block" ng-repeat="block in item.blocks" data-drag="true" jqyoui-draggable="{placeholder: 'keep', index : {{$index}}, onStart : 'onStart', onStop : 'onStop'}" ng-model="item.blocks" data-jqyoui-options="{revert: false, helper : 'clone'}">
                            <span ng-bind-html="safe(block.name)"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cms__sidebar-toggler" ng-click="toggleSidebar()">
                <i class="mdi-hardware-keyboard-arrow-right" ng-show="sidebar"></i>
                <i class="mdi-hardware-keyboard-arrow-left" ng-show="!sidebar"></i>
            </div>
        </div>
    </div>

</div>