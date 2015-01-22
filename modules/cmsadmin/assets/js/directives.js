zaa.directive("createForm", function() {
	return {
		restrict : 'EA',
		scope : {
			data : '='
		},
		templateUrl : 'createform.html',
		controller : function($scope, ApiAdminLang, ApiCmsCat, MenuService) {
			
			$scope.controller = $scope.$parent;
			
			$scope.showType = 0;
			
			
			$scope.lang = ApiAdminLang.query();
			
			$scope.cat = ApiCmsCat.query();
			
			
			$scope.showTypeContainer = function() {
				/* todo: verify if allowd */
				$scope.showType = parseInt($scope.data.nav_item_type);
			}
			
			$scope.exec = function () {
				$scope.controller.save().then(function(response) {
					$scope.showType = true;
					MenuService.refresh();
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
			
			$scope.save = function() {
				ApiCmsNavItemPage.save($.param({ layout_id : $scope.data.layout_id }), function(response) {
					$scope.data.nav_item_type_id = response.id;
					$scope.$parent.exec();
				});
			}
		}
	}
});

zaa.directive("createFormModule", function() {
	return {
		restrict : 'EA',
		scope : {
			data : '='
		},
		templateUrl : 'createformmodule.html',
		controller : function($scope, ApiCmsNavItemModule) {
			console.log('ApiCmsNavItemModule', ApiCmsNavItemModule);
			
			$scope.save = function() {
				ApiCmsNavItemModule.save($.param({ module_name : $scope.data.module_name }), function(response) {
					$scope.data.nav_item_type_id = response.id;
					$scope.$parent.exec();
				});
			}
		}
	}
});