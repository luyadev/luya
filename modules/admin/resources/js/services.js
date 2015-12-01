// service resolver
function adminServiceResolver(ServiceFoldersData, ServiceImagesData, ServiceFilesData, ServiceFiltersData, ServiceLanguagesData, ServicePropertiesData, AdminLangService) {
	ServiceFoldersData.load();
	ServiceImagesData.load();
	ServiceFilesData.load();
	ServiceFiltersData.load();
	ServiceLanguagesData.load();
	ServicePropertiesData.load();
	AdminLangService.load();
};

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
	
/*

$scope.foldersData = ServiceFoldersData.data;
					
$scope.$on('service:FoldersData', function(event, data) {
	$scope.foldersData = data;
});

$scope.foldersDataReload = function() {
	return ServiceFoldersData.load(true);
}

*/
zaa.factory("ServiceFoldersData", function($http, $q, $rootScope) {
	
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-folders").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:FoldersData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.imagesData = ServiceImagesData.data;
				
$scope.$on('service:ImagesData', function(event, data) {
	$scope.imagesData = data;
});

$scope.imagesDataReload = function() {
	return ServiceImagesData.load(true);
}

*/
zaa.factory("ServiceImagesData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-images").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:ImagesData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.filesData = ServiceFilesData.data;
				
$scope.$on('service:FilesData', function(event, data) {
	$scope.filesData = data;
});

$scope.filesDataReload = function() {
	return ServiceFilesData.load(true);
}
				
*/
zaa.factory("ServiceFilesData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-files").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:FilesData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.filtersData = ServiceFiltersData.data;
				
$scope.$on('service:FiltersData', function(event, data) {
	$scope.filtersData = data;
});

$scope.filtersDataReload = function() {
	return ServiceFiltersData.load(true);
}
				
*/
zaa.factory("ServiceFiltersData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-filters").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:FiltersData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.languagesData = ServiceLanguagesData.data;
				
$scope.$on('service:LanguagesData', function(event, data) {
	$scope.languagesData = data;
});

$scope.languagesDataReload = function() {
	return ServiceLanguagesData.load(true);
}
				
*/
zaa.factory("ServiceLanguagesData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-common/data-languages").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:LanguagesData', service.data);
					resolve(service.data);
				})
			}
		});
	};
	
	return service;
});

/*

$scope.propertiesData = ServicePropertiesData.data;
				
$scope.$on('service:PropertiesData', function(event, data) {
	$scope.propertiesData = data;
});

$scope.propertiesDataReload = function() {
	return ServicePropertiesData.load(true);
}
				
*/
zaa.factory("ServicePropertiesData", function($http, $q, $rootScope) {
	var service = [];
	
	service.data = [];
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data.length > 0 && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-common/data-properties").success(function(response) {
					service.data = response;
					$rootScope.$broadcast('service:PropertiesData', service.data);
					resolve(service.data);
				})
			}
		});
	};
	
	return service;
});

zaa.factory("AdminLangService", function(ServiceLanguagesData) {
	
	var service = [];
	
	service.data = [];
	
	service.selection = [];
	
	service.toggleSelection = function(lang) {
		var exists = service.selection.indexOf(lang.short_code);
		
		if (exists == -1) {
			service.selection.push(lang.short_code);
		} else {
			/* #531: unable to deselect language, as at least 1 langauge must be activated. */
			if (service.selection.length > 1) {
				service.selection.splice(exists, 1);
			}
		}
	};
	
	service.isInSelection = function(langShortCode) {
		var exists = service.selection.indexOf(langShortCode);
		if (exists == -1) {
			return false;
		}
		return true;
	};
	
	service.resetDefault = function() {
		service.selection = [];
		angular.forEach(ServiceLanguagesData.data, function(value, key) {
			if (value.is_default == 1) {
				if (!service.isInSelection(value.short_code)) {
					service.toggleSelection(value);
				}
			}
		})
	}
	service.load = function() {
		ServiceLanguagesData.load().then(function(data) {
			service.data = data;
			
			angular.forEach(data, function(value) {
				if (value.is_default == 1) {
					if (!service.isInSelection(value.short_code)) {
						service.toggleSelection(value);
					}
				}
			})
			
		});
		/*
		service.data = data;
		angular.forEach(data, function(value) {
			if (value.is_default == 1) {
				if (!service.isInSelection(value.short_code)) {
					service.toggleSelection(value);
				}
			}
		})
		*/
	}
	/*
	service.load = function(forceReload) {
		if (service.data.length == 0 || forceReload !== undefined) {
			service.data = ApiAdminLang.query();
			$http.get("admin/api-admin-defaults/lang").success(function(response) {
				if (!service.isInSelection(response.short_code)) {
					service.toggleSelection(response);
				}
			});
		}
	};
	*/
	
	return service;
});

// end of use strict
})();