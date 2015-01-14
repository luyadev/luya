
zaa.config(function($stateProvider) {
	$stateProvider
	.state("custom.cmsedit", {
		url : "/update/:navId",
		templateUrl : 'cmsadmin/page/update',
		controller : 'NavController'
	})
	.state("custom.cmsadd", {
		url : "/create",
		templateUrl : 'cmsadmin/page/create',
		controller : 'CmsadminCreateController'
	});
});


zaa.controller("CmsadminCreateController", function($scope, $stateParams, $resource, ApiCmsNav, ApiCmsNavItemPage) {
	
	$scope.navItemId = 0;
	
	$scope.showType = 0;
	
	$scope.data = {};
	
	$scope.layouts = $resource('admin/api-cms-layout/:id').query();
	
	$scope.getLayouts = function() {
		return $scope.layouts;
	}
	
	$scope.submit = function () {
		$scope.showType = $scope.data.nav_item_type;
	};
	
	$scope.dataPage = {};
	
	$scope.submitPage = function() {
		ApiCmsNavItemPage.save($.param($scope.dataPage), function(rsp) {
			var navItemTypeId = rsp.id;
			
			$scope.data.nav_item_type_id = navItemTypeId;
			
			ApiCmsNav.save($.param($scope.data), function(rsp) {
				$scope.showType = true;
			});
			/*
			Nav.save($.param($scope.data), function(rsp) {
				$scope.navItemId = rsp.id;
				$scope.showType = $scope.data.nav_item_type;
			}, function(error) {
				console.log('Error', error);
			});
			*/
		});
	};
	
	$scope.showDefault = function() {
		$scope.showType = 0;
	}
	
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