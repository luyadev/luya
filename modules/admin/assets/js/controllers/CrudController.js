zaa.controller("CrudController", function($scope, $http, $sce, $state) {
	
	$scope.loading = true;
	
	$scope.parentController = $scope.$parent;
	
	//$scope.AdminService = AdminService;
	
	$scope.orderBy = 'id';
	
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
	
	$scope.getStrap = function (strapId, id, $event) {
		$http.post('admin/ngrest/render', $.param({ itemId : id, strapHash : strapId , ngrestConfigHash : $scope.config.ngrestConfigHash }), {
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		})
		.success(function(data) {
			$scope.openStrap();
			$scope.data.strap.itemId = id;
			$scope.data.strap.configCallbackUrl = $scope.config.strapCallbackUrl;
			$scope.data.strap.configHash = $scope.config.ngrestConfigHash;
			$scope.data.strap.hash = strapId;
			$scope.data.strap.id = strapId; /* @todo: remove! BUT: equal to above, but still need in jquery accessing */
			$scope.data.strap.content = $sce.trustAsHtml(data);
			//dispatchEvent('onCrudStrapLoad');
		})
	}

	$scope.getStrapCallbackUrl = function(callback) {
		return $scope.data.strap.configCallbackUrl + '?strapCallback=' + callback + '&ngrestConfigHash=' + $scope.data.strap.configHash + '&strapHash=' + $scope.data.strap.hash;
	}
	
	$scope.sendStrapCallback = function(callback, data) {
		$http.post($scope.getStrapCallbackUrl(callback), $.param(data), {
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function(response) {
			$scope.strapCallbackResponse = response;
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
			//$scope.toggler.strap = false;
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
	
	$scope.openStrap = function() {
		$('#strapModal').openModal();
	}
	
	$scope.closeStrap = function() {
		$('#strapModal').closeModal();
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
	}
	
	/*
	$scope.toggler = {
		create : false,
		update : false
	}
	*/
	
	$scope.data = {
		create : {},
		update : {},
		strap : {},
		list : {},
		updateId : 0
	};
	
	$scope.config = {};
	
});