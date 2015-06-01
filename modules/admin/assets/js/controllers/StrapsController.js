zaa.controller("StrapGalleryController", function($scope, $http) {
	
	$scope.crud = $scope.$parent; // {{ data.strap.itemId }}
	
	$scope.images = [];
	
	$scope.loadImages = function() {
		$http.get($scope.crud.getStrapCallbackUrl('images')).success(function(response) {
			$scope.images = response;
		})
	}
	
	$scope.$watch(function() { return $scope.data.strap.itemId }, function(n, o) {
		$scope.loadImages();
	});
	
});