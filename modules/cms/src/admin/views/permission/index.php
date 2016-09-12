<?php
use luya\cms\admin\Module;

?>
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
    <h3><?= Module::t('menu_group_item_env_permission'); ?></h3>
    <div class="permissions">
        <table>
            <thead>
                <tr>
                    <th>
                        
                    </th>
                    <th ng-repeat="group in data.groups">
                        <a class="btn btn-floating green permissions__group-button" ng-if="group.fullPermission"><i class="material-icons">check_circle</i></a>
                        <a class="btn btn-floating grey permissions__group-button" ng-click="grantFullPermission(group.id)" ng-if="!group.fullPermission"><i class="material-icons">check_circle</i></a>
                        {{ group.name }}
                    </th>
                </tr>
            </thead>
            <tbody ng-repeat="container in data.containers">
                <tr><td class="permissions__container-spacing"></td></tr>
                <tr class="permissions__container-row">
                    <th colspan="{{data.groups.length + 1}}">{{ container.containerInfo.name }}</th>
                </tr>
                <tr ng-repeat="item in container.items" class="permissions__item-row">
                    <th scope="row" style="padding-left: {{item.nav_level * 20}}px">{{ item.title }}</th>
                    <td ng-repeat="group in item.groups">
                        <!-- {{ group.name }} -->
                        <div ng-if="group.groupFullPermission">
                            <a class="btn btn-floating grey" ng-click="insertPermission(item.id, group.id)"><i class="material-icons">check</i></a>
                            <a class="btn btn-floating grey" ng-click="insertInheritance(item.id, group.id)"><i class="material-icons">playlist_add_check</i></a>
                        </div>
                        <div ng-if="group.isInheritedFromParent && !group.groupFullPermission">
                            <a class="btn btn-floating green disabled"><i class="material-icons">check</i></a>
                            <a class="btn btn-floating green disabled"><i class="material-icons">playlist_add_check</i></a>
                        </div>
                        <div ng-if="!group.isInheritedFromParent && !group.groupFullPermission">
                            <a class="btn btn-floating green" ng-if="group.permissionCheckbox" ng-click="deletePermission(item.id, group.id)"><i class="material-icons">check</i></a>
                            <a class="btn btn-floating red" ng-if="!group.permissionCheckbox" ng-click="insertPermission(item.id, group.id)"><i class="material-icons">check</i></a>

                            <a class="btn btn-floating green" ng-if="group.isGroupPermissionInheritNode" ng-click="deleteInheritance(item.id, group.id)"><i class="material-icons">playlist_add_check</i></a>
                            <a class="btn btn-floating red" ng-if="!group.isGroupPermissionInheritNode" ng-click="insertInheritance(item.id, group.id)"><i class="material-icons">playlist_add_check</i></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
