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

zaa.factory('ApiAdminFilter', function($resource) {
	return $resource('admin/api-admin-filter/:id', { id: '@_id' }, {
		save : {
			method : 'POST',
			isArray : false,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}
	});
});