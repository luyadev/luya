zaa.controller("MenuController", function ($scope, $http, $state, $location) {
	
	$scope.items = [];
	
	/*
	$scope.itemAdd = function (title, icon, identification, id, template) {
		$scope.items.push({'title' : title , 'icon' : icon, 'identification' : identification, 'id' : id , 'template' : template });
	}
	*/
	
	//$scope.currentMenuId = 0;
	
	$scope.itemAdd = function(item) {
		$scope.items.push(item);
	}
	
	$scope.click = function(menuItem, $event) {
		if (menuItem.template) {
			$state.go('custom', { 'templateId' : menuItem.template });
		} else {
			$state.go('default', { 'moduleId' : menuItem.id});
		}
	}
	
	$scope.get = function () {
		$http.get('admin/api-admin-menu')
		.success(function(data) {
			for (var i in data) {
				item = data[i];
				$scope.itemAdd(item)
			}
		});
	}
	
	$scope.getCurrent = function(menuId) {
		if (menuId == $scope.currentMenuId) {
			return "is-active";
		} else {
			return "";
		}
	}
	
	$scope.get();
});