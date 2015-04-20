zaa.controller("CrudController", function($scope, $http, $sce, $state, AdminService) {
	
	$scope.parentController = $scope.$parent;
	
	$scope.AdminService = AdminService;
	
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
	
	$scope.closeDialogs = function() {
		$scope.toggler.update = false;
		$scope.toggler.strap = false;
		$scope.toggler.create = false;
		$scope.AdminService.bodyClass = '';
		$scope.search = '';
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
			$scope.toggler.update = false;
			$scope.toggler.strap = true;
			$scope.data.strap.id = strapId;
			$scope.data.strap.content = $sce.trustAsHtml(data);
			dispatchEvent('onCrudStrapLoad');
		})
	}

	$scope.toggleStrap = function() {
		$scope.toggler.strap = !$scope.toggler.strap;
	}
	
	$scope.toggleUpdate = function (id, $event) {
		$scope.toggler.update = !$scope.toggler.update;
		$scope.data.updateId = id;
		$scope.AdminService.bodyClass = 'main-blurred';
		
		
		$http.get($scope.config.apiEndpoint + '/'+id+'?' + $scope.config.apiUpdateQueryString)
		.success(function(data) {
			$scope.toggler.strap = false;
			$scope.data.update = data;
            dispatchEvent('onCrudUpdate');
			
		})
		.error(function(data) {
			alert('ERROR LOADING UPDATE DATA');
		})
	}
	
	$scope.closeUpdate = function () {
        $scope.toggler.update = false;
        $scope.AdminService.bodyClass = '';
    }
	
	$scope.toggleCreate = function () {
		$scope.toggler.create = !$scope.toggler.create;
		if ($scope.toggler.create) {
			$scope.AdminService.bodyClass = 'main-blurred';
		} else {
			$scope.AdminService.bodyClass = '';
		}
		if ($scope.toggler.create) {
			dispatchEvent('onCrudCreate');
		}
	}
    
	$scope.submitUpdate = function () {
		
		$scope.updateErrors = [];
		
		$http.put($scope.config.apiEndpoint + '/' + $scope.data.updateId, $.param($scope.data.update), {
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		})
		.success(function(data) {
			$scope.loadList();
			$scope.closeUpdate();
		})
		.error(function(data) {
			$scope.updateErrors = data;
		})
	}
	
	$scope.submitCreate = function() {
		
		$scope.createErrors = [];
		
		$http.post($scope.config.apiEndpoint, $.param($scope.data.create), {
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		})
		.success(function(data) {
			$scope.loadList();
			$scope.data.create = {};
			$scope.toggleCreate();
		})
		.error(function(data) {
			$scope.createErrors = data;
		})
	}

	$scope.loadList = function() {
		$http.get($scope.config.apiEndpoint + '/?' + $scope.config.apiListQueryString)
		.success(function(data) {
			$scope.data.list = data;
		})
	}
	
	$scope.toggler = {
		create : false,
		update : false
	}
	
	$scope.data = {
		create : {},
		update : {},
		strap : {},
		list : {},
		updateId : 0
	};
	
	$scope.config = {};
	
});