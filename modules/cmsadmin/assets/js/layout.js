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

zaa.controller("TreeController", function($scope, $state, ApiCmsMenu) {
    
    $scope.tree = [];
    
    $scope.go = function(navId) {
    	$state.go('custom.cmsedit', { navId : navId });
    };
    
    var entries = ApiCmsMenu.get(function() {
        $scope.tree = entries;
     });
  
});