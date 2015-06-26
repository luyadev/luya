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

                            <div class="log__day" ng-repeat="item in dashboard">

                                <div class="log__day-header">
                                    <i class="mdi-action-event"></i>
                                    <span>{{item.day * 1000 | date:"EEEE, dd.MM.yyyy"}}</span>
                                </div>

                                <div class="log__entries">

                                    <div class="log__entry" ng-repeat="(key, log) in item.items" ng-switch on="item.items[key - 1] == null || (item.items[key - 1] != null && item.items[key - 1].icon != log.icon)" ng-class="{ 'log__entry--first-of-group' : item.items[key - 1] == null || (item.items[key - 1] != null && item.items[key - 1].icon != log.icon) }">
                                        <div class="log__entry-header" ng-switch-when="true">
                                            <i class="{{log.icon}}"></i>
                                        </div>
                                        <div class="log__entry-body">
                                            <small>
                                                <i class="mdi-social-person"></i>
                                                {{ log.name }}
                                                <span style="width: 20px; display: inline-block;"></span>
                                                <i class="mdi-image-timer"></i>
                                                {{ log.timestamp * 1000 | date:"HH:mm" }} Uhr
                                            </small>
                                            <p>
                                                «{{log.alias}}»
                                                <strong ng-if="log.is_update == 1">bearbeitet.</strong>
                                                <strong ng-if="log.is_insert == 1">hinzugefügt.</strong>
                                            </p>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col s6">

                    </div>

                </div>
            </div>
        </div>
    </div>  <!-- /.luya-main -->
</div>