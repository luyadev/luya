<script type="text/ng-template" id="recursiveperm.html">
    <li style="margin-left:15px;">
        <table>
        <tr ng-if="containerIndex==0 && innerIndex ==0">
            <td>&nbsp</td>
            <td ng-repeat="group in groupInjection" width="160">
                <a class="btn btn-floating green" ng-if="group.fullPermission"><i class="material-icons">check_circle</i></a>
                <a class="btn btn-floating grey" ng-click="grantFullPermission(group.id)" ng-if="!group.fullPermission"><i class="material-icons">check_circle</i></a>
                <strong>{{group.name}}</strong>
            </td>
        </tr>
        <tr>
        <td width="100"><strong>{{ data.title }}</strong></td>
        <td ng-repeat="group in data.groups" width="160">
            <div ng-if="group.groupFullPermission">
                <a class="btn btn-floating grey" ng-click="insertPermission(data.id, group.id)"><i class="material-icons">check</i></a>
                <a class="btn btn-floating grey" ng-click="insertInheritance(data.id, group.id)"><i class="material-icons">playlist_add_check</i></a>
            </div>
            <div ng-if="group.isInheritedFromParent && !group.groupFullPermission">
                <a class="btn btn-floating grey disabled"><i class="material-icons">check</i></a>
                <a class="btn btn-floating grey disabled"><i class="material-icons">playlist_add_check</i></a>
            </div>
            <div ng-if="!group.isInheritedFromParent && !group.groupFullPermission">
                <a class="btn btn-floating green" ng-if="group.permissionCheckbox" ng-click="deletePermission(data.id, group.id)"><i class="material-icons">check</i></a>
                <a class="btn btn-floating red" ng-if="!group.permissionCheckbox" ng-click="insertPermission(data.id, group.id)"><i class="material-icons">check</i></a>

                <a class="btn btn-floating green" ng-if="group.isGroupPermissionInheritNode" ng-click="deleteInheritance(data.id, group.id)"><i class="material-icons">playlist_add_check</i></a>
                <a class="btn btn-floating red" ng-if="!group.isGroupPermissionInheritNode" ng-click="insertInheritance(data.id, group.id)"><i class="material-icons">playlist_add_check</i></a>
            </div>
        </td>
        </tr>
        </table>
        <ul style="margin:0px; padding:0px;" ng-repeat="data in data.__children" ng-include="'recursiveperm.html'" />
    </li>
</script>
<script>
zaa.bootstrap.register('PermissionController', function($scope, $http) {

	$scope.$on('service:MenuData', function(event, data) {
		$scope.loadPermissions();
	});

    $scope.data = null;

    $scope.groupInjection = null;
    
	$scope.loadPermissions = function() {
		$http.get('admin/api-cms-menu/data-permission-tree').then(function(response) {
            $scope.data = response.data;
            $scope.groupInjection = response.data.groups;
		});
	};

    $scope.deletePermission = function(navId, groupId) {
    	// delete request
        $http.post('admin/api-cms-menu/data-permission-delete', {navId: navId, groupId: groupId}).then(function() {
            $scope.loadPermissions();
        });
    };

    $scope.insertPermission = function(navId, groupId) {
    	$http.post('admin/api-cms-menu/data-permission-insert', {navId: navId, groupId: groupId}).then(function() {
    	    $scope.loadPermissions();
    	});
    };

    $scope.deleteInheritance = function(navId, groupId) {
    	$http.post('admin/api-cms-menu/data-permission-delete-inheritance', {navId: navId, groupId: groupId}).then(function() {
    		$scope.loadPermissions();
        });
    };
    
    $scope.insertInheritance = function(navId, groupId) {
    	$http.post('admin/api-cms-menu/data-permission-insert-inheritance', {navId: navId, groupId: groupId}).then(function() {
    		$scope.loadPermissions();
        });
    };

    $scope.grantFullPermission = function(groupId) {
        $http.post('admin/api-cms-menu/data-permission-grant-group', {groupId: groupId}).then(function() {
            $scope.loadPermissions();
        });
    }
    
    $scope.init = function() {
        $scope.loadPermissions();
    };

    $scope.init();
});
</script>

<div ng-controller="PermissionController" class="card-panel">
    <h1>CMS Page Permissions</h1>
    <div ng-repeat="container in data" ng-init="containerIndex=$index">
        <h4>{{ container.container.name }}</h4>
        <ul ng-repeat="data in container.items" ng-init="innerIndex=$index" ng-include="'recursiveperm.html'" />
    </div>
</div>