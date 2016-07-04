<script type="text/ng-template" id="reversepermissions.html">
    <table class="bordered">
        <tr>
            <td><strong>{{ data.title }}</strong></td>
            <td ng-repeat="group in groups">
                <div class="input input--single-checkbox">
                    <input name="{{group.name}}" id="{{data.title}}--{{group.name}}" type="checkbox" ng-click="toggleSelection(data, group)" ng-checked="isSelected(data, group)" />
                    <label class="input__label" for="{{data.title}}--{{group.name}}">{{group.name}}</label>
                </div>
            </td>
        </tr>
    </table>
    <ul style="padding-left:15px;">
        <li ng-repeat="data in menuData.items | menuparentfilter:container.id:data.id" ng-include="'reversepermissions.html'" />
    </ul>
</script>
<script>
zaa.bootstrap.register('PermissionController', function($scope, $http, $filter, ServiceMenuData) {

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

	// existing permissions
	
	$scope.loadPermissions = function() {
		$http.get('admin/api-cms-menu/data-permissions').then(function(response) {
			$scope.selection = response.data;
		});
	};
    
	// selections
	
	$scope.toggleSelection = function(data, group) {
        if ($scope.isSelected(data, group)) {
            // delete request
            $http.post('admin/api-cms-menu/data-permission-remove', {navId: data.id, groupId: group.id}).then(function() {
                $scope.loadPermissions();
            });
        } else {
            // insert request
        	 $http.post('admin/api-cms-menu/data-permission-insert', {navId: data.id, groupId: group.id}).then(function() {
        		 $scope.loadPermissions();
        	 });
        }
	};

    $scope.isSelected = function(data, group) {
        if ($scope.selection.hasOwnProperty(data.id)) {
            var result = $filter('filter')($scope.selection[data.id], {group_id: group.id});
            if (result.length > 0) {
                return true; 
            }
        }

        return false;
    };


	// represents selection data {1:navId, groups: [{group_id:1}, {group_id:2}]}
	$scope.selection = {};
    
    // init
    
    $scope.init = function() {
        $scope.loadGroups();
        $scope.loadPermissions();
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