<script type="text/ng-template" id="reverse.html">
    <div class="treeview__node">
        <span class="treeview__icon treeview__icon--clickable" ng-show="data.nodes" ng-click="toggleChildren($event)"><span class="treeview__icon--open fa fa-fw fa-minus-square"></span><span class="treeview__icon--closed fa fa-fw fa-plus-square"></span></span><!--
     --><span class="treeview__icon" ng-show="!data.nodes"><span class="fa fa-fw fa-file"></span></span><!--
     --><a class="treeview__link" role="link" ng-click="go(data.id)">
            {{data.title}}
        </a>
        <button ng-click="toggleHidden(data)"><i class="fa" ng-class="{ 'fa-toggle-off' : {{data.is_hidden}}, 'fa-toggle-on' : {{data.is_hidden == 0}} }"></i></button>
    </div>
    <ul class="treeview__list" role="menu">
        <li class="treeview__item" role="menuitem" ng-repeat="data in data.nodes" ng-include="'reverse.html'"></li>
    </ul>
</script>

<script type="text/ng-template" id="createform.html">
<div ng-switch on="data.nav_item_type">
<div style="padding:20px; background-color:#F0F0F0; margin:20px;">
<table>
    <tr>
        <td>Titel</td>
        <td><input type="text" ng-model="data.title" placeholder="Hallo Welt" /></td>
    </tr>
    <tr>
        <td>Rewrite</td>
        <td><input type="text" ng-model="data.rewrite" placeholder="hallo-welt" /></td>
    </tr>
    <tr>
        <td>Cat Id</td>
        <td>
            <div ng-if="!data.nav_id">
                <select ng-model="data.cat_id" ng-options="item.id as item.name for item in cat" />
            </div>
            <div ng-if="data.nav_id">
                create page from nav_id: {{data.nav_id}}
            </div>
        </td>
    </tr>
    <!-- people should not create pages for other languages as long as there is not a page in the cms original menu
    <tr>
        <td>Lang Id</td>
        <td>
            <select ng-model="data.lang_id" ng-options="item.id as item.name for item in lang" />
        </td>
    </tr>
    -->
    <tr>
        <td>Parent Nav Id</td>
        <td>
            <div ng-if="!data.nav_id">
                <select ng-model="data.parent_nav_id">
                    <option value="0">[ROOT]</option>
                    <option ng-repeat="nav in navitems" value="{{nav.id}}">{{nav.title}}</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
        <td>Content Nav-Item-Type Id</td>
        <td>
            <input type="radio" ng-model="data.nav_item_type" value="1"> Page<br />
            <input type="radio" ng-model="data.nav_item_type" value="2"> Module<br />
            <input type="radio" ng-model="data.nav_item_type" value="3"> Redirect<br />
        </td>
    </tr>
</table>
</div>
<div ng-switch-when="1">
    <create-form-page data="data"></create-form-page>
</div>

<div ng-switch-when="2">
    <create-form-module data="data"></create-form-module>
</div>

<div ng-switch-when="3">
    Redir
</div>

<div ng-switch-when="true">
    <p>Diese Seite wurde erfolgreich erstellt!
</div>

</div>

</script>

<script type="text/ng-template" id="createformpage.html">
<div style="padding:20px; border:2px solid #F0F0F0; margin:20px;">
<table>
<tr>
    <td>Layout</td>
    <td><select ng-model="data.layout_id" ng-options="lts.id as lts.name for lts in layouts"></select></td>
</tr>
</table>
</div>
<button ng-click="save()">SAVE</button>
</script>

<script type="text/ng-template" id="createformmodule.html">
<div style="padding:20px; border:2px solid #CCC; margin:20px;">
<table>
<tr>
    <td>Module Name (Yii2-ID)</td>
    <td><input type="text" ng-model="data.module_name" /></td>
</tr>
</table>
</div>
<button ng-click="save()">SAVE</button>
</script>

<div class="main__item main__item--left main__item--fixedsize">
    <nav class="treeview main__fixeditem" role="navigation">

        <div class="treeview__toolbar">
            <a class="button button--green" ui-sref="custom.cmsadd">
                <span class="fa fa-fw fa-plus"></span>
                Neue Seite
            </a>
        </div>

        <div ng-controller="CmsMenuTreeController">
            <div ng-repeat="catitem in menu">
                <h2 class="subnav__grouptitle">{{catitem.name}}</h2>
                <ul class="treeview__list" role="menu" >
                    <li class="treeview__item" role="menuitem" ng-repeat="data in catitem.__items" ng-include="'reverse.html'"></li>
                </ul>
            </div>
        </div>

    </nav>
</div><!-- ./main__left
--><div class="main__item main__item--right main__item--fixedsize" ui-view>
</div> <!-- ./main__right -->
