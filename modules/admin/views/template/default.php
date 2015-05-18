<div class="row" ng-controller="DefaultController">
      <div class="col s12 m4 l2">
        <div class="card-panel blue lighten-5">
            <div ng-repeat="item in items">
                <h5>{{item.name}}</h5>
                <p ng-repeat="sub in item.items"><a ng-click="click(sub)" class="waves-effect waves-teal btn-flat"><i class="mdi-file-cloud left"></i> {{sub.alias}}</a></p>
            </div>
        </div>
      </div>
      <div class="col s12 m8 l10" ui-view>
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col l4" ng-repeat="item in dashboard">
                <div class="card-panel teal">
                    <h5>{{ item.menu.alias }}</h5>
                    <p ng-repeat="log in item.data">{{ log.firstname }} {{ log.lastname}} hat einen Datensatz
                        <strong ng-if="log.is_update == 1">bearbeitet</strong>
                        <strong ng-if="log.is_insert == 1">hinzugefügt</strong>
                        am {{ log.timestamp_create * 1000 | date:"dd.MM.yyyy ' um ' HH:mm" }} Uhr.
                    </p>
                </div>
            </div>
        </div>
      </div>
</div>