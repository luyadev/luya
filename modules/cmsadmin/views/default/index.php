
<script type="text/ng-template" id="createform.html">
    <form ng-switch on="data.nav_item_type" class="card-panel">
        <h5>Neue Seite hinzufügen</h5>
        <div class="row">
            <div class="input input--text col s12">
                <label class="input__label">Seitentitel</label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.title" ng-change="rewriteSuggestion()" focus-me="true" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input input--text col s12">
                <label class="input__label">Pfadsegment</label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.rewrite" />
                </div>
            </div>
        </div>
        <div class="row" ng-hide="data.isInline || cat.length == 1">
            <div class="input input--select col s12">
                <label class="input__label">Navigations-Kategorie</label>
                <div class="input__field-wrapper">
                    <select class="input__field browser-default" ng-model="data.cat_id" ng-options="item.id as item.name for item in cat"></select>
                </div>
            </div>
        </div>
        <div class="row" ng-hide="data.isInline || lang.length == 1">
            <div class="input input--select col s12">
                <label class="input__label">Sprache</label>
                <div class="input__field-wrapper">
                    <select class="input__field browser-default" ng-model="data.cat_id" ng-options="item.id as item.name for item in lang"></select>
                </div>
            </div>
        </div>
        <div class="row" ng-show="!data.isInline">
            <div class="input input--select col s12">
                <label class="input__label">Übergeordnete Seite</label>
                <div class="input__field-wrapper">
                    <select class="input__field browser-default" ng-model="data.parent_nav_id">
                        <option value="0">[Root Level]</option>
                        <option ng-repeat="nav in navitems" value="{{nav.id}}">{{nav.title}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input input--radios col s12">
                <label class="input__label">Seitentyp</label>
                <div class="input__field-wrapper">
                    <input type="radio" ng-model="data.nav_item_type" value="1" id="t1"><label for="t1">Seite</label> <br />
                    <input type="radio" ng-model="data.nav_item_type" value="2" id="t2"><label for="t2">Modul</label> <br />
                    <input type="radio" ng-model="data.nav_item_type" value="3" id="t3"><label for="t3">Weiterleitung</label>
                </div>
            </div>
        </div>

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
                <p>Diese Seite wurde erfolgreich erstellt!</p>
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
    <div class="row">
        <div class="input input--select col s12">
            <label class="input__label">Layout</label>
            <div class="input__field-wrapper">
                <select class="input__field browser-default" ng-model="data.layout_id" ng-options="lts.id as lts.name for lts in layouts"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()">Neue Seite speichern</button>
        </div>
    </div>
</script>
<!-- /CREATE PAGE FORM -->

<!-- CREATE MODULE FORM -->
<script type="text/ng-template" id="createformmodule.html">
    <div class="row">
        <div class="input input--text col s12">
            <label class="input__label">Modul Name (Yii-ID)</label>
            <div class="input__field-wrapper">
                <input name="text" type="text" class="input__field" ng-model="data.module_name" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()">Neue Seite speichern</button>
        </div>
    </div>
</script>
<!-- /CREATE MODULE FORM -->

<!-- CREATE MODULE FORM -->
<script type="text/ng-template" id="createformredirect.html">
    <div class="row">
        <div class="input input--radios col s12">
            <label class="input__label">Art der Weiterleitung</label>
            <div class="input__field-wrapper">
                <input type="radio" ng-model="data.redirect_type" value="1" id="r_t1"><label for="r_t1">Interne-Seite</label> <br />
                <input type="radio" ng-model="data.redirect_type" value="2" id="r_t2"><label for="r_t2">Link-Extern</label>
                <!--<input type="radio" ng-model="data.redirect_type" value="3" id="r_t3"><label for="r_t3">Datei</label>-->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12" ng-show="data.redirect_type==1">
            <p>Auf welche Interne-Seite wollen Sie weiterleiten?</p>
            <menu-dropdown class="menu-dropdown" nav-id="data.redirect_type_value" />
        </div>

        <div class="col s12" ng-show="data.redirect_type==2">

            <div class="input input--text col s12">
                <label class="input__label">Externer Link</label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.redirect_type_value" placeholder="http://" />
                    <small>Externe Links beginnen mit http:// oder https://</small>
                </div>
            </div>
        </div>

        <div class="col s12" ng-show="data.redirect_type==3">
            <p>todo</p> <!-- todo -->
        </div>

    </div>

    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()">Neue Seite speichern</button>
        </div>
    </div>
</script>
<!-- /CREATE MODULE FORM -->

<script type="text/ng-template" id="menuDropdownReverse.html">

    <div class="input">
        <input type="radio" ng-checked="data.id == navId" />
        <label ng-click="changeModel(data)">
            <span class="menu-dropdown__label">{{ data.title }}</span>
        </label>
    </div>

    <ul class="menu-dropdown__list">
        <li class="menu-dropdown__item" ng-repeat="data in data.nodes" ng-include="'menuDropdownReverse.html'"></li>
    </ul>
</script>

<!-- treeview item -->
<script type="text/ng-template" id="reverse.html">

    <div data-drag="true" jqyoui-draggable="{onStart : 'onStart', onStop : 'onStop'}" data-jqyoui-options="{revert: true, delay: 200, scroll : false, handle : '.treeview__link--draggable'}" ng-model="data">

        <div class="treeview__drop" ng-class="{ 'treeview__drop--visible': showDrag }" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : false, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onBeforeDrop()', multiple : true}">
        </div>

        <a class="treeview__link" ng-click="!showDrag && go(data.id)" title="id={{data.id}}" alt="id={{data.id}}" ng-class="{'treeview__link--active' : isCurrentElement(data.id), 'waves-effect waves-blue' : !showDrag, 'treeview__link--draggable' : showDrag, 'treeview__link--is-hidden' : data.is_hidden == '1' }" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : false, tolerance : 'pointer', hoverClass : 'treeview__link--hover' }" jqyoui-droppable="{onDrop: 'onChildDrop()', multiple : true}">
            <i ng-class="{ 'treeview__move--visible': showDrag }" class="material-icons treeview__move left">open_with</i>
           
            <div class="treeview__empty-circle"></div>
            {{data.title}}

            <i ng-show="data.is_offline == '1'" class="material-icons treeview__site-state treeview__site-state--offline" title="Seiten Status: Offline">cloud_off</i>
            <i ng-show="data.is_offline == '0'" class="material-icons treeview__site-state treeview__site-state--online" title="Seiten Status: Online">cloud_queue</i>

            <i ng-show="data.is_hidden == '0'" class="material-icons treeview__site-state treeview__site-state--visible" title="Seiten Sichtbarkeit: Sichtbar">visibility</i>
            <i ng-show="data.is_hidden == '1'" class="material-icons treeview__site-state treeview__site-state--invisible" title="Seiten Sichtbarkeit: Unsichtbar">visibility_off</i>
            
        </a>

        <ul class="treeview__list" role="menu" ng-show="data.nodes.length > 0">
            <li class="treeview__item" role="menuitem" ng-repeat="data in data.nodes" ng-include="'reverse.html'"></li>
        </ul>


        <div class="treeview__drop" ng-show="$last" ng-class="{ 'treeview__drop--visible': showDrag }" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : false, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onAfterDrop()', multiple : true}">
        </div>

    </div>

</script>
<!-- /treeview item -->

<!-- /SCRIPT TEMPLATES -->

<!-- SIDEBAR -->
<div class="luya-container__sidebar">
    <div class="row">
        <div class="col s12">

            <a class="create-button [ btn-floating btn-large ][ waves-effect waves-light ] teal" ui-sref="custom.cmsadd"><i class="material-icons">add</i></a>

            <div ng-controller="CmsMenuTreeController">
                <div class="treeview__switch switch">
                    <label>
                        Verschieben
                        <input type="checkbox" ng-model="showDrag" ng-true-value="1" ng-false-value="0">
                        <span class="lever"></span>
                    </label>
                </div>

                <div class="treeview" ng-repeat="catitem in menu" ng-class="{ 'treeview--drag-active' : showDrag }">
                    <h5 class="treeview__title" ng-click="toggleCat(catitem.id)"><i class="material-icons treeview__title-icon" ng-class="{'treeview__title-icon--closed': toggleIsHidden(catitem.id)}">arrow_drop_down</i> {{catitem.name}}</h5>

                    <p class="treeview__empty-message" ng-show="catitem.__items.length == 0 && !toggleIsHidden(catitem.id)">Noch keine Seiten hinterlegt</p>
                    <ul class="treeview__list" ng-hide="toggleIsHidden(catitem.id)">
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
