zaa.controller("ActiveWindowGalleryController", function($scope, $http) {
	
	$scope.crud = $scope.$parent; // {{ data.activeWindow.itemId }}
	
	$scope.images = [];
	
	$scope.loadImages = function() {
		$http.get($scope.crud.getActiveWindowCallbackUrl('images')).success(function(response) {
			$scope.images = response;
		})
	}
	
	$scope.$watch(function() { return $scope.data.activeWindow.itemId }, function(n, o) {
		$scope.loadImages();
	});
	
});