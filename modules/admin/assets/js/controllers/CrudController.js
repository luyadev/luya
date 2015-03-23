function openMore( $more ) {
    var $editWrapper = $more.find( '.Crud-editWrapper' );

    $more.addClass( 'is-open' );
    if( $editWrapper.length > 0 )
        $more = $editWrapper;
}

function closeMore( $more ) {
    var $editWrapper = $more.find( '.Crud-editWrapper' );

    $more.removeClass( 'is-open' );
    if( $editWrapper.length > 0 ) {
        $more = $editWrapper;
    }

}

zaa.controller("CrudController", function($scope, $http, $sce, AdminService) {
	
	$scope.AdminService = AdminService;
	
	$scope.showCrudList = true;
	
	$scope.init = function () {
		$scope.loadList();
	}
	
	$scope.debug = function() {
		console.log('config', $scope.config);
		console.log('data', $scope.data);
	}
	/*
	$scope.submitStrap = function(strapHash) {
		console.log(strapHash);
	}
	
	$scope.postStrapUrl = function(callback, params) {
		console.log(callback, params);
	}
	*/
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

	$scope.toggleStrap = function()
	{
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
		$http.put($scope.config.apiEndpoint + '/' + $scope.data.updateId, $.param($scope.data.update), {
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		})
		.success(function(data) {
			$scope.loadList();
			$scope.closeUpdate();
		})
		.error(function(data) {
			alert('ERROR UPDATE DATA ' + $scope.data.updateId);
		})
	}
	
	$scope.submitCreate = function() {
		$http.post($scope.config.apiEndpoint, $.param($scope.data.create), {
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		})
		.success(function(data) {
			$scope.loadList();
			$scope.data.create = {};
			$scope.toggleCreate();
		})
		.error(function(data) {
			alert('error while create data, see console.log');
			console.log(data);
			for (var i in data) {
				field = data[i]['field'];
				message = data[i]['message'];
				
			}
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