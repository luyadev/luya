<div class="luya__subnav" ng-controller="DefaultController">
    <div class="modulenav">
        <div class="modulenav__group">
            <ul class="modulenav__list">
                <li class="modulenav__item">
                    <span class="modulenav__link" ng-class="{'modulenav__link--active' :currentItem == null }" ng-click="loadDashboard()">
                        <i class="modulenav__icon material-icons">dashboard</i>
                        <span class="modulenav__label">
                            Dashboard
                        </span>
                    </span>
                </li>
            </ul>
        </div>
        <div class="modulenav__group" ng-repeat="item in items" class="submenu__group">
            <span class="modulenav__group-title">{{item.name}}</span>
            <ul class="modulenav__list">
                <li class="modulenav__item" ng-repeat="sub in item.items">
                    <span class="modulenav__link" ng-click="click(sub)"  ng-class="{'modulenav__link--active' : sub.route == currentItem.route }">
                        <i class="modulenav__icon material-icons">{{sub.icon}}</i>
                        <span class="modulenav__label">
                            {{sub.alias}}
                        </span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="luya__content" ui-view></div>