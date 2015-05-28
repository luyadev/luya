<style>
    .test {
        background-color:red; color:black; padding:20px
    }
</style>
<script type="text/ng-template" id="recursion.html">
    <div class="col s1">
        <div class="card blue lighten-5">
        <span>{{placeholder.label | uppercase}}</span>
        </div>
    </div>
    <div class="col s11">
        <div ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController" data-drag="true" jqyoui-draggable="{onStart : 'onStart', onStop : 'onStop'}" data-jqyoui-options="{revert: true, handle : '.drag-icon', helper : 'clone'}" ng-model="block">
        <div ng-controller="DropBlockController" data-sortindex="{{key}}" ng-model="droppedBlock" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'test' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}"></div>
                    
        <div class="card" style="margin-bottom:5px; min-height:300px;">
            <div class="card-content" style="padding:10px;">
                <span class="card-title activator grey-text text-darken-4">{{block.name}} <i class="mdi-navigation-more-vert right"></i> <i class="mdi-content-select-all right drag-icon"></i></span>
                <div ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)" />
            </div>
            <div class="card-reveal" style="z-index:999999;">
                <span class="card-title grey-text text-darken-4">{{block.name}} <i class="mdi-navigation-close right"></i></span>
                <form class="col s12">
                    <div class="row" ng-repeat="field in block.vars">
                        <zaa-injector dir="field.type" options="field.options" label="{{field.label}}" grid="12" model="data[field.var]"></zaa-injector>
                    </div>
                    <div ng-show="block.cfgs.length > 0">
                        <h5>Konfigurations Parameter</h5>
                        <div class="row" ng-repeat="cfgField in block.cfgs">
                            <zaa-injector dir="cfgField.type" options="cfgField.options" label="{{cfgField.label}}" grid="12" model="cfgdata[cfgField.var]"></zaa-injector>
                        </div>
                    </div>
                    <button type="button" ng-click="save()">Speichern</button>
                </form>
            </div>
            
        </div>
        <div>
            <div ng-show="block.__placeholders.length" class="card blue lighten-4">
                <div ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'" class="row"></div>
            </div>
        </div>

        </div><!-- // CLOSEING ng-controller dropBlockController -->

        <div ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="-1" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'test' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}">
            
        </div>
    </div>

</script>

<script type="text/ng-template" id="recursion2.html">
<div class="collapsible__header collapsible-header"><i class="mdi-navigation-unfold-more"></i> {{placeholder.label}}</div>
<div class="collapsible__body collapsible-body">
	<div class="block" ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController">
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
            <li ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion2.html'"></li>
        </ul>
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
                                <a class="[ waves-effect waves-tale ][ btn-flat btn--small btn--bold ][ teal-text text-darken-2 ][ grey lighten-2 ]">DE</a>
                                <a class="[ waves-effect waves-tale ][ btn-flat btn--small btn--bold ][ teal-text text-darken-2 ][ grey lighten-2 ]">EN</a>
                                <a class="[ waves-effect waves-tale ][ btn-flat btn--small btn--bold ][ teal-text text-darken-2 ]">FR</a>
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
            
            <div class="col s{{(12/langs.length)}}" ng-repeat="lang in langs" ng-controller="NavItemController">
            <!-- page -->
            <div class="page" ng-if="item.length == 0">
                <p>Seite noch nicht übersetzt.</p>
            </div>
            <div class="page" ng-if="item.length != 0">

                <div class="page__header">
                    <div class="row">
                        <div class="col s12">
                            <h4>
                                {{item.title}} <i class="mdi-navigation-more-vert right [ waves-effect waves-tale ]"></i>
                            </h4>
                            <p>{{lang.name}}</p>
                        </div>
                    </div>
                </div>

                <div class="page__content" ng-switch on="item.nav_item_type">
                    <div class="row">
                        <div class="col s12" ng-switch-when="2">
                            <p>Diese Seite ist als Module hinterlegt.
                        </div>
                        <div class="col s12" ng-switch-when="1" ng-controller="NavItemTypePageController">

                            <ul class="collapsible" data-collapsible="accordion">
                                <li ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion2.html'"></li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
            <!-- /page -->
        </div>
    </div>
</div>