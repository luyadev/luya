zaa.controller("LayoutMenuController", function ($scope, $http, $state, $location, $timeout) {
	
	$scope.notify = null;
	
	$scope.showOnlineContainer = false;
	
	(function tick(){
		$http.get('admin/api-admin-timestamp', { ignoreLoadingBar: true }).success(function(response) {
			$scope.notify = response;
			$timeout(tick, 25000);
		})
	})();
	
	$scope.searchQuery = null;

    $scope.searchInputOpen = false;

    $scope.openSearchInput = function() {
        $scope.searchInputOpen = true;
    };

    $scope.closeSearchInput = function() {
        $scope.searchInputOpen = false;
        $scope.searchQuery = "";
        $scope.searchResponse = null;
    };
	
	$scope.searchResponse = null;
	
	$scope.searchPromise = null;

	$scope.$watch(function() { return $scope.searchQuery}, function(n, o) {
		if (n !== o) {
			if (n.length > 2) {
				$timeout.cancel($scope.searchPromise);
				$scope.searchPromise = $timeout(function() {
					$http.get('admin/api-admin-search', { params : { query : n}}).success(function(response) {
						$scope.searchResponse = response;
					})
				}, 1000)
			} else {
                $scope.searchResponse = null;
			}
		}
	});
	
	$scope.items = [];
	
	$scope.currentItem = {};
	
	$scope.click = function(menuItem) {
		if (menuItem.template) {
			$state.go('custom', { 'templateId' : menuItem.template });
		} else {
			$state.go('default', { 'moduleId' : menuItem.id});
		}
	}
	
	$scope.isActive = function(item) {
		if (item.template) {
			if ($state.params.templateId == item.template) {
				$scope.currentItem = item;
				return true;
			}
		} else {
			if ($state.params.moduleId == item.id) {
				$scope.currentItem = item;
				return true;
			}
		}
	}
	
	$scope.get = function () {
		$http.get('admin/api-admin-menu')
		.success(function(data) {
			$scope.items = data;
		});
	}
	
	$scope.get();
});