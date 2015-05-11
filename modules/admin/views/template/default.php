<div class="row" ng-controller="DefaultController">
      <div class="col s12 m4 l2">
        <div ng-repeat="item in items">
            <ul class="collection with-header">
                <li class="collection-header"><h5>{{item.name}}</h5></li>
                <li class="collection-item" ng-repeat="sub in item.items"><a ng-click="click(sub)">{{sub.alias}}</a></li>
            </ul>
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