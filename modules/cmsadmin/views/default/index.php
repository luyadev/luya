
<script type="text/ng-template" id="createform.html">
    <form ng-switch on="data.nav_item_type" class="card-panel">
        <h5>Neue Seite hinzufügen</h5>

        <div class="row">
            <div class="input input--radios col s12">
                <label class="input__label">Seitentyp</label>
                <div class="input__field-wrapper">
                    <input type="radio" ng-checked="data.nav_item_type == 1"><label ng-click="data.nav_item_type = 1">Seite</label><br />
                    <input type="radio" ng-checked="data.nav_item_type == 2"><label ng-click="data.nav_item_type = 2; data.is_draft = 0">Modul</label><br />
                    <input type="radio" ng-checked="data.nav_item_type == 3"><label ng-click="data.nav_item_type = 3; data.is_draft = 0">Weiterleitung</label><br />
                </div>
            </div>
        </div>

<hr style="margin:50px 0px; background-color:#F0F0F0; color:#F0F0F0; height:1px; border:0px;" />

        <div class="row" ng-show="data.nav_item_type == 1 && !data.isInline">
            <div class="input input--text col s12">
                <label class="input__label">Als Vorlage</label>
                <div class="input__field-wrapper">
                    Möchtest du diese neue Seite als Vorlage hinterlegen?<br />
                    <input type="radio" ng-checked="data.is_draft == 0"><label ng-click="data.is_draft = 0">Nein</label><br />
                    <input type="radio" ng-checked="data.is_draft == 1"><label ng-click="data.is_draft = 1">Ja</label><br />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="input input--text col s12">
                <label class="input__label">Seitentitel</label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.title" ng-change="aliasSuggestion()" focus-me="true" />
                </div>
            </div>
        <div class="row">
        </div>    
            <div class="input input--text col s12">
                <label class="input__label">Pfadsegment</label>
                <div class="input__field-wrapper">
                    <input name="text" type="text" class="input__field" ng-model="data.alias" />
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0">
            <div class="input input--text col s12">
                <label class="input__label">Beschreibung (Meta Description für Google)</label>
                <div class="input__field-wrapper">
                    <textarea class="input__field validate" ng-model="data.description"></textarea>
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0" ng-hide="data.isInline || navcontainer.length == 1">
            <div class="input input--select col s12">
                <label class="input__label">Navigations-Container</label>
                <div class="input__field-wrapper">
                    <select class="input__field browser-default" ng-model="data.nav_container_id" ng-options="item.id as item.name for item in navcontainers"></select>
                </div>
            </div>
        </div>
        <div class="row" ng-show="data.is_draft==0 && !data.isInline">
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
        <div class="row" ng-show="!data.isInline">
            <div class="input input--text col s12">
                <label class="input__label">Eine Vorlage verwenden?</label>
                <div class="input__field-wrapper">
                    <input type="radio" ng-checked="data.use_draft == 0"><label ng-click="data.use_draft = 0; data.from_draft_id = 0">Nein</label><br />
                    <input type="radio" ng-checked="data.use_draft == 1"><label ng-click="data.use_draft = 1; data.layout_id = 0">Ja</label><br />
                </div>
            </div>
        </div>

    <div class="row"ng-show="data.use_draft==1">
        <div class="input input--select col s12">
            <label class="input__label">Möchtest du aus einer Vorlage auswählen?</label>
            <div class="input__field-wrapper">
                <select class="input__field browser-default" ng-model="data.from_draft_id" ng-options="draft.id as draft.title for draft in drafts"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input input--select col s12"  ng-show="data.use_draft==0">
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
                <input type="radio" ng-model="data.redirect_type" value="1"><label ng-click="data.redirect_type = 1">Interne-Seite</label> <br />
                <input type="radio" ng-model="data.redirect_type" value="2"><label ng-click="data.redirect_type = 2">Link-Extern</label>
                <!--<input type="radio" ng-model="data.redirect_type" value="3"><label ng-click="data.redirect_type = 3">Datei</label>-->
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

<!-- CREATE DRAFT FORM -->
<script type="text/ng-template" id="createformdraft.html">
    <div class="row">
        <div class="col s12">
            <br />
            <button type="button" class="btn" ng-click="save()">Neue Seite speichern</button>
        </div>
    </div>
</script>
<!-- /CREATE DRAF FORM -->

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

    <div data-drag="true"  jqyoui-draggable data-jqyoui-options="{revert: true, delay: 200, scroll : false, handle : '.treeview__link--draggable'}" ng-model="data">

        <div class="treeview__drop" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onBeforeDrop()', multiple : true}">
        </div>
        <a class="treeview__button treeview__link" ng-click="!showDrag && go(data.id)" title="id={{data.id}}" alt="id={{data.id}}" ng-class="{'treeview__link--active' : isCurrentElement(data.id), 'treeview__link--is-online' : data.is_offline == '0', 'treeview__link--is-hidden' : data.is_hidden == '1', 'treeview__link--draggable' : showDrag}" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__link--hover' }" jqyoui-droppable="{onDrop: 'onChildDrop()', multiple : true}">
            <div class="treeview__icon-holder">
                <!-- show if drag is active -->
                <i ng-show="showDrag" class="material-icons treeview__icon treeview__icon--move">open_with</i>

                <!-- show if drag is not active-->
                <i ng-show="!showDrag && data.is_hidden == '0'" class="material-icons treeview__icon treeview__icon--visible" title="Sichtbarkeit: Sichtbar">visibility</i>
                <i ng-show="!showDrag && data.is_hidden == '1'" class="material-icons treeview__icon treeview__icon--invisible" title="Sichtbarkeit: Unsichtbar">visibility_off</i>
            </div>

            <span>
                {{data.title}} <i ng-show="data.is_home==1" class="material-icons treeview__text-icon">home</i>
            </span>
        </a>

        <ul class="treeview__list" role="menu">
            <li class="treeview__item" role="menuitem" ng-repeat="data in menuData.items | menuparentfilter:catitem.id:data.id" ng-include="'reverse.html'"></li>
        </ul>


        <div class="treeview__drop" ng-show="$last" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{data.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onAfterDrop()', multiple : true}">
        </div>

    </div>

</script>
<!-- /treeview item -->

<!-- /SCRIPT TEMPLATES -->

<!-- SIDEBAR -->
<div class="luya-container__sidebar sidebar">
    <div ng-controller="CmsMenuTreeController">

        <a class="sidebar__button sidebar__button--positive" ui-sref="custom.cmsadd">
            <div class="sidebar__icon-holder">
                <i class="sidebar__icon material-icons">add</i>
            </div>
            <span class="sidebar__text">Neue Seite erstellen</span>
        </a>

        <a class="sidebar__button sidebar__button--grey" ui-sref="custom.cmsdraft">
            <div class="sidebar__icon-holder">
                <i class="sidebar__icon material-icons">receipt</i>
            </div>
            <span class="sidebar__text">Vorlagen</span>
        </a>

        <div class="sidebar__button sidebar__button--grey sidebar__button--switch switch" ng-class="{ 'sidebar__button--active': showDrag }">
            <label>
                <input type="checkbox" ng-model="showDrag" ng-true-value="1" ng-false-value="0">
                <span class="lever"></span>
                Verschieben
            </label>
        </div>


        <div class="treeview" ng-repeat="catitem in menuData.containers" ng-class="{ 'treeview--drag-active' : showDrag }">
            <h5 class="treeview__title" ng-click="toggleCat(catitem.id)"><i class="material-icons treeview__title-icon" ng-class="{'treeview__title-icon--closed': toggleIsHidden(catitem.id)}">arrow_drop_down</i> <span>{{catitem.name}}</span></h5>
            <!-- 

            <div class="treeview__drop" ng-show="catitem.__items.length == 0 && !toggleIsHidden(catitem.id)" ng-controller="DropNavController" ng-model="droppedNavItem" data-itemid="{{catitem.id}}" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'pointer', hoverClass : 'treeview__drop--hover' }" jqyoui-droppable="{onDrop: 'onEmptyDrop()', multiple : true}"></div>
             -->
            <ul class="treeview__list">
                <li class="treeview__item" ng-repeat="data in menuData.items | menuparentfilter:catitem.id:0" ng-include="'reverse.html'"></li>
            </ul>
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
