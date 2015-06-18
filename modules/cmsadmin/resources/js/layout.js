zaa.config(function($stateProvider) {
	$stateProvider
	.state("custom.cmsedit", {
		url : "/update/:navId",
		templateUrl : 'cmsadmin/page/update'
	})
	.state("custom.cmsadd", {
		url : "/create",
		templateUrl : 'cmsadmin/page/create'
	});
});

zaa.service('MenuService', function($http) {
	var service = [];
	
	service.menu = [];
	
	service.cats = [];
	
	service.refresh = function() {
		service.cats = [];
		$http.get('admin/api-cms-menu/all').success(function(response) {
			for (var i in response) {
				service.cats.push({ name : response[i]['name'], id : response[i]['id']});
			}
			service.menu = response;
		});
	}
	
	service.refresh();
	
	return service;
});

zaa.controller("CmsMenuTreeController", function($scope, $state, MenuService, DroppableBlocksService) {
    
	$scope.menu = [];
	
	DroppableBlocksService.load();
	
    $scope.$watch(function() { return MenuService.menu }, function(newValue) {
    	$scope.menu = newValue;
    });
    
    $scope.isCurrentElement = function(navId) {
    	if ($state.params.navId == navId) {
    		return true;
    	}
    	
    	return false;
    }
    
    $scope.go = function(navId) {
    	$state.go('custom.cmsedit', { navId : navId });
    };
});