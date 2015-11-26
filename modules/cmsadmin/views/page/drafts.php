<div ng-controller="DraftsController" class="page" style="margin:20px;">
    <div class="row">
        <div class="col s12">
            <h1>Vorlagen</h1>
            <table class="striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Titel</th>
                    <th>Aktion</th>
                </tr>
                </thead>
                <tr ng-repeat="item in menuData.drafts">
                    <td>{{item.id}}</td>
                    <td>{{item.title}}</td>
                    <td><button type="button" ng-click="go(item.id)" class="btn btn-flat">Bearbeiten</button>
                </tr>
            </table>
        </div>
    </div>
</div>