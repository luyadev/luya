zaa.controller("CmsadminCreateController", function($scope, $q, $http) {
	
	$scope.data = {};
	
	$scope.save = function() {
		
		var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
		
		return $q(function(resolve, reject) {
			
			if ($scope.data.nav_item_type == 1) {
				$http.post('admin/api-cms-nav/create-page', $.param($scope.data), headers).success(function(response) {
					resolve(response);
				}).error(function(response) {
					console.log('error', response);
				});
			}
			
			if ($scope.data.nav_item_type == 2) {
				$http.post('admin/api-cms-nav/create-module', $.param($scope.data), headers).success(function(response) {
					resolve(response);
				}).error(function(response) {
					console.log('error', response);
				});
			}
		});
		
	}
	
});

zaa.controller("CmsadminCreateInlineController", function($scope, $q, $http) {
	
	$scope.data = {
		nav_id : $scope.$parent.NavController.id
	};
	
	$scope.save = function() {
	
		$scope.data.lang_id = $scope.lang.id;
		
		var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
		
		return $q(function(resolve, reject) {
			
			if ($scope.data.nav_item_type == 1) {
				$http.post('admin/api-cms-nav/create-page-item', $.param($scope.data), headers).success(function(response) {
					$scope.$parent.refresh();
					resolve(response);
				}).error(function(response) {
					console.log('error', response);
				});
			}
			
			if ($scope.data.nav_item_type == 2) {
				$http.post('admin/api-cms-nav/create-module-item', $.param($scope.data), headers).success(function(response) {
					$scope.$parent.refresh();
					resolve(response);
				}).error(function(response) {
					console.log('error', response);
				});
			}
		})
	}
	
});