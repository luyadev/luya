<div class="main__item main__item--left">

    <nav class="subnav main__fixeditem" role="navigation" ng-controller="DefaultController" ng-init="get()">
        <div class="subnav__group" ng-repeat="item in items">

            <h2 class="subnav__grouptitle">{{item.name}}</h2>
            <ul class="subnav__list" role="menu" ng-repeat="sub in item.items" on-finish="onSubMenuFinish">

                <li class="subnav__item" role="menuitem">
                    <a class="subnav__link" role="link" ng-click="click(sub.route)">
                        <span class="subnav__text fa fa-fw {{sub.icon}}">{{sub.alias}}</span>
                    </a>
                </li> <!-- ./subnav__item -->

            </ul> <!-- ./subnav__list -->

        </div> <!-- ./subnav__group -->
    </nav> <!-- ./subnav -->

</div><!-- ./main__left
--><div class="main__item main__item--right" ui-view>
</div> <!-- ./main__right -->
