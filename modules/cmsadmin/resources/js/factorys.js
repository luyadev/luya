zaa.factory('ApiCmsCat', function($resource) {
	return $resource('admin/api-cms-cat/:id');
});

zaa.factory('ApiCmsBlock', function($resource) {
	return $resource('admin/api-cms-block/:id');
});

zaa.factory('CmsLayoutService', function($resource) {
	var service = [];
	
	service.data = [];
	
	service.resource = $resource('admin/api-cms-layout/:id');
	
	service.load = function() {
		service.data = service.resource.query();
	}
	
	return service;
});

zaa.factory('ApiCmsNavItemPageBlockItem', function($resource) {
	return $resource('admin/api-cms-navitempageblockitem/:id', { id : '@_id' }, {
		save : {
			method : 'POST',
			isArray : false,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		},
		update : {
			method : 'PUT',
			isArray : false,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		},
		'delete' : {
			method : 'DELETE'
		}
	});
});

zaa.factory('DroppableBlocksService', function($http) {
	var service = [];
	
	service.blocks = [];
	
	service.load = function() {
		if (service.blocks.length == 0) { /* do not reload block data if there is already. what about force reload? */
			$http({
				url : 'admin/api-cms-admin/get-all-blocks',
				method : 'GET'
			}).success(function(response) {
				service.blocks = response;
			});
		}
	};
	
	return service;
});