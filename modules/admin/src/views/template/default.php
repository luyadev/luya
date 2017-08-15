<div class="luya-main luya-main-crud" ng-controller="DefaultController">
    <div class="luya-subnav">
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
    <div class="luya-content" ui-view>
        <h1>Dashboard</h1>
        <div class="card-columns">
            <div class="card" ng-repeat="item in dashboard">
                <div class="card-body">
                    <h3 class="card-title">{{item.day * 1000 | date:"EEEE, dd. MMMM"}}</span></h3>
                    <table class="table">
                        <tr ng-repeat="(key, log) in item.items">
                            <td>
                                <i class="material-icons" ng-if="log.is_insert == 1">note_add</i>
                                <i class="material-icons" ng-if="log.is_update == 1">create</i>
                            </td>
                            <td>{{log.timestamp * 1000 | date:"HH:mm"}}</td>
                            <td>{{ log.name }}</td>
                            <td><span compile-html ng-bind-html="log.message | trustAsUnsafe"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>