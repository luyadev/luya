<script type="text/ng-template" id="reverse.html">
    <a class="treeview__link" role="link" ng-click="go(data.id)">
        <span class="treeview__icon fa fa-fw fa-file-o"></span>
        {{data.title}}
    </a>
    <ul class="treeview__list" role="menu">
        <li class="treeview__item" role="menuitem" ng-repeat="data in data.nodes" ng-include="'reverse.html'"></li>
    </ul>
</script>

<script type="text/ng-template" id="createform.html">
<div ng-switch on="showType">

<div ng-switch-default>
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
        <td>Parent Nav Id</td>
        <td><div ng-if="!data.nav_id"><input type="text" ng-model="data.parent_nav_id" placeholder="0" /></div></td>
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
    <tr>
        <td>Lang Id</td>
        <td>
            <select ng-model="data.lang_id" ng-options="item.id as item.name for item in lang" />
        </td>
    </tr>
    <tr>
        <td>Content Nav-Item-Type Id</td>
        <td>
            <select ng-model="data.nav_item_type">
                <option value="1" selected>Page</option>
                <option value="2">Redirect</option>
                <option value="3">Module</option>
            </select>
        </td>
    </tr>
    <tr>
        <td><button ng-click="showTypeContainer()">NEXT</button></td>
    </tr>
</table>
</div>

<div ng-switch-when="1">
    <create-form-page data="data"></create-form-page>
</div>

<div ng-switch-when="2">
    REDIR!
</div>

<div ng-switch-when="3">
    MODULE!
</div>

<div ng-switch-when="true">
    <p>Diese Seite wurde erfolgreich erstellt!
</div>

</div>

</script>

<script type="text/ng-template" id="createformpage.html">
<table>
<tr>
    <td>Layout</td>
    <td><select ng-model="data.layout_id" ng-options="lts.id as lts.name for lts in layouts"></select></td>
</tr>
</table>
<button ng-click="save()">SAVE</button>
</script>


<div class="main__item main__item--left">
    <nav class="treeview" role="navigation">

        <ul class="treeview__list">
            <li class="treeview__item">
                <a class="treeview__link treeview__link--green" ui-sref="custom.cmsadd">
                    <span class="fa fa-fw fa-plus-circle"></span>
                    Neue Seite
                </a>
            </li>
        </ul>

        <ul class="treeview__list" role="menu" ng-controller="CmsMenuTreeController">
            <li class="treeview__item" role="menuitem" ng-repeat="data in tree" ng-include="'reverse.html'"></li>
        </ul> <!-- ./treeview__list -->

    </nav>
</div><!-- ./main__left
--><div class="main__item main__item--right" ui-view>
</div> <!-- ./main__right -->
