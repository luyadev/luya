<div ng-controller="DraftsController">
    <div class="row">
        <div class="col s12">
            <h1>Vorlagen</h1>
            <ul>
                <li ng-repeat="item in menuData.drafts" ng-click="go(item.id)">{{ item.title }}</li>
            </ul>
        </div>
    </div>
</div>