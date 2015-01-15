<script type="text/ng-template" id="reverse.html">
    <a class="treeview__link" role="link" ng-click="go(data.id)">
        <span class="treeview__icon fa fa-fw fa-file-o"></span>
        {{data.title}}
    </a>
    <ul class="treeview__list" role="menu">
        <li class="treeview__item" role="menuitem" ng-repeat="data in data.nodes" ng-include="'reverse.html'"></li>
    </ul>
</script>

<script type="text/ng-template" id="create.html">
<div ng-switch on="showType">
<form ng-submit="submit()" ng-switch-default>
<h2>Nav_ITEM</h2>
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
        <td><input type="text" ng-model="data.parent_nav_id" placeholder="0" /></td>
    </tr>
    <tr>
        <td>Cat Id</td>
        <td><input type="text" ng-model="data.cat_id" placeholder="1" /></td>
    </tr>
    <tr>
        <td>Lang Id</td>
        <td><input type="text" ng-model="data.lang_id" placeholder="" /></td>
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
        <td><button type="submit">Submit</button></td>
    </tr>
</table>
</form>

<form ng-switch-when="1" ng-submit="submitPage()">
<h2>TYPE_PAGE</h2>
<select ng-model="dataPage.layout_id" ng-options="lts.id as lts.name for lts in getLayouts()">

</select>
<button type="submit">SUBMIT</button>
</form>

<form ng-switch-when="2">
<h2>REDIRECT</h2>
</form>

<form ng-switch-when="3">
<h2>MODULE</h2>
</form>

<div ng-switch-when="true">
    <h2>Yes!</h2>
    <p>Sie haben erfolgreich eine neue Seite hinzugefügt!</p>
    <a ng-click="showDefault()" href="#">ADD NEW ITEM</a>
</div>

</div>
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

        <ul class="treeview__list" role="menu" ng-controller="TreeController">
            <li class="treeview__item" role="menuitem" ng-repeat="data in tree" ng-include="'reverse.html'">
            </li>

        </ul> <!-- ./treeview__list -->

    </nav>
</div><!-- ./main__left
--><div class="main__item main__item--right" ui-view>
</div> <!-- ./main__right -->
