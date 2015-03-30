zaa.controller("DefaultController", function ($scope, $http, $state, $stateParams, AdminService) {
	
	$scope.moduleId = $state.params.moduleId;
	
	$scope.items = [];
	
	$scope.itemRoutes = [];
	
	$scope.currentItem = null;
	
	$scope.itemAdd = function (name, items) {
		$scope.items.push({name : name, items : items});
		
		items.forEach(function(data) {
			$scope.itemRoutes[data.route] = {
				alias : data.alias, icon : data.icon
			}
		})
	}
	
	$scope.init = function() {
		$scope.get();
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
		AdminService.bodyClass = '';
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