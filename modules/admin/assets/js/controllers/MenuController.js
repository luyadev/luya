zaa.controller("MenuController", function ($scope, $http, $state, $location) {
	
	$scope.items = [];
	
	/*
	$scope.itemAdd = function (title, icon, identification, id, template) {
		$scope.items.push({'title' : title , 'icon' : icon, 'identification' : identification, 'id' : id , 'template' : template });
	}
	*/
	
	$scope.currentMenuId = 0;
	
	$scope.itemAdd = function(item) {
		$scope.items.push(item);
	}
	
	$scope.click = function(menuId, $event) {
		//console.log($event.currentTarget);
		//console.log(menuId);
		$scope.currentMenuId = menuId;
		var obj = $scope.items[(menuId-1)];
		if (obj.template) {
			$state.go('custom', { 'templateId' : obj.template });
		} else {
			$state.go('default', { 'moduleId' : menuId});
		}
	}
	
	$scope.get = function () {
		$http.get('admin/api-admin-menu')
		.success(function(data) {
			for (var i in data) {
				item = data[i];
				$scope.itemAdd(item)
			}
			/* $scope.itemAdd(item.title, item.icon, item.identification, item.id); */
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