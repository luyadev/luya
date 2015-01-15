<script type="text/ng-template" id="reverse.html">
    <a class="treeview__link" role="link" ng-click="go(data.id)">
        <span class="treeview__icon fa fa-fw fa-file-o"></span>
        {{data.title}}
    </a>
    <ul class="treeview__list" role="menu">
        <li class="treeview__item" role="menuitem" ng-repeat="data in data.nodes" ng-include="'reverse.html'"></li>
    </ul>
</script>

<div class="main__item main__item--left">
    <nav class="treeview" role="navigation">

        <ul class="treeview__list">
            <li class="treeview__item">
                <a class="treeview__link treeview__link--green" ui-sref="custom.cmsadd">
                    <span class="fa fa-plus-circle"></span>
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