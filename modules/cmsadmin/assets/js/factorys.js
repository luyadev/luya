zaa.factory('ApiCmsCat', function($resource) {
	return $resource('admin/api-cms-cat/:id');
});

zaa.factory('ApiCmsBlock', function($resource) {
	return $resource('admin/api-cms-block/:id');
});

zaa.factory('ApiCmsNavItemPageBlockItem', function($resource) {
	return $resource('admin/api-cms-navitemplageblockitem/:id', { id : '@_id' }, {
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
		$http({
			url : 'admin/api-cms-admin/get-all-blocks',
			method : 'GET'
		}).success(function(response) {
			console.log('DroppableBlocksService loading data', response);
			service.blocks = response;
		});
	};
	
	return service;
});