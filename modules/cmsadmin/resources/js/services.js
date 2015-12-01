/**
 * all global admin services
 * 
 * controller resolve: https://github.com/johnpapa/angular-styleguide#style-y080
 * 
 * Service Inheritance:
 * 
 * 1. Service must be prefix with Service
 * 2. Service must contain a forceReload state
 * 3. Service must broadcast an event 'service:FoldersData'
 * 4. Controller integration must look like
 * 
 * ```
 * $scope.foldersData = ServiceFoldersData.data;
 *				
 * $scope.$on('service:FoldersData', function(event, data) {
 *      $scope.foldersData = data;
 * });
 *				
 * $scope.foldersDataReload = function() {
 *     return ServiceFoldersData.load(true);
 * }
 * ```
 * 
 */
(function() {
	"use strict";
	
zaa.config(function(resolverProvider) {
	resolverProvider.addCallback(function(ServiceMenuData, ServiceBlocksData, ServiceLayoutsData) {
		ServiceMenuData.load();
		ServiceBlocksData.load();
		ServiceLayoutsData.load();
	});
});

/*

$scope.menuData = ServiceMenuData.data;
				
$scope.$on('service:MenuData', function(event, data) {
	$scope.menuData = data;
});

$scope.menuDataReload = function() {
	return ServiceMenuData.load(true);
}
				
*/
zaa.factory("ServiceMenuData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-cms-menu/data-menu").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:MenuData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});


/*

$scope.blocksData = ServiceBlocksData.data;
				
$scope.$on('service:BlocksData', function(event, data) {
	$scope.blocksData = data;
});

$scope.blocksDataReload = function() {
	return ServiceBlocksData.load(true);
}
				
*/
zaa.factory("ServiceBlocksData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-cms-admin/data-blocks").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:BlocksData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});


/*

$scope.layoutsData = ServiceLayoutsData.data;
				
$scope.$on('service:BlocksData', function(event, data) {
	$scope.layoutsData = data;
});

$scope.layoutsDataReload = function() {
	return ServiceLayoutsData.load(true);
}
				
*/
zaa.factory("ServiceLayoutsData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-cms-admin/data-layouts").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:LayoutsData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

// end of use strict
})();