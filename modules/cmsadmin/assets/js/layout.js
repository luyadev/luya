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

zaa.service('MenuService', function($rootScope, ApiCmsMenu) {
	var service = [];
	
	service.tree = [];
	
	service.refresh = function() {
		ApiCmsMenu.get(function(response) {
			service.tree = response;
		});
	}
	
	service.refresh();
	
	return service;
});

zaa.controller("CmsMenuTreeController", function($scope, $state, MenuService) {
    
	$scope.tree = [];
	
    $scope.$watch(function() { return MenuService.tree }, function(newValue) {
    	$scope.tree = newValue;
    })
	
    $scope.go = function(navId) {
    	$state.go('custom.cmsedit', { navId : navId });
    };

    $scope.toggleChildren = function($event) {
        // todo: Remove parentNode.parentNode
        // todo: Not really the "angular way"?
        $event.currentTarget.parentNode.parentNode.classList.toggle( "treeview__item--is-open" );
    }
    
});