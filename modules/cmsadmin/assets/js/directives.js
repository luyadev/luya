zaa.directive("createForm", function() {
	return {
		restrict : 'EA',
		scope : {
			data : '='
		},
		templateUrl : 'createform.html',
		controller : function($scope, $http, ApiAdminLang, ApiCmsCat, MenuService) {
			
			$scope.controller = $scope.$parent;
			
			$scope.lang = ApiAdminLang.query();
			
			$scope.cat = ApiCmsCat.query();
			
			$scope.data.nav_item_type = 1;
			$scope.data.parent_nav_id = 0;
			
			$http.get('admin/api-cms-defaults/cat').success(function(response) {
				$scope.data.cat_id = response.id;
			});
			
			$http.get('admin/api-admin-defaults/lang').success(function(response) {
				$scope.data.lang_id = response.id;
			});
			
			$scope.navitems = [];
			
			$scope.$watch(function() { return $scope.data.cat_id }, function(newValue) {
				if (newValue !== undefined) {
					$http.get('admin/api-cms-menu/get-by-cat-id/', { params: { 'catId' : newValue }}).success(function(response) {
						$scope.data.parent_nav_id = 0;
						$scope.navitems = response;
					});
				}
			})
			
			$scope.exec = function () {
				$scope.controller.save().then(function(response) {
					console.log('createForm Drive Response', response);
					MenuService.refresh();
				});
				/*
				$scope.controller.save().then(function(response) {
					console.log('exec', response);
					//$scope.data.nav_item_type = true;
					MenuService.refresh();
				})
				*/
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
		controller : function($scope, $resource) {
			
			$scope.layouts = $resource('admin/api-cms-layout/:id').query();
			
			$scope.save = function() {
				
				$scope.$parent.exec();
				/*
				ApiCmsNavItemPage.save($.param({ layout_id : $scope.data.layout_id }), function(response) {
					$scope.data.nav_item_type_id = response.id;
					$scope.$parent.exec();
				}, function(error) {
					console.log('err_create_form_page', error.data);
				});
				*/
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
		controller : function($scope) {
			
			$scope.save = function() {
				
				$scope.$parent.exec();
				
				/*
				ApiCmsNavItemModule.save($.param({ module_name : $scope.data.module_name }), function(response) {
					$scope.data.nav_item_type_id = response.id;
					$scope.$parent.exec();
				});
				*/
			}
		}
	}
});