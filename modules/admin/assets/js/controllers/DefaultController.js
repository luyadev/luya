zaa.controller("DefaultController", function ($scope, $http, $state, $stateParams) {
	
	$scope.moduleId = $state.params.moduleId;
	
	$scope.items = [];
	
	$scope.itemRoutes = [];
	
	$scope.currentItem = null;
	
	$scope.dashboard = [];
	
	$scope.itemAdd = function (name, items) {
		$scope.items.push({name : name, items : items});
		
		items.forEach(function(data) {
			$scope.itemRoutes[data.route] = {
				alias : data.alias, icon : data.icon
			}
		})
	}
	
	$scope.getDashboard = function(nodeId) {
		$http.get('admin/api-admin-menu/dashboard', { params : { 'nodeId' : nodeId }} )
		.success(function(data) {
			$scope.dashboard = data;
		});
	}
	
	$scope.init = function() {
		$scope.get();
		$scope.getDashboard($scope.moduleId);
	}
	
	$scope.resolveCurrentItem = function() {
		if (!$scope.currentItem) {
			if ($state.current.name == 'default.route') {
				var params = [$stateParams.moduleRouteId, $stateParams.controllerId, $stateParams.actionId];
				var route = params.join("-");
				
				if ($scope.itemRoutes.indexOf(route)) {
					$scope.currentItem = $scope.itemRoutes[route];
				}
			}
		}
	}
	
	$scope.click = function(item) {
		$scope.currentItem = item;
		
		var id = item.route;
		
		var res = id.split("-");
		$state.go('default.route', { moduleRouteId : res[0], controllerId : res[1], actionId : res[2]});
	}
	
	$scope.get = function () {
		$http.get('admin/api-admin-menu/items', { params : { 'nodeId' : $scope.moduleId }} )
		.success(function(data) {
			for (var itm in data.groups) {
				grp = data.groups[itm];				
				$scope.itemAdd(grp.name, grp.items);
			}
			$scope.resolveCurrentItem();
		})
		.error(function(data) {
			console.log('error', data);
		});
	}
	
	$scope.init();
});