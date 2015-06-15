<div class="luya-container__angular-placeholder" ng-controller="DefaultController">
    <div class="luya-container__sidebar">
        <div class="row">
            <div class="col s12">
                <div ng-repeat="item in items">
                    <h5>{{item.name}}</h5>
                    <p ng-repeat="sub in item.items"><a ng-click="click(sub)" class="waves-effect waves-teal btn-flat"><i class="mdi-file-cloud left"></i> {{sub.alias}}</a></p>
                </div>
            </div>
        </div>
    </div>  <!-- /.luya-sidebar -->

    <div class="luya-container__main">
        <div class="row">
            <div class="col s12" ui-view>
                <div class="row">
                    
                    <div ng-repeat="item in dashboard">
                        <div class="col s6">
                            <div class="card-panel  blue lighten-5">
                                <h5>{{ item.menu.alias }}</h5>
                                <p ng-repeat="log in item.data"><i>{{ log.firstname }} {{ log.lastname}}</i> hat einen Datensatz
                                    <strong ng-if="log.is_update == 1">bearbeitet</strong>
                                    <strong ng-if="log.is_insert == 1">hinzugefügt</strong>
                                    am {{ log.timestamp_create * 1000 | date:"dd.MM.yyyy ' um ' HH:mm" }} Uhr.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>  <!-- /.luya-main -->
</div>