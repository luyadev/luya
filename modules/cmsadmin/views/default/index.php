<!-- SCRIPT TEMPLATES -->

<script type="text/ng-template" id="createform.html">
    <div ng-switch on="data.nav_item_type" class="card-panel">
        <h5>Neue Seite hinzufügen</h5>
        <div class="row">
            <div class="input-field col s6">
                <input type="text" ng-model="data.title" ng-change="rewriteSuggestion()" />
                <label>Seiten Titel</label>
            </div>
            <div class="input-field col s6">
                <input type="text" ng-model="data.rewrite" />
                <label>Pfadsegment</label>
            </div>
        </div>
        <div class="row" ng-show="!data.isInline">
            <div class="col s12">
                <label>Kategorie</label>
                <select class="browser-default" ng-model="data.cat_id" ng-options="item.id as item.name for item in cat" />
            </div>
        </div>
        <div class="row" ng-show="!data.isInline">
            <div class="col s12">
                <label>Sprache</label>
                <select class="browser-default" ng-model="data.lang_id" ng-options="item.id as item.name for item in lang" />
            </div>
        </div>
        <div class="row" ng-show="!data.isInline">
            <div class="col s12">
                <label>Navigations Punkt von</label>
                <select class="browser-default" ng-model="data.parent_nav_id">
                    <option value="0">[Root Level]</option>
                    <option ng-repeat="nav in navitems" value="{{nav.id}}">{{nav.title}}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <p><input type="radio" ng-model="data.nav_item_type" value="1" id="t1"><label for="t1">Seite</label></p>
                <p><input type="radio" ng-model="data.nav_item_type" value="2" id="t2"><label for="t2">Module</label></p>
                <!--<p><input type="radio" ng-model="data.nav_item_type" value="3" id="t3"><label for="t3">Weiterleitung</label></p>-->
            </div>
        </div>

        <div ng-switch-when="1">
            <create-form-page data="data"></create-form-page>
        </div>

        <div ng-switch-when="2">
            <create-form-module data="data"></create-form-module>
        </div>

        <div ng-switch-when="3">
            <div class="row">
                <div class="col s12">
                    <br />
                    Weiterleitung
                </div>
            </div>
        </div>

        <!-- SUCCESS -->
        <div ng-show="success">
            <div class="alert alert--success">
                <i class="mdi-navigation-check"></i>
                <p>Diese Seite wurde erfolgreich erstellt!</p>
            </div>
        </div>
        <!-- /SUCCESS -->

        <!-- ERROR -->
        <div class="alert alert--danger" ng-show="error.length != 0">
            <i class="mdi-alert-error"></i>
            <ul>
                <li ng-repeat="err in error">{{ err[0] }}</li>
            </ul>
        </div>
        <!-- /ERROR -->

    </div>
</script>

<!-- CREATE PAGE FORM -->
<script type="text/ng-template" id="createformpage.html">
    <div class="row">
        <div class="col s12">
            <label>Layout</label>
            <select class="browser-default" ng-model="data.layout_id" ng-options="lts.id as lts.name for lts in layouts"></select>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()">Neue Seite Speichern</button>
        </div>
    </div>
</script>
<!-- /CREATE PAGE FORM -->

<!-- CREATE MODULE FORM -->
<script type="text/ng-template" id="createformmodule.html">
    <div class="row">
        <div class="col s12 input-field">
            <input type="text" ng-model="data.module_name" />
            <label>Module Name (Yii-ID)</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()">Neue Seite Speichern</button>
        </div>
    </div>
</script>
<!-- /CREATE MODULE FORM -->

<!-- treeview item -->
<script type="text/ng-template" id="reverse.html">

    <div data-drag="true" jqyoui-draggable="{onStart : 'onStart', onStop : 'onStop'}" data-jqyoui-options="{revert: false, handle : '.treeview__move', helper : 'clone'}" ng-model="data">

        <div class="treeview__drop" ng-class="{ 'treeview__drop--visible': showDrag }" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}">
        </div>

        <a class="treeview__link waves-effect waves-blue" ng-click="go(data.id)" ng-class="{'active' : isCurrentElement(data.id) }">
            <i ng-class="{ 'treeview__move--visible': showDrag }" class="mdi-action-open-with treeview__move left"></i>
            <div class="treeview__empty-circle"></div>
            {{data.title}}
        </a>

        <ul class="treeview__list" role="menu" ng-show="data.nodes.length > 0">
            <li class="treeview__item" role="menuitem" ng-repeat="data in data.nodes" ng-include="'reverse.html'"></li>
        </ul>

    </div>

</script>
<!-- /treeview item -->

<!-- /SCRIPT TEMPLATES -->

<!-- SIDEBAR -->
<div class="luya-container__sidebar">
    <div class="row">
        <div class="col s12">

            <a class="create-button [ btn-floating btn-large ][ waves-effect waves-light ] teal" ui-sref="custom.cmsadd"><i class="mdi-content-add"></i></a>

            <div ng-controller="CmsMenuTreeController">

                <div class="treeview__switch switch">
                    <label>
                        Verschieben
                        <input type="checkbox" ng-model="showDrag" ng-true-value="1" ng-false-value="0">
                        <span class="lever"></span>
                    </label>
                </div>
                
                <div class="treeview" ng-repeat="catitem in menu">
                    <h5 class="treeview__title">{{catitem.name}}</h5>

                    <ul class="treeview__list">
                        <li class="treeview__item" ng-repeat="data in catitem.__items" ng-include="'reverse.html'"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /SIDEBAR -->

<!-- MAIN -->
<div class="luya-container__main">

    <div class="col s12">
        <div ui-view></div>
    </div>

</div>
<!-- /MAIN -->