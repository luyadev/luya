zaa.controller("CrudController", function($scope, $http, $sce, $state) {
	
	$scope.loading = true;
	
	$scope.parentController = $scope.$parent;
	
	//$scope.AdminService = AdminService;
	
	$scope.orderBy = '+id';
	
	$scope.showCrudList = true;
	
	$scope.currentMenuItem = null;
	
	$scope.createErrors = [];
	
	$scope.updateErrors = [];
	
	$scope.init = function () {
		$scope.loadList();
		$scope.$watch(function() { return $scope.parentController.currentItem }, function(newValue) {
			$scope.currentMenuItem = newValue;
		});
	}
	
	$scope.isOrderBy = function(field) {
		if (field == $scope.orderBy) {
			return true;
		}
		
		return false;
	}
	
	$scope.changeOrder = function(field, sort) {
		$scope.orderBy = sort + field;
	}
	
	$scope.closeDialogs = function() {
		/*
		$scope.toggler.update = false;
		$scope.toggler.strap = false;
		$scope.toggler.create = false;
		//$scope.AdminService.bodyClass = '';
		$scope.search = '';
		*/
	}
	
	$scope.debug = function() {
		console.log('config', $scope.config);
		console.log('data', $scope.data);
	}
	
	$scope.getActiveWindow = function (activeWindowId, id, $event) {
		$http.post('admin/ngrest/render', $.param({ itemId : id, activeWindowHash : activeWindowId , ngrestConfigHash : $scope.config.ngrestConfigHash }), {
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		})
		.success(function(data) {
			$scope.openActiveWindow();
			$scope.data.aw.itemId = id;
			$scope.data.aw.configCallbackUrl = $scope.config.activeWindowCallbackUrl;
			$scope.data.aw.configHash = $scope.config.ngrestConfigHash;
			$scope.data.aw.hash = activeWindowId;
			$scope.data.aw.id = activeWindowId; /* @todo: remove! BUT: equal to above, but still need in jquery accessing */
			$scope.data.aw.content = $sce.trustAsHtml(data);
			//dispatchEvent('onCrudActiveWindowLoad');
		})
	}

	$scope.getActiveWindowCallbackUrl = function(callback) {
		return $scope.data.aw.configCallbackUrl + '?activeWindowCallback=' + callback + '&ngrestConfigHash=' + $scope.data.aw.configHash + '&activeWindowHash=' + $scope.data.aw.hash;
	}
	
	/**
	 * new returns a promise promise.hten(function(answer) {
	 * 
	 * }, function(error) {
	 * 
	 * }, function(progress) {
	 * 
	 * });
	 * 
	 * instead of return variable
	 */
	$scope.sendActiveWindowCallback = function(callback, data) {
		var data = data || {};
		return $http.post($scope.getActiveWindowCallbackUrl(callback), $.param(data), {
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
	}
	
	$scope.toggleUpdate = function (id, $event) {
		/*
		$scope.toggler.update = !$scope.toggler.update;
		$scope.AdminService.bodyClass = 'main-blurred';
		*/
		$scope.data.updateId = id;
		$http.get($scope.config.apiEndpoint + '/'+id+'?' + $scope.config.apiUpdateQueryString)
		.success(function(data) {
			$scope.data.update = data;
            //dispatchEvent('onCrudUpdate');
            $('#updateModal').openModal({
            	dismissible: false
            });
			
		})
		.error(function(data) {
			alert('ERROR LOADING UPDATE DATA');
		})
	}
	
	$scope.closeUpdate = function () {
		$('#updateModal').closeModal();
        //$scope.AdminService.bodyClass = '';
    }
	
	$scope.closeCreate = function() {
		$('#createModal').closeModal();
	}
	
	$scope.openActiveWindow = function() {
		$('#activeWindowModal').openModal();
	}
	
	$scope.closeActiveWindow = function() {
		$('#activeWindowModal').closeModal();
	}
	
	$scope.openCreate = function () {
		$('#createModal').openModal({
			dismissible: false
		});
		/*
		$scope.toggler.create = !$scope.toggler.create;
		if ($scope.toggler.create) {
			$scope.AdminService.bodyClass = 'main-blurred';
		} else {
			$scope.AdminService.bodyClass = '';
		}
		if ($scope.toggler.create) {
			dispatchEvent('onCrudCreate');
		}
		*/
	}
    
	$scope.submitUpdate = function () {
		
		$scope.updateErrors = [];
		
		console.log($scope.data.update);
		console.log(angular.toJson($scope.data.update));
		$http.put($scope.config.apiEndpoint + '/' + $scope.data.updateId, angular.toJson($scope.data.update, true))
		.success(function(data) {
			$('#updateModal').closeModal();
			$scope.loadList();
			Materialize.toast('Der Datensatz wurde erfolgreich aktualsiert.', 3000);
		})
		.error(function(data) {
			$scope.updateErrors = data;
		})
	}
	
	$scope.submitCreate = function() {
		
		$scope.createErrors = [];
		
		$http.post($scope.config.apiEndpoint, angular.toJson($scope.data.create, true))
		.success(function(data) {
			$('#createModal').closeModal();
			$scope.loadList();
			$scope.data.create = {};
			Materialize.toast('Der neue Datensatz wurde erfolgreich erstellt.', 3000);
		})
		.error(function(data) {
			$scope.createErrors = data;
		})
	}

	$scope.loadList = function() {
		$http.get($scope.config.apiEndpoint + '/?' + $scope.config.apiListQueryString)
		.success(function(data) {
			$scope.loading = false;
			$scope.data.list = data;
		})
		
		$http.get($scope.config.apiEndpoint + '/services').success(function(rsp) {
			$scope.service = rsp;
		})
	}
	
	$scope.service = [];
	
	/*
	$scope.toggler = {
		create : false,
		update : false
	}
	*/
	
	$scope.data = {
		create : {},
		update : {},
		aw : {},
		list : {},
		updateId : 0
	};
	
	$scope.config = {};
	
});