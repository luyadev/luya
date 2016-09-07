<div ng-controller="DefaultController">
    <div class="luya-container__sidebar sidebar">
        <div class="submenu">
            <div class="submenu__item sidebar__button" ng-class="{'sidebar__button--active' :currentItem == null }" ng-click="loadDashboard()">
                <div class="sidebar__icon-holder">
                    <i class="material-icons sidebar__icon">dashboard</i>
                </div>
                <a class="sidebar__text">
                    <small>Dashboard</small>
                </a>
            </div>
            <div ng-repeat="item in items" class="submenu__group">
                <h5 class="sidebar__group-title" ng-if="item.items.length !== 0">{{item.name}}</h5>
                <div class="submenu__item sidebar__button" ng-repeat="sub in item.items" ng-class="{'sidebar__button--active' : sub.route == currentItem.route }" ng-click="click(sub)">
                    <div class="sidebar__icon-holder">
                        <i class="material-icons sidebar__icon">{{sub.icon}}</i>
                    </div>
                    <a class="sidebar__text">
                        {{sub.alias}}
                    </a>
                </div>
            </div>
        </div>
    </div>  <!-- /.luya-sidebar -->

    <div class="luya-container__main">
        <div class="row">
            <div class="col s12" ui-view>
                <div class="editlog">
                    <div class="row" ng-repeat="item in dashboard" ng-controller="DashboardController">
                        <div class="editlog__collapsible z-depth-1">
                            <div class="editlog__collapsible-header"> <i class="material-icons">today</i><span>{{item.day * 1000 | date:"EEEE, dd. MMMM"}}</span></div>
                            <div class="editlog__collapsible-body">
                                <div class="row editlog__collapsible-body-item " ng-repeat="(key, log) in item.items">
                                    <div class="col s6 m3 collapsible-body-item-time truncate">
                                        <span class="btn-floating green small" ng-if="log.is_insert == 1">
                                            <i class="material-icons editlog__icon">note_add</i>
                                        </span>
                                        <span class="btn-floating orange small" ng-if="log.is_update == 1">
                                            <i class="material-icons editlog__icon">create</i>
                                        </span>
                                        <span>{{log.timestamp * 1000 | date:"HH:mm"}}</span>
                                    </div>
                                    <div class="col s6 m3">
                                        <span>{{ log.name }}</span></div>
                                    <div class="col s12 m6 truncate">
                                        <span compile-html ng-bind-html="log.message | trustAsUnsafe"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  <!-- /.luya-main -->
</div>
