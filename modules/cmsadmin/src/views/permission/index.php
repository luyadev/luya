<script type="text/ng-template" id="reversepermissions.html">
    <table class="bordered">
        <tr>
            <td><strong>{{ data.title }}</strong></td>
            <td ng-repeat="group in groups">
                <div class="input input--single-checkbox">
                    <input name="{{group.name}}" type="checkbox" />
                    <label class="input__label">{{group.name}}</label>
                </div>
            </td>
        </tr>
    </table>
    <ul style="padding-left:15px;">
        <li ng-repeat="data in menuData.items | menuparentfilter:container.id:data.id" ng-include="'reversepermissions.html'" />
    </ul>
</script>
<script>
zaa.bootstrap.register('PermissionController', function($scope, $http, ServiceMenuData) {

    // service menu data
    
	$scope.menuData = ServiceMenuData.data;
	
	$scope.$on('service:MenuData', function(event, data) {
		$scope.menuData = data;
	});

    // groups
    
    $scope.loadGroups = function() {
        $http.get('admin/api-admin-group').then(function(response) {
            $scope.groups = response.data;
        });
    };

    $scope.groups = null;
    
    // init
    
    $scope.init = function() {
        $scope.loadGroups();
    	ServiceMenuData.load();
    };

    $scope.init();
});
</script>
<div class="card" ng-controller="PermissionController" style="padding:10px; margin-top:10px;">
    <h1>Seiten Zugriffs Berechtigung</h1>
    <div class="treeview" ng-repeat="container in menuData.containers">
        <h5>{{ container.name }}</h5>
        <ul>
            <li ng-repeat="data in menuData.items | menuparentfilter:container.id:0" ng-include="'reversepermissions.html'" />
        </ul>
    </div>
</div>