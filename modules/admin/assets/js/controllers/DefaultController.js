zaa.controller("DefaultController", function ($scope, $http, $state, AdminService) {
	
	$scope.moduleId = $state.params.moduleId;
	
	$scope.items = [];
	
	$scope.itemAdd = function (name, items) {
		$scope.items.push({name : name, items : items});
	}
	
	$scope.click = function(id) {
		
		var res = id.split("-");
		$state.go('default.route', { moduleRouteId : res[0], controllerId : res[1], actionId : res[2]});
		AdminService.bodyClass = '';
	}
	
	$scope.get = function () {
		$http.get('admin/api-admin-menu/items', { params : { 'nodeId' : $scope.moduleId }} )
		.success(function(data) {
			for (var itm in data.groups) {
				grp = data.groups[itm];
				$scope.itemAdd(grp.name, grp.items);
			}
		})
		.error(function(data) {
			console.log('error', data);
		});
	}
});