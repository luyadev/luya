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
	
	service.refresh = function() {
		
		$http.get('admin/api-cms-menu/all').success(function(response) {
			service.menu = response;
		});
	}
	
	service.refresh();
	
	return service;
});

zaa.controller("CmsMenuTreeController", function($scope, $state, $http, MenuService) {
    
	$scope.menu = [];
	
    $scope.$watch(function() { return MenuService.menu }, function(newValue) {
    	$scope.menu = newValue;
    })
    
    $scope.toggleHidden = function(dataItem) {
    
    	$http.get('admin/api-cms-nav/toggle-hidden', { params : { navId : dataItem.id }}).success(function(response) {
			MenuService.refresh();
		});
    }
	
    $scope.go = function(navId) {
    	$state.go('custom.cmsedit', { navId : navId });
    };

    $scope.toggleChildren = function($event) {
        // todo: Remove parentNode.parentNode
        // todo: Not really the "angular way"?
        $event.currentTarget.parentNode.parentNode.classList.toggle( "treeview__item--is-open" );
    }
    
});