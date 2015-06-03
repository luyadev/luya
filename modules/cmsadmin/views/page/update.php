<script type="text/ng-template" id="recursion.html">
<div class="collapsible__header collapsible-header"><i class="mdi-navigation-unfold-more"></i> {{placeholder.label}}</div>
<div class="collapsible__body collapsible-body">
    
    <div class="page__drop"  ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="0" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}"></div>

    <div ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController" data-drag="true" jqyoui-draggable="{onStart : 'onStart', onStop : 'onStop'}" data-jqyoui-options="{revert: false, handle : '.block__move', helper : 'clone'}" ng-model="block">
        <div class="block">
            <div class="block__toolbar">
                        <div class="left">
                    <i class="block__move mdi-action-open-with"></i>
                    <div class="block__title">
                                        <i class="mdi-editor-format-align-left"></i><p>{{block.name}}</p>
                    </div>
                            </div>
                            <div class="right">
                                <i class="mdi-editor-mode-edit [ waves-effect waves-tale ]" onclick="$(this).parents('.block').toggleClass('block--edit');"></i>
                                <i class="mdi-navigation-more-vert [ waves-effect waves-tale ]"></i>
                            </div>
            </div>
            <div class="block__body" ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)"></div>
            <div class="block__edit">
                <div class="row" ng-repeat="field in block.vars">
                     <zaa-injector dir="field.type" options="field.options" label="{{field.label}}" grid="12" model="data[field.var]"></zaa-injector>
                </div>
                <hr /><h5>Konfigurations Parameter</h5>
                <div class="row" ng-repeat="cfgField in block.cfgs">
                    <zaa-injector dir="cfgField.type" options="cfgField.options" label="{{cfgField.label}}" grid="12" model="cfgdata[cfgField.var]"></zaa-injector>
                </div>
                <div class="row">
                    <div class="col s12">
                    <div class="right">
                        <button class="[ waves-effect waves-light ] btn btn--small teal" ng-click="save()"><i class="mdi-action-done left"></i> Speichern</button>
                    </div>
                    </div>
                </div>
            </div>
            <ul ng-show="block.__placeholders.length" class="collapsible" data-collapsible="accordion">
                <li ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'"></li>
            </ul>
        </div>
        <div class="page__drop" ng-controller="DropBlockController" data-sortindex="{{key+1}}" ng-model="droppedBlock" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'page__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}"></div>

    </div>
</div>
</script>
<div ng-controller="NavController" ng-show="!isDeleted">
    <div class="row">
        <div class="col s12">
    
            <div class="toolbar [ grey lighten-3 ]">
                <div class="row">
                    <div class="col s12">
    
                        <!-- LEFT TOOLBAR -->
                        <div class="left">
    
                            <!-- LANGUAGE SWITCH -->
                            <div class="toolbar__group">
                                <a ng-repeat="lang in AdminLangService.data" ng-click="AdminLangService.toggleSelection(lang)" ng-class="{'[ grey lighten-2 ]' : AdminLangService.isInSelection(lang)}" class="[ waves-effect waves-tale ][ btn-flat btn--small btn--bold ][ teal-text text-darken-2 ]">{{lang.name}}</a> 
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
                                <a ng-click="trash()" class="[ waves-effect waves-tale ][ btn-flat btn--small ][ grey-text text-darken-2 ]"><i class="mdi-action-delete"></i></a>
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

            <div class="row">
            
            <div class="col s{{(12/AdminLangService.selection.length)}}" ng-repeat="lang in langs" ng-show="AdminLangService.isInSelection(lang)" ng-controller="NavItemController">
            <!-- page -->
            <div class="page" ng-if="item.length == 0">
                <p>Seite noch nicht übersetzt.</p>
            </div>
            <div class="page {{AdminClassService.getClassSpace('onDragStart')}}" ng-if="item.length != 0">
                <div class="page__header">
                    <div class="row">
                        <div class="col s12">
                            <h4>
                                {{item.title}} <i class="mdi-navigation-more-vert right [ waves-effect waves-tale ]" dropdown data-constrainwidth="false" data-beloworigin="true" data-activates="pageMenu-{{item.id}}"></i>
                            </h4>
                            <p>{{lang.name}}</p>
                        </div>
                    </div>
                </div>

                <!-- Page Settings dropdown, called by javascript -->
                <ul id="pageMenu-{{item.id}}" class="dropdown-content">
                    <li><a href="#!">Seiteninformationen bearbeiten</a></li>
                </ul>
                <!-- /Page Settings dropdown -->

                <div class="page__content" ng-switch on="item.nav_item_type">
                    <div class="row">
                        <div class="col s12" ng-switch-when="2">
                            <p>Diese Seite ist als Module hinterlegt.
                        </div>
                        <div class="col s12" ng-switch-when="1" ng-controller="NavItemTypePageController">

                            <ul class="collapsible" data-collapsible="accordion">
                                <li ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'"></li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
            <!-- /page -->
        </div>

        <div class="blockholder">
            <div class="col s12">
                <div class="blockholder__inner" ng-controller="DroppableBlocksController">
                    <ul class="blockholder__tabs tabs" tabs>
                        <li class="blockholder__tab tab col s6" ng-repeat="item in DroppableBlocksService.blocks"><a ng-href="#blocks-{{item.group.id}}">{{item.group.name}}</a></li>
                    </ul>
                    <div ng-repeat="item in DroppableBlocksService.blocks" id="blocks-{{item.group.id}}" class="blockholder__blocks">
                        <div class="blockholder__block" ng-repeat="block in item.blocks" data-drag="true" jqyoui-draggable="{placeholder: 'keep', index : {{$index}}, onStart : 'onStart', onStop : 'onStop'}" ng-model="item.blocks" data-jqyoui-options="{revert: false, helper : 'clone'}">
                            <i class="mdi-editor-format-align-left"></i> {{ block.name}} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>