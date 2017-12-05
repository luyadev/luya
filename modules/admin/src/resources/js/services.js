// service resolver
function adminServiceResolver(ServiceFoldersData, ServiceImagesData, ServiceFilesData, ServiceFiltersData, ServiceLanguagesData, ServicePropertiesData, AdminLangService, ServiceFoldersDirecotryId) {
	ServiceFiltersData.load();
	ServiceFoldersData.load();
	ServiceImagesData.load();
	ServiceFilesData.load();
	ServiceLanguagesData.load();
	ServicePropertiesData.load();
	AdminLangService.load();
	ServiceFoldersDirecotryId.load();
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
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-folders").then(function(response) {
					service.data = response.data;
					$rootScope.$broadcast('service:FoldersData', service.data);
					resolve(service.data);
				});
			}
		});
	};
	
	return service;
});

/*

$scope.folderId = ServiceFoldersDirecotryId.folderId;
					
$scope.$on('FoldersDirectoryId', function(event, folderId) {
	$scope.folderId = folderId;
});

$scope.foldersDirecotryIdReload = function() {
	return ServiceFoldersDirecotryId.load(true);
}

*/
zaa.factory("ServiceFoldersDirecotryId", function($http, $q, $rootScope) {
	
	var service = [];
	
	service.folderId = false;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.folderId !== false && forceReload !== true) {
				resolve(service.folderId);
			} else {
				$http.get("admin/api-admin-common/get-filemanager-folder-state").then(function(response) {
					service.folderId = response.data;
					$rootScope.$broadcast('service:FoldersDirectoryId', service.folderId);
					resolve(service.folderId);
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
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-images").then(function(response) {
					service.data = response.data;
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
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-storage/data-files").then(function(response) {
					service.data = response.data;
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
				$http.get("admin/api-admin-storage/data-filters").then(function(response) {
					service.data = response.data;
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
				$http.get("admin/api-admin-common/data-languages").then(function(response) {
					service.data = response.data;
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
	
	service.data = null;
	
	service.load = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data !== null && forceReload !== true) {
				resolve(service.data);
			} else {
				$http.get("admin/api-admin-common/data-properties").then(function(response) {
					service.data = response.data;
					$rootScope.$broadcast('service:PropertiesData', service.data);
					resolve(service.data);
				})
			}
		});
	};
	
	return service;
});

zaa.factory("CrudTabService", function() {
	
	var service = [];
	
	service.tabs = [];
	
	service.remove = function(index, $scope) {
		service.tabs.splice(index, 1);
		
		if (service.tabs.length > 0) {
			var lastTab = service.tabs.slice(-1)[0];
			lastTab.active = true;
		} else {
			$scope.switchTo(0);
		}
	};
	
	service.addTab = function(id, api, arrayIndex, name, modelClass) {
		var tab = {id: id, api: api, arrayIndex: arrayIndex, active: true, name: name, modelClass:modelClass};
		
		angular.forEach(service.tabs, function(item) {
			item.active = false;
		});
		
		service.tabs.push(tab);
		
	};
	
	service.clear = function() {
		service.tabs = [];
	};
	
	return service;
});

/*
 
 language service with selections
 
*/
zaa.factory("AdminLangService", function(ServiceLanguagesData, $rootScope) {
	
	var service = [];
	
	service.data = [];
	
	service.selection = [];
	
	service.toggleSelection = function(lang) {
		var exists = service.selection.indexOf(lang.short_code);
		
		if (exists == -1) {
			service.selection.push(lang.short_code);
			$rootScope.$broadcast('service:LoadLanguage', lang);
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
	};
	
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
	};
	
	return service;
});

/*
 * Admin Debug Bar provides an array with debug information from the last request in order to find bugs without the developer tools of the browser 
 */
zaa.factory("AdminDebugBar", function() {
	
	var service = [];
	
	service.data = [];
	
	service.clear = function() {
		service.data = [];
	};
	
	service.pushRequest = function(request) {
		return service.data.push({'url': request.url, 'requestData': request.data, 'responseData': null, 'responseStatus' : null, start:new Date(), end:null, parseTime: null});
	};
	
	service.pushResponse = function(response) {
		var responseCopy = response;
		
		var serviceData = service.data[responseCopy.config.debugId];
		
		if (serviceData) {
			serviceData.responseData = responseCopy.data;
			serviceData.responseStatus = responseCopy.status;
			serviceData.end = new Date();
			serviceData.parseTime = new Date() - serviceData.start;
		}
		
		return response;
	};
	
	return service;
});

/*

$scope.filesData = ServiceFilesData.data;
				
$scope.$on('service:AdminToast', function(event, data) {
	$scope.filesData = data;
});

Examples

AdminToastService.notify('Hello i am Message and will be dismissed in 2 Seconds');

AdminToastService.confirm('Hello i am a callback and wait for your', 'Das löschen?', function($q, $http) {
	// do some ajax call
	$http.get().then(function() {
		promise.resolve();
	}).error(function() {
		promise.reject();
	});
});

you can also close this dialog by sourself in the callback

AdminToastService.confirm('Message', function() {
	// do something
	this.close();
});

instead of this you can also invoke $toast

function($toast) {
	$toast.close();
}

*/
zaa.factory("AdminToastService", function($q, $timeout, $injector) {
	var service = [];
	
	service.notify = function(message, timeout, type) {
		
		if (timeout == undefined) {
			timeout = 6000;
		}
		
		var uuid = guid();
		
		service.queue[uuid] = {message: message, timeout: timeout, uuid: uuid, type: type, close: function() {
			delete service.queue[this.uuid];
		}};
		
		$timeout(function() {
			delete service.queue[uuid];
		}, timeout);
	};
	
	service.success = function(message, timeout) {
		service.notify(message, timeout, 'success');
	};

    service.info = function(message, timeout) {
        service.notify(message, timeout, 'info');
    };

    service.warning = function(message, timeout) {
        service.notify(message, timeout, 'warning');
    };
	
	service.error = function(message, timeout) {
		service.notify(message, timeout, 'error');
	};
	
	service.errorArray = function(array, timeout) {
		angular.forEach(array, function(value, key) {
			service.error(value.message, timeout);
		});
	};
	
	service.confirm = function(message, title, callback) {
		var uuid = guid();
		service.queue[uuid] = {message: message, title:title, click: function() {
			var queue = this;
			var response = $injector.invoke(this.callback, this, { $toast : this });
			if (response !== undefined) {
				response.then(function(r) {
						queue.close();
					}, function(r) {
						queue.close();
					}, function(r) {
						// call loader later?
					});
			}
		}, uuid: uuid, callback: callback, type: 'confirm', close: function() {
			delete service.queue[this.uuid];
		}}
	};
	
	service.queue = {};
	
	return service;
});

/*
 * 
 * Saving data in Html Storage
 * 
 *	$scope.isHover = HtmlStorage.getValue('sidebarToggleState', false); 
 *		
 *	$scope.toggleMainNavSize = function() {
 *	    $scope.isHover = !$scope.isHover;
 *	    HtmlStorage.setValue('sidebarToggleState', $scope.isHover);
 *	}
 */
zaa.factory('HtmlStorage', function() {
	var service = {
		
		data: {},
		
		isLoaded : false,
		
		loadData : function() {
			if (!service.isLoaded) {
				if (localStorage.getItem("HtmlStorage")) {
					var data = angular.fromJson(localStorage.getItem('HtmlStorage'));
					
					service.data = data;
				}
			}
		},
		
		saveData : function() {
			localStorage.removeItem('HtmlStorage');
			localStorage.setItem('HtmlStorage', angular.toJson(service.data));
		},
		
		getValue : function(key, defaultValue) {
			service.loadData();
			
			if (service.data.hasOwnProperty(key)) {
				return service.data[key];
			}
			
			return defaultValue;
		},
		
		setValue : function(key, value) {
			service.loadData();
			
			service.data[key] = value;
			
			service.saveData();
		}
	};
	
	return service;
});

// end of use strict
})();