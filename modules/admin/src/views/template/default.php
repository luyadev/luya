<div class="luya-subnav" ng-controller="DefaultController">
    <div class="modulenav">
        <div class="modulenav-group">
            <ul class="modulenav-list">
                <li class="modulenav-item">
                    <span class="modulenav-link" ng-class="{'modulenav-link-active' :currentItem == null }" ng-click="loadDashboard()">
                        <i class="modulenav-icon material-icons">dashboard</i>
                        <span class="modulenav-label">
                            Dashboard
                        </span>
                    </span>
                </li>
            </ul>
        </div>
        <div class="modulenav-group" ng-repeat="item in items" class="submenu-group">
            <span class="modulenav-group-title">{{item.name}}</span>
            <ul class="modulenav-list">
                <li class="modulenav-item" ng-repeat="sub in item.items">
                    <span class="modulenav-link" ng-click="click(sub)"  ng-class="{'modulenav-link-active' : sub.route == currentItem.route }">
                        <i class="modulenav-icon material-icons">{{sub.icon}}</i>
                        <span class="modulenav-label">
                            {{sub.alias}}
                        </span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="luya-content" ui-view></div>