<script type="text/ng-template" id="reverse.html">
    <a class="waves-effect waves-teal btn-flat" ng-click="go(data.id)">
            {{data.title}}
        </a>
    <ul class="treeview__list" role="menu" style="margin-left:20px;">
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
<a class="btn-floating btn-large waves-effect waves-light red" style="position:absolute; margin-left:334px; margin-top:20px;" ui-sref="custom.cmsadd"><i class="mdi-content-add"></i></a>
<div class="row">
      <div class="col s12 m4 l2">
            
            <div ng-controller="CmsMenuTreeController">
                <div ng-repeat="catitem in menu" class="card-panel blue lighten-5">
                    <h5 style="text-transform: uppercase">{{catitem.name}}</h5>
                    <ul>
                        <li ng-repeat="data in catitem.__items" ng-include="'reverse.html'"></li>
                    </ul>
                </div>
            </div>
      </div>
      <div class="col s12 m8 l10" ui-view></div>
</div>