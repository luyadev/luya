zaa.directive("createForm", function() {
	return {
		restrict : 'EA',
		scope : {
			data : '='
		},
		templateUrl : 'createform.html',
		controller : function($scope) {
			
			$scope.controller = $scope.$parent;
			
			$scope.showType = 0;
			
			$scope.showTypeContainer = function() {
				/* todo: verify if allowd */
				$scope.showType = parseInt($scope.data.nav_item_type);
			}
			
			$scope.exec = function () {
				$scope.controller.save().then(function(response) {
					$scope.showType = true;
				})
			}
		}
	}
});

zaa.directive("createFormPage", function() {
	return {
		restrict : 'EA',
		scope : {
			data : '='
		},
		templateUrl : 'createformpage.html',
		controller : function($scope, $resource, ApiCmsNavItemPage) {
			
			$scope.layouts = $resource('admin/api-cms-layout/:id').query();
			
			$scope.debug2 = function() {
				console.log($scope.data);
			}
			
			$scope.save = function() {
				ApiCmsNavItemPage.save($.param({ layout_id : $scope.data.layout_id }), function(response) {
					$scope.data.nav_item_type_id = response.id;
					$scope.$parent.exec();
				});
			}
		}
	}
});