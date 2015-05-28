zaa.factory('authInterceptor', function($rootScope, $q) {
	return {
		request : function (config) {
			config.headers = config.headers || {};
			config.headers.Authorization = 'Bearer ' + authToken;
			return config;
		},
		responseError : function(data) {
			if (data.status == 401) {
				window.location = 'admin/default/logout';
			}
			return $q.reject(data);
		}
	};
});

zaa.factory('ApiAdminLang', function($resource) {
	return $resource('admin/api-admin-lang/:id', { id: '@_id' }, {
		save : {
			method : 'POST',
			isArray : false,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}
	});
});

zaa.factory('AdminLangService', function(ApiAdminLang) {
	var service = [];
	
	service.data = [];
	
	service.selection = [];
	
	service.toggleSelection = function(lang) {
		var exists = service.selection.indexOf(lang.short_code);
		if (exists == -1) {
			service.selection.push(lang.short_code);
		} else {
			service.selection.splice(exists, 1);
		}
	}
	
	service.isInSelection = function(lang) {
		var exists = service.selection.indexOf(lang.short_code);
		if (exists == -1) {
			return false;
		}
		return true;
	}
	
	service.load = function() {
		if (service.data.length == 0) {
			service.data = ApiAdminLang.query();
			console.log('AdminLangService loading data', service.data);
		}
	}
	
	return service;
});

zaa.factory('ApiAdminFilter', function($resource) {
	return $resource('admin/api-admin-filter/:id', { id: '@_id' }, {
		save : {
			method : 'POST',
			isArray : false,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}
	});
});