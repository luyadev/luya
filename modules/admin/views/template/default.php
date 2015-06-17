<div class="luya-container__angular-placeholder" ng-controller="DefaultController">
    <div class="luya-container__sidebar">
        <div class="row">
            <div class="col s12 submenu">
                <div ng-repeat="item in items" class="submenu__group">
                    <h5 class="submenu__title">{{item.name}}</h5>
                    <div class="submenu__item" ng-repeat="sub in item.items">
                        <a ng-click="click(sub)" ng-class="{'active' : isActiveElement(sub) }" class="submenu__link [ waves-effect waves-teal ] btn-flat">
                            <i class="{{sub.icon}}"></i> {{sub.alias}}
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
                        <div class="card-panel blue lighten-5" ng-repeat="item in dashboard">
                            <h5>{{item.day * 1000 | date:"dd.MM.yyyy"}}</h5>
                            <ul>
                                <li ng-repeat="log in item.items">
                                    <i class="{{log.icon}}"></i> 
                                    {{ log.name }}</i> hat  am {{ log.timestamp * 1000 | date:"dd.MM.yyyy ' um ' HH:mm" }} Uhr einen Datensatz in <i>{{log.alias}}</i> 
                                    <strong ng-if="log.is_update == 1">bearbeitet</strong>
                                    <strong ng-if="log.is_insert == 1">hinzugefügt</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  <!-- /.luya-main -->
</div>