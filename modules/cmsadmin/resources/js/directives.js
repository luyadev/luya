zaa.directive("createForm", function() {
	return {
		restrict : 'EA',
		scope : {
			data : '='
		},
		templateUrl : 'createform.html',
		controller : function($scope, $http, AdminLangService, ApiCmsCat, MenuService, Slug) {
			
			$scope.error = [];
			$scope.success = false;
			
			$scope.controller = $scope.$parent;
			
			$scope.AdminLangService = AdminLangService;
			
			$scope.lang = $scope.AdminLangService.data;
			
			$scope.cat = ApiCmsCat.query();
			
			$scope.data.nav_item_type = 1;
			$scope.data.parent_nav_id = 0;
			
			$http.get('admin/api-cms-defaults/cat').success(function(response) {
				$scope.data.cat_id = parseInt(response.id);
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
			});
			
			$scope.rewriteSuggestion = function() {
				$scope.data.rewrite = Slug.slugify($scope.data.title);
			}
			
			$scope.exec = function () {
				$scope.controller.save().then(function(response) {
					MenuService.refresh();
					$scope.success = true;
					$scope.error = [];
					$scope.data.title = null;
					$scope.data.rewrite = null;
					if ($scope.data.isInline) {
						$scope.$parent.$parent.$parent.getItem($scope.data.lang_id, $scope.data.nav_id); /* getItem(nav_id, lang_id); */
					}
					
				}, function(reason) {
					$scope.error = reason;
				});
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