<div class="luya-container__angular-placeholder" ng-controller="DefaultController">
    <div class="luya-container__sidebar">
        <div class="row">
            <div class="col s12 submenu">
                <div ng-repeat="item in items" class="submenu__group">
                    <h5 class="submenu__title">{{item.name}}</h5>
                    <div class="submenu__item" ng-repeat="sub in item.items">
                        <a ng-click="click(sub)" ng-class="{'active' : sub.route == currentItem.route }" class="submenu__link [ waves-effect waves-blue ] btn-flat">
                            <i class="{{sub.icon}} left"></i> {{sub.alias}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>  <!-- /.luya-sidebar -->

    <div class="luya-container__main">
        <div class="row">
            <div class="col s12" ui-view>
                <div class="row">   

                    <div class="col s12">

                        <div class="log">
                            <div class="log__day" ng-repeat="item in dashboard" ng-controller="DashboardController" ng-init="logItemOpen = $first">
                                <div class="log__day-header">
                                    <i class="mdi-action-event"></i>
                                    <i class="log__day-toggler mdi-content-add" ng-hide="logItemOpen" ng-click="logItemOpen = true"></i>
                                    <i class="log__day-toggler mdi-content-remove" ng-hide="!logItemOpen" ng-click="logItemOpen = false"></i>
                                    <span>{{item.day * 1000 | date:"EEEE, dd.MM.yyyy"}}</span>
                                </div>

                                <div class="log__entries" ng-hide="!logItemOpen">

                                    <div ng-repeat="(key, log) in item.items" ng-init="
                                        userChanged = item.items[key - 1] == null || (item.items[key - 1] != null && item.items[key - 1].name != log.name);
                                        iconChanged = item.items[key - 1] == null || (item.items[key - 1] != null && item.items[key - 1].icon != log.icon);
                                    ">
                                        <div class="log__entry" style="z-index: {{item.items.length - key}}" ng-class="{ 'log__entry--first-of-group' : userChanged || iconChanged }">

                                            <!-- Show if user or icon changed -->
                                            <div class="log__entry-header" ng-show="userChanged || iconChanged">
                                                <i class="{{log.icon}}"></i>
                                            </div>

                                            <div class="log__entry-body">
                                                <small ng-show="userChanged || iconChanged" class="log__user">
                                                    <i class="mdi-social-person"></i>
                                                    {{ log.name }}
                                                </small>
                                                <p>
                                                    «{{log.alias}}»
                                                    <strong ng-if="log.is_update == 1">bearbeitet.</strong>
                                                    <strong ng-if="log.is_insert == 1">hinzugefügt.</strong>
                                                    <span class="log__time"><i class="mdi-image-timer"></i> {{ log.timestamp * 1000 | date:"HH:mm" }} Uhr</span>
                                                </p>
                                            </div>
                                        </div>
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