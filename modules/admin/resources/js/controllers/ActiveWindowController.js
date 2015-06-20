zaa.controller("ActiveWindowGalleryController", function($scope, $http) {
	
	$scope.crud = $scope.$parent; // {{ data.aw.itemId }}
	
	$scope.images = [];
	
	$scope.loadImages = function() {
		$http.get($scope.crud.getActiveWindowCallbackUrl('images')).success(function(response) {
			$scope.images = response;
		})
	}
	
	$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
		$scope.loadImages();
	});
	
});

zaa.controller("ActiveWindowChangePassword", function($scope) {
	
	$scope.crud = $scope.$parent;
	
	$scope.init = function() {
		$scope.error = false;
		$scope.submitted = false;
		$scope.transport = [];
		$scope.newpass = null;
		$scope.newpasswd = null;
	}
	
	$scope.$watch(function() { return $scope.crud.data.aw.itemId }, function(n, o) {
		$scope.init();
	})
	
	$scope.submit = function() {
		$scope.crud.sendActiveWindowCallback('save', {'newpass' : $scope.newpass, 'newpasswd' : $scope.newpasswd}).then(function(response) {
			$scope.submitted = true;
			$scope.error = response.data.error;
			$scope.transport = response.data.transport;
		})
	}
});