zaa.controller("CmsadminCreateController", function($scope, $q, ApiCmsNav) {
	
	$scope.data = {};
	
	$scope.save = function() {
		return $q(function(resolve, reject) {
			ApiCmsNav.save($.param($scope.data), function(response) {
				console.log(response);
				resolve(response)
			});
		});
		
	}
	
});

zaa.controller("CmsadminCreateInlineController", function($scope, $q, $http) {
	
	$scope.data = {
		nav_id : $scope.$parent.NavController.id
	};
	
	$scope.save = function() {
		var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
		
		return $q(function(resolve, reject) {
			
			console.log($scope.lang.id);
			
			$http.post('admin/api-cms-navitem/create', $.param({
		    	nav_id : $scope.data.nav_id,
		    	lang_id : $scope.lang.id,
		    	title : $scope.data.title,
		    	rewrite : $scope.data.rewrite,
		    	nav_item_type : $scope.data.nav_item_type,
		    	nav_item_type_id : $scope.data.nav_item_type_id
		    }), headers).success(function(rsp) {
				$scope.$parent.refresh();
			});
		})
	}
	
});