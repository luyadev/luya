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
				service.cats.push({ name : response[i]['name'], id : parseInt(response[i]['id'])});
			}
			service.menu = response;
		});
	}
	
	service.refresh();
	
	return service;
});

zaa.controller("DropNavController", function($scope, $http, MenuService) {
	
	$scope.droppedNavItem = null;
	
    $scope.onDrop = function($event, $ui) {
    	var itemid = $($event.target).data('itemid');
		//console.log('dropped block beofre itemid: ' + itemid, 'theblock', $scope.droppedNavItem);
		$http.get('admin/api-cms-navitem/move', { params : { moveItemId : $scope.droppedNavItem.id, droppedBeforeItemId : itemid }}).success(function(r) {
			MenuService.refresh();
		}).error(function(r) {
			console.log('err', r)
		})
    }
    
    $scope.onChildDrop = function($event, $ui) {
    	var itemid = $($event.target).data('itemid');
		//console.log('dropped block beofre itemid: ' + itemid, 'theblock', $scope.droppedNavItem);
		$http.get('admin/api-cms-navitem/move-to-child', { params : { moveItemId : $scope.droppedNavItem.id, droppedOnItemId : itemid }}).success(function(r) {
			MenuService.refresh();
		}).error(function(r) {
			console.log('err', r)
		})
    }
})

zaa.controller("CmsMenuTreeController", function($scope, $state, MenuService, DroppableBlocksService, AdminLangService, CmsLayoutService) {
    
	CmsLayoutService.load();
	
	$scope.AdminLangService = AdminLangService;
	
	$scope.AdminLangService.load(true);
	
	$scope.menu = [];
	
	$scope.showDrag = false;
	
	$scope.toggleDrag = function() {
		$scope.showDrag = !$scope.showDrag;
	}
	
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
    
    /* drag & drop integration */
    
    $scope.onStart = function() {
	};
	
	$scope.onStop = function() {
	};
});