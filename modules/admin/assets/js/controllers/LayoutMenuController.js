zaa.controller("LayoutMenuController", function ($scope, $http, $state, $location) {
	
	$scope.items = [];
	
	$scope.click = function(menuItem, $event) {
		if (menuItem.template) {
			$state.go('custom', { 'templateId' : menuItem.template });
		} else {
			$state.go('default', { 'moduleId' : menuItem.id});
		}
	}
	
	$scope.isActive = function(item) {
		if (item.template) {
			if ($state.params.templateId == item.template) {
				return true;
			}
		} else {
			if ($state.params.moduleId == item.id) {
				return true;
			}
		}
	}
	
	$scope.get = function () {
		$http.get('admin/api-admin-menu')
		.success(function(data) {
			$scope.items = data;
		});
	}
	
	$scope.get();
});