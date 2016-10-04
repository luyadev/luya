(function() {
	"use strict";
	
	// directive.js
	
	zaa.directive("menuDropdown", function(ServiceMenuData) {
		return {
			restrict : 'E',
			scope : {
				navId : '='
			},
			controller : function($scope) {
				
				$scope.changeModel = function(data) {
					$scope.navId = data.id;
				}
				
				$scope.menuData = ServiceMenuData.data;
				
				$scope.$on('service:MenuData', function(event, data) {
					$scope.menuData = data;
				});
				
				function init() {
					if ($scope.menuData.length == 0) {
						ServiceMenuData.load();
					}
				}
				
				init();
			},
			template : function() {
				return '<div class="menu-dropdown__category" ng-repeat="container in menuData.containers">' +
                            '<b class="menu-dropdown__title">{{container.name}}</b>' +
                            '<ul class="menu-dropdown__list">' +
                                '<li class="menu-dropdown__item" ng-repeat="data in menuData.items | menuparentfilter:container.id:0" ng-include="\'menuDropdownReverse\'"></li>' +
                            '</ul>' +
                        '</div>';
			}
		}
	});
	
	zaa.directive("zaaCmsPage", function($compile){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "name": "@fieldname"
            },
            template: function() {
                return '<div class="input input--image-upload" ng-class="{\'input--hide-label\': i18n}">' +
                            '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<menu-dropdown class="menu-dropdown" nav-id="model" />' +
                            '</div>' +
                        '</div>';
            }
        }
    });

	zaa.directive("showInternalRedirection", function() {
		return {
			restrict : 'E',
			scope : {
				navId : '='
			},
			controller : function($scope, $http, $state) {
				$http.get('admin/api-cms-navitem/get-nav-item-path', { params : { navId : $scope.navId }}).success(function(response) {
					$scope.path = response;
				});
				$http.get('admin/api-cms-navitem/get-nav-container-name', { params : { navId : $scope.navId }}).success(function(response) {
					$scope.container = response;
				});

				$scope.goTo = function(navId) {
					$state.go('custom.cmsedit', { navId : navId });
				}
			},
			template : function() {
				return '<a ng-click="goTo(navId)" style="cursor:pointer">{{path}}</a> in {{container}}';
			}
		}
	});

    zaa.directive("updateFormPage", function() {
        return {
            restrict : 'EA',
            scope : {
                data : '='
            },
            templateUrl : 'updateformpage.html',
            controller : function($scope) {
            	
            	$scope.parent = $scope.$parent.$parent;
            	
            	$scope.isEditAvailable = function() {
            		return $scope.parent.item.nav_item_type == 1;
            	}
            }
        }
    });

	zaa.directive("updateFormModule", function() {
		return {
			restrict : 'EA',
			scope : {
				data : '='
			},
			templateUrl : 'updateformmodule.html',
			controller : function($scope) {
			}
		}
	});

	zaa.directive("updateFormRedirect", function() {
		return {
			restrict : 'EA',
			scope : {
				data : '='
			},
			templateUrl : 'updateformredirect.html',
			controller : function($scope) {
			}
		}
	});
	
	zaa.directive("createForm", function() {
		return {
			restrict : 'EA',
			scope : {
				data : '='
			},
			templateUrl : 'createform.html',
			controller : function($scope, $http, $filter, ServiceMenuData, Slug, ServiceLanguagesData, AdminToastService) {
				
				$scope.error = [];
				$scope.success = false;
				
				$scope.controller = $scope.$parent;
				
				$scope.menuData = ServiceMenuData.data;
				
				$scope.$on('service:MenuData', function(event, data) {
					$scope.menuData = data;
				});

				$scope.menuDataReload = function() {
					return ServiceMenuData.load(true);
				}
				
				function initializer() {
					$scope.menu = $scope.menuData.items;
					$scope.navcontainers = $scope.menuData.containers;
				}
				
				initializer();
				
				
				$scope.data.nav_item_type = 1;
				$scope.data.parent_nav_id = 0;
				$scope.data.is_draft = 0;
				
				$scope.data.nav_container_id = 1;
				
				
				$scope.languagesData = ServiceLanguagesData.data;
				
				$scope.$on('service:LanguagesData', function(event, data) {
					$scope.languagesData = data;
				});
				
				
				$scope.data.lang_id = parseInt($filter('filter')($scope.languagesData, {'is_default': '1'}, true)[0].id);
				
				$scope.navitems = [];
				
				$scope.$watch(function() { return $scope.data.nav_container_id }, function(n, o) {
					if (n !== undefined && n !== o) {
						$scope.data.parent_nav_id = 0;
						$scope.navitems = $scope.menu[n]['__items'];
					}
				});
				
				$scope.aliasSuggestion = function() {
					$scope.data.alias = Slug.slugify($scope.data.title);
				}
				
				$scope.exec = function () {
					$scope.controller.save().then(function(response) {
						$scope.menuDataReload();
						$scope.success = true;
						$scope.error = [];
						$scope.data.title = null;
						$scope.data.alias = null;
						if ($scope.data.isInline) {
							$scope.$parent.$parent.getItem($scope.data.lang_id, $scope.data.nav_id);
						}
						AdminToastService.success(i18n['view_index_page_success'], 4000);
					}, function(reason) {
						angular.forEach(reason, function(value, key) {
							AdminToastService.error(value[0], 2000);
						});
						$scope.error = reason;
					});
				}
				
			}
		}
	});
	
	zaa.directive("createFormPage", function(ServiceLayoutsData, ServiceMenuData) {
		return {
			restrict : 'EA',
			scope : {
				data : '='
			},
			templateUrl : 'createformpage.html',
			controller : function($scope) {
				
				$scope.data.use_draft = 0;
				
				// layoutsData
				
				$scope.layoutsData = ServiceLayoutsData.data;
				
            	$scope.$on('service:BlocksData', function(event, data) {
            		$scope.layoutsData = data;
            	});
            	
            	// menuData
            	
    			$scope.menuData = ServiceMenuData.data;
				
				$scope.$on('service:MenuData', function(event, data) {
					$scope.menuData = data;
				});
            	
            	function init() {
            		$scope.drafts = $scope.menuData.drafts;
            		$scope.layouts = $scope.layoutsData;
            	}
				
            	init();
            	
				$scope.save = function() {
					$scope.$parent.exec();
				}
			}
		}
	});

	zaa.directive("createFormModule", function($http) {
		return {
			restrict : 'EA',
			scope : {
				data : '='
			},
			templateUrl : 'createformmodule.html',
			controller : function($scope) {
				
				$scope.modules = [];
				
				$http.get('admin/api-admin-common/data-modules').then(function(response) {
					$scope.modules = response.data;
				})
				
				$scope.save = function() {
					$scope.$parent.exec();
				}
			}
		}
	});
	
	zaa.directive("createFormRedirect", function() {
		return {
			restrict : 'EA',
			scope : {
				data : '='
			},
			templateUrl : 'createformredirect.html',
			controller : function($scope) {
				
				$scope.save = function() {
					$scope.$parent.exec();
				}
			}
		}
	});
	
	// factory.js
	
	/*
	 * zaa.factory('ApiCmsNavContainer', function($resource) { return
	 * $resource('admin/api-cms-navcontainer/:id'); });
	 */
	
	/*
	 * zaa.factory('ApiCmsBlock', function($resource) { return
	 * $resource('admin/api-cms-block/:id'); });
	 */
	
	/*
	zaa.factory('ApiCmsNavItemPageBlockItem', function($resource) {
		return $resource('admin/api-cms-navitempageblockitem/:id', { id : '@_id' }, {
			save : {
				method : 'POST',
				isArray : false,
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			},
			update : {
				method : 'PUT',
				isArray : false,
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			},
			'delete' : {
				method : 'DELETE'
			}
		});
	});
	*/
	zaa.factory('PlaceholderService', function() {
		var service = [];
		
		service.status = 1; /* 1 = showplaceholders; 0 = hide placeholders */
		
		service.delegate = function(status) {
			service.status = status;
		}
		
		return service;
	});
	
	// layout.js
	
	zaa.config(function($stateProvider, resolverProvider) {
		$stateProvider
		.state("custom.cmsedit", {
			url : "/update/:navId",
			templateUrl : 'cmsadmin/page/update'
		})
		.state("custom.cmsadd", {
			url : "/create",
			templateUrl : 'cmsadmin/page/create'
		})
		.state("custom.cmsdraft", {
			url: '/drafts',
			templateUrl: 'cmsadmin/page/drafts'
		});
	});
	
	zaa.controller("DraftsController", function($scope, $state, ServiceMenuData) {
		
		$scope.menuData = ServiceMenuData.data;
		
		$scope.$on('service:MenuData', function(event, data) {
			$scope.menuData = data;
		});
		
		$scope.go = function(navId) {
			$state.go('custom.cmsedit', { navId : navId });
		};
		
	});
	
	zaa.controller("PageVersionsController", function($scope, $http, ServiceLayoutsData, AdminToastService) {
		/**
		 * @var object $typeData From parent scope controller NavItemController
		 * @var object $item From parent scope controller NavItemController
		 * @var string $versionName From ng-model
		 * @var integer $fromVersionPageId From ng-model the version copy from or 0 = new empty/blank version
		 * @var integer $versionLayoutId From ng-model, only if fromVersionPageId is 0
 		 */
		
		var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
		
		// layoutsData
		
		$scope.layoutsData = ServiceLayoutsData.data;
		
    	$scope.$on('service:LayoutsData', function(event, data) {
    		$scope.layoutsData = data;
    	});
		
    	$scope.closeCreateModal = function() {
    		$scope.createVersionModalState = true;
    	}
    	
    	$scope.editVersionModalState = true;
    	
    	$scope.closeEditModal = function() {
    		$scope.editVersionModalState = true;
    	}
    	
    	$scope.openEditModal = function() {
    		$scope.editVersionModalState = false;
    	}
    	
		$scope.toggleVersionEdit = function(versionId) {
			$scope.$parent.switchVersion(versionId);
			$scope.openEditModal();
		};
		
		$scope.toggleRemoveVersion = function(versionid) {
			$scope.$parent.switchVersion(versionid);
			$scope.$parent.removeCurrentVersion();
			
		}
    	
    	// controller logic
    	
    	$scope.changeVersionLayout = function(versionItem) {
    		$http.post('admin/api-cms-navitem/change-page-version-layout', $.param({'pageItemId': versionItem.id, 'layoutId': versionItem.layout_id, 'alias': versionItem.version_alias}), headers).success(function(response) {
    			$scope.refreshForce();
    			$scope.closeEditModal();
    			AdminToastService.success(i18n['js_version_update_success'], 4000);
			});
    	};
    	
		$scope.createNewVersionSubmit = function(data) {
			if (data == undefined) {
				AdminToastService.error(i18n['js_version_error_empty_fields'], 4000);
				return null;
			}
			if (data.copyExistingVersion) {
				data.versionLayoutId = 0;
			}
			$http.post('admin/api-cms-navitem/create-page-version', $.param({'layoutId': data.versionLayoutId, 'navItemId': $scope.item.id, 'name': data.versionName, 'fromPageId': data.fromVersionPageId}), headers).success(function(response) {
				if (response.error) {
					AdminToastService.error(i18n['js_version_error_empty_fields'], 4000);
					return null;
				}
				
				$scope.refreshForce();
				$scope.closeCreateModal();
				
				AdminToastService.success(i18n['js_version_create_success'], 4000);
			});
		};
	});
	
	zaa.controller("CopyPageController", function($scope, $http, AdminToastService, Slug) {
		
		var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
		
		$scope.NavItemController = $scope.$parent;
		
		$scope.navId = 0;
		
		$scope.items = null;
		
		$scope.isOpen = false;
		
		$scope.itemSelection = false;
		
		$scope.selection = 0;
		
		$scope.select = function(item) {
			$scope.selection = item.id;
			$scope.itemSelection = angular.copy(item);
		};
		
		$scope.aliasSuggestion = function() {
			$scope.itemSelection.alias = Slug.slugify($scope.itemSelection.title);
		}
		
		$scope.loadItems = function() {
			$scope.navId = $scope.NavItemController.NavController.navData.id;
			
			$http.get('admin/api-cms-nav/find-nav-items', { params: { navId : $scope.navId }}).success(function(response) {
				$scope.items = response;
				$scope.isOpen = true;
			});
		};
		
		$scope.save = function() {
			$scope.itemSelection['toLangId'] = $scope.NavItemController.lang.id;
			$http.post('admin/api-cms-nav/create-from-page', $.param($scope.itemSelection), headers).success(function(response) {
				if (response) {
					AdminToastService.success(i18n['js_added_translation_ok'], 3000);
					$scope.NavItemController.refresh();
				} else {
					AdminToastService.error(i18n['js_added_translation_error'], 5000);
				}
			});
		}
		
	});
	
	zaa.controller("DropNavController", function($scope, $http, ServiceMenuData, AdminToastService) {
		
		$scope.droppedNavItem = null;

		$scope.showVersionList = false;
		
		$scope.errorMessageOnDuplicateAlias = function(response) {
			AdminToastService.error(i18nParam('js_page_add_exists', {title: response.success.title, id: response.success.nav_id}), 5000);
		}
		
	    $scope.onBeforeDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			$http.get('admin/api-cms-navitem/move-before', { params : { moveItemId : $scope.droppedNavItem.id, droppedBeforeItemId : itemid }}).success(function(r) {
				ServiceMenuData.load(true);
			}).error(function(r) {
				$scope.errorMessageOnDuplicateAlias(r);
			});
	    }
	    
	    $scope.onAfterDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			$http.get('admin/api-cms-navitem/move-after', { params : { moveItemId : $scope.droppedNavItem.id, droppedAfterItemId : itemid }}).success(function(r) {
				ServiceMenuData.load(true);
			}).error(function(r) {
				$scope.errorMessageOnDuplicateAlias(r);
				ServiceMenuData.load(true);
			});
	    }
	    
	    $scope.onChildDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			$http.get('admin/api-cms-navitem/move-to-child', { params : { moveItemId : $scope.droppedNavItem.id, droppedOnItemId : itemid }}).success(function(r) {
				ServiceMenuData.load(true);
			}).error(function(r) {
				$scope.errorMessageOnDuplicateAlias(r);
				ServiceMenuData.load(true);
			});
	    }
	    
	    $scope.onEmptyDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
	    	$http.get('admin/api-cms-navitem/move-to-container', { params : { moveItemId : $scope.droppedNavItem.id, droppedOnCatId : itemid }}).success(function(r) {
	    		ServiceMenuData.load(true);
			}).error(function(r) {
				$scope.errorMessageOnDuplicateAlias(r);
				ServiceMenuData.load(true);
			});
	    }
	})
	
	zaa.filter("menuparentfilter", function() {
		return function(input, containerId, parentNavId) {
			var result = [];
			angular.forEach(input, function(value, key) {
				if (value.parent_nav_id == parentNavId && value.nav_container_id == containerId) {
					result.push(value);
				}
			});
			return result;
		};
	});
	
	zaa.controller("CmsLiveEdit", function($scope, ServiceLiveEditMode) {
		
		$scope.display = 0;
		
		$scope.url = homeUrl;
		
		$scope.$watch(function() { return ServiceLiveEditMode.state }, function(n, o) {
			$scope.display = n;
		});
		
		$scope.$on('service:LiveEditModeUrlChange', function(event, url) {
			var d = new Date();
			var n = d.getTime();
			$scope.url = url + '&' + n;
		});
		
	});
	
	zaa.controller("CmsMenuTreeController", function($scope, $state, $http, ServiceMenuData, ServiceLiveEditMode) {
		
		// live edit service
		
		$scope.liveEditState = 0;
		
		$scope.$watch('liveEditStateToggler', function(n) {
			ServiceLiveEditMode.state = n;
		});
		
		// menu Data
		
		$scope.menuData = ServiceMenuData.data;
		
		$scope.$on('service:MenuData', function(event, data) {
			$scope.menuData = data;
		});

		$scope.menuDataReload = function() {
			return ServiceMenuData.load(true);
		}
		
		$scope.toggleItem = function(data) {
			if (data.toggle_open == undefined) {
				data['toggle_open'] = 1;
			} else {
				data['toggle_open'] = !data.toggle_open;
			}
			
			$http.post('admin/api-cms-nav/tree-history', {data: data}).then(function(response) {});
			
		};
		
		$scope.go = function(data) {
			ServiceLiveEditMode.changeUrl(data.nav_item_id, 0);
			$state.go('custom.cmsedit', { navId : data.id });
	    };
		
	    $scope.showDrag = 0;
	    
	    $scope.isCurrentElement = function(navId) {
	    	if ($state.params.navId == navId) {
	    		return true;
	    	}
	    	
	    	return false;
	    }
	    
    	$scope.hiddenCats = $scope.menuData.hiddenCats;
		
		$scope.toggleCat = function(catId) {
			if (catId in $scope.hiddenCats) {
				$scope.hiddenCats[catId] = !$scope.hiddenCats[catId];
			} else {
				$scope.hiddenCats[catId] = 1;
			}
			
			$http.post('admin/api-cms-nav/save-cat-toggle', {catId: catId, state: $scope.hiddenCats[catId]});
		};
		
		$scope.toggleIsHidden = function(catId) {
			
			if ($scope.hiddenCats == undefined) {
				return false;
			}
			
			if (catId in $scope.hiddenCats) {
				if ($scope.hiddenCats[catId] == 1) {
					return true;
				}
			}
			
			return false;
		}
	    
	});
	
	// create.js
	
	zaa.controller("CmsadminCreateController", function($scope, $q, $http) {
		
		$scope.data = {};
		$scope.data.isInline = false;
		
		$scope.save = function() {
			
			var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
			
			return $q(function(resolve, reject) {
				
				if ($scope.data.nav_item_type == 1) {
					$http.post('admin/api-cms-nav/create-page', $.param($scope.data), headers).success(function(response) {
						resolve(response);
					}).error(function(response) {
						reject(response);
					});
				}
				
				if ($scope.data.nav_item_type == 2) {
					$http.post('admin/api-cms-nav/create-module', $.param($scope.data), headers).success(function(response) {
						resolve(response);
					}).error(function(response) {
						reject(response);
					});
				}
				
				if ($scope.data.nav_item_type == 3) {
					$http.post('admin/api-cms-nav/create-redirect', $.param($scope.data), headers).success(function(response) {
						resolve(response);
					}).error(function(response) {
						reject(response);
					});
				}
			});
		}
	});
	
	zaa.controller("CmsadminCreateInlineController", function($scope, $q, $http) {
		
		$scope.data = {
			nav_id : $scope.$parent.NavController.id
		};
		
		$scope.data.isInline = true;
		
		$scope.save = function() {
		
			$scope.data.lang_id = $scope.lang.id;
			
			var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
			
			return $q(function(resolve, reject) {
				
				if ($scope.data.nav_item_type == 1) {
					$http.post('admin/api-cms-nav/create-page-item', $.param($scope.data), headers).success(function(response) {
						resolve(response);
					}).error(function(response) {
						reject(response);
					});
				}
				
				if ($scope.data.nav_item_type == 2) {
					$http.post('admin/api-cms-nav/create-module-item', $.param($scope.data), headers).success(function(response) {
						resolve(response);
					}).error(function(response) {
						reject(response);
					});
				}
				
				if ($scope.data.nav_item_type == 3) {
					$http.post('admin/api-cms-nav/create-redirect-item', $.param($scope.data), headers).success(function(response) {
						resolve(response);
					}).error(function(response) {
						reject(response);
					});
				}
			})
		}
		
	});
	
	// update.js
	
	zaa.controller("NavController", function($scope, $filter, $stateParams, $http, LuyaLoading, PlaceholderService, ServicePropertiesData, ServiceMenuData, ServiceLanguagesData, AdminToastService, AdminClassService, AdminLangService) {
		
		$scope.AdminLangService = AdminLangService;
		
		/* service AdminPropertyService inheritance */
		
		$scope.propertiesData = ServicePropertiesData.data;
		
		$scope.$on('service:PropertiesData', function(event, data) {
			$scope.propertiesData = data;
		});
		
		/* service ServiceMenuData inheritance */
		
		$scope.menuData = ServiceMenuData.data;
		
		$scope.$on('service:MenuData', function(event, data) {
			$scope.menuData = data;
		});

		$scope.menuDataReload = function() {
			return ServiceMenuData.load(true);
		}
		
		/* service ServiceLangaugesData inheritance */
		
		$scope.languagesData = ServiceLanguagesData.data;
		
		$scope.$on('service:LanguagesData', function(event, data) {
			$scope.languagesData = data;
		});
		
		/* placeholders toggler service */
		
		$scope.PlaceholderService = PlaceholderService;
		
		$scope.placeholderState = $scope.PlaceholderService.status;
		
		$scope.$watch('placeholderState', function(n, o) {
			if (n !== o && n !== undefined) {
				$scope.PlaceholderService.delegate(n);
			}
		});

		/* sidebar logic */
		
		$scope.sidebar = false;
		
	    $scope.enableSidebar = function() {
	    	$scope.sidebar = true;
	    }
	    
	    $scope.toggleSidebar = function() {
	        $scope.sidebar = !$scope.sidebar;
	    };
	    
		/* app logic */
		
		$scope.id = parseInt($stateParams.navId);
		
		$scope.isDeleted = false;
		
		$scope.AdminClassService = AdminClassService;
		
		$scope.propValues = {};
		
		$scope.hasValues = false;
		
		$scope.createDeepPageCopy = function() {
			$http.post('admin/api-cms-nav/deep-page-copy', {navId: $scope.id}).success(function(response) {
				$scope.menuDataReload();
			});
		};
		
		$scope.loadNavProperties = function() {
			$http.get('admin/api-cms-nav/get-properties', { params: {navId: $scope.id}}).success(function(response) {
				for(var i in response) {
					var d = response[i];
					$scope.propValues[d.admin_prop_id] = d.value;
					$scope.hasValues = true;
				}
			});
		};
		
		$scope.togglePropMask = function() {
			$scope.showPropForm = !$scope.showPropForm;
		}
		
		$scope.showPropForm = false;
		
		$scope.storePropValues = function() {
			var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
			$http.post('admin/api-cms-nav/save-properties?navId='+$scope.id, $.param($scope.propValues), headers).success(function(response) {
				AdminToastService.success(i18n['js_page_property_refresh'], 4000);
				$scope.loadNavProperties();
				$scope.showPropForm = false;
			});
		}
		
		$scope.trash = function() {
	    	
			AdminToastService.confirm(i18n['js_page_confirm_delete'], function($timeout, $toast) {
				
				$http.get('admin/api-cms-nav/delete', { params : { navId : $scope.id }}).success(function(response) {
	    			$scope.isDeleted = true;
	    			$scope.menuDataReload().then(function() {
	    				$toast.close();
	    			});
	    		}).error(function(response) {
					AdminToastService.error(i18n['js_page_delete_error_cause_redirects'], 5000);
				});
			});
	    };
		
	    $scope.isDraft = false;
		
	    
	    function initializer() {
			$scope.navData = $filter('filter')($scope.menuData.items, {id: $scope.id}, true)[0];
			
			if ($scope.navData == undefined) {
				$scope.isDraft = true;
			} else {
			
				$scope.loadNavProperties();
				
				/* watchers for properties if its not a draft */
				
				/* properties --> */
				
			    $scope.$watch(function() { return $scope.navData.is_offline }, function(n, o) {
			    	if (n !== o && n !== undefined) {
			    		$http.get('admin/api-cms-nav/toggle-offline', { params : { navId : $scope.navData.id , offlineStatus : n }}).success(function(response) {
							if ($scope.navData.is_offline == 1) {
								AdminToastService.notify(i18nParam('js_state_offline', {title: $scope.navData.title}), 2000);
							} else {
								AdminToastService.notify(i18nParam('js_state_online', {title: $scope.navData.title}), 2000);
							}
			    		});
			    	}
			    });
			    
			    $scope.$watch(function() { return $scope.navData.is_hidden }, function(n, o) {
					if (n !== o && n !== undefined) {
						$http.get('admin/api-cms-nav/toggle-hidden', { params : { navId : $scope.navData.id , hiddenStatus : n }}).success(function(response) {
							if ($scope.navData.is_hidden == 1) {
								AdminToastService.notify(i18nParam('js_state_hidden', {title: $scope.navData.title}), 2000);
							} else {
								AdminToastService.notify(i18nParam('js_state_visible', {title: $scope.navData.title}), 2000);
							}
						});
					}
				});
			    
			    $scope.$watch(function() { return $scope.navData.is_home }, function(n, o) {
			    	if (n !== o && n !== undefined) {
						$http.get('admin/api-cms-nav/toggle-home', { params : { navId : $scope.navData.id , homeState : n }}).success(function(response) {
							$scope.menuDataReload().then(function() {
								if ($scope.navData.is_home == 1) {
									AdminToastService.notify(i18nParam('js_state_is_home', {title: $scope.navData.title}), 2000);
								} else {
									AdminToastService.notify(i18nParam('js_state_is_not_home', {title: $scope.navData.title}), 2000);
								}
			    			});
						});
					}
				});
			}
		}
	    
		initializer();
	});
	
	/**
	 * @param $scope.lang
	 *            from ng-repeat
	 */
	zaa.controller("NavItemController", function($scope, $http, $timeout, ServiceMenuData, AdminLangService, AdminToastService, ServiceLiveEditMode) {
		
		$scope.loaded = false;
		
		$scope.NavController = $scope.$parent;
		
		$scope.liveEditState = false;
		
		$scope.$watch(function() { return ServiceLiveEditMode.state }, function(n, o) {
			$scope.liveEditState = n;
		});
		
		$scope.openLiveUrl = function(id, versionId) {
			ServiceLiveEditMode.changeUrl(id, versionId);
		};
		
		$scope.loadLiveUrl = function() {
			ServiceLiveEditMode.changeUrl($scope.item.id, $scope.currentPageVersion);
		}
		
		// serviceMenuData inheritance
		
		$scope.menuDataReload = function() {
			return ServiceMenuData.load(true);
		}
		
		$scope.$on('service:LoadLanguage', function(event, data) {
			if (!$scope.loaded) {
				$scope.refresh();
			}
		});
		
		// app
		
		$scope.isTranslated = false;
		
		$scope.item = [];
		
		$scope.itemCopy = [];
	
		$scope.settings = false;
		
		$scope.reset = function() {
			$scope.itemCopy = angular.copy($scope.item);
			if ($scope.item.nav_item_type == 1) {
				$scope.typeDataCopy = angular.copy({'nav_item_type_id' : $scope.item.nav_item_type_id });
			} else {
				$scope.typeDataCopy = angular.copy($scope.typeData);
			}
			
		}
		
		$scope.errors = [];

		$scope.save = function(itemCopy, typeDataCopy) {
			$scope.errors = [];
			var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
			var navItemId = itemCopy.id;

			typeDataCopy.title = itemCopy.title;
			typeDataCopy.alias = itemCopy.alias;
			typeDataCopy.description = itemCopy.description;
			typeDataCopy.keywords = itemCopy.keywords;
			$http.post(
				'admin/api-cms-navitem/update-page-item?navItemId=' + navItemId + '&navItemType=' + itemCopy.nav_item_type,
				$.param(typeDataCopy),
				headers
			).then(function successCallback(response) {
				if (itemCopy.nav_item_type !== 1) {
					$scope.currentPageVersion = 0;
				}
				$scope.loaded = false;
				AdminToastService.success(i18nParam('js_page_item_update_ok', {'title': itemCopy.title}), 2000);
				$scope.menuDataReload();
				$scope.refresh();
				$scope.toggleSettings();
			}, function errorCallback(response) {
				$scope.errors = response.data;
			});
		};
		
		$scope.homeUrl = homeUrl;
		
		$scope.toggleSettings = function() {
			$scope.reset();
			$scope.settings = !$scope.settings;
		};
	
		$scope.typeDataCopy = [];
		
		$scope.typeData = [];
		
		$scope.container = [];
		
		$scope.currentVersionInformation = null;
		
		$scope.removeCurrentVersion = function() {
			// {alias: $scope.currentVersionInformation.version_alias}
			AdminToastService.confirm(i18nParam('js_version_delete_confirm', {alias: $scope.currentVersionInformation.version_alias}), function($toast, $http) {
				$http.post('admin/api-cms-navitem/remove-page-version', {pageId : $scope.currentVersionInformation.id}).then(function(response) {
					var aliasName = $scope.currentVersionInformation.version_alias;
					$scope.refreshForce();
					$toast.close();
					AdminToastService.success(i18nParam('js_version_delete_confirm_success', {alias: aliasName}), 5000);
				});
			});
		}
		
		$scope.currentPageVersion = 0;
		
		$scope.getItem = function(langId, navId) {
			$http({
			    url: 'admin/api-cms-navitem/nav-lang-item', 
			    method: "GET",
			    params: { langId : langId, navId : navId }
			}).success(function(response) {
				if (response) {
					if (!response.error) {
						$scope.item = response['item'];
						$scope.typeData = response['typeData'];
						$scope.isTranslated = true;
						$scope.reset();
						if ($scope.item.nav_item_type == 1) {
							if ($scope.currentPageVersion == 0) {
								$scope.currentPageVersion = response.item.nav_item_type_id;
							}
							if (response.item.nav_item_type_id in response.typeData) {
								$scope.currentVersionInformation = response.typeData[$scope.currentPageVersion];
								$scope.container = response.typeData[$scope.currentPageVersion]['contentAsArray'];
							}
						}
						
					}
				}
				$scope.loaded = true
			});
		};
		
		$scope.switchVersion = function(pageVersionid) {
			$scope.container = $scope.typeData[pageVersionid]['contentAsArray'];
			$scope.currentVersionInformation = $scope.typeData[pageVersionid];
			$scope.currentPageVersion = pageVersionid;
			$scope.loadLiveUrl();
		};
		
		$scope.refreshForce = function() {
			$scope.getItem($scope.lang.id, $scope.NavController.id);
		}
		
		$scope.refresh = function() {
			if (AdminLangService.isInSelection($scope.lang.short_code)) {
				$scope.getItem($scope.lang.id, $scope.NavController.id);
			}
		};
		
		// <!-- NavItemTypePageController CODE
		
		$scope.refreshNested = function(prevId, placeholderVar) {
			$http({
				url : 'admin/api-cms-navitem/reload-placeholder',
				method : 'GET',
				params : { navItemPageId : $scope.currentPageVersion, prevId : prevId, placeholderVar : placeholderVar}
			}).success(function(response) {

				ServiceLiveEditMode.changeUrl($scope.item.id, $scope.currentPageVersion);
				for (var i in $scope.container.__placeholders) {
					var out = $scope.revPlaceholders($scope.container.__placeholders[i], prevId, placeholderVar, response);
					if (out !== false ) {
						return;
					}
				}
				
			});
		}
		$scope.revPlaceholders = function(placeholder, prevId, placeholderVar, replaceContent) {
			var tmp = placeholder['prev_id'];
			if (parseInt(prevId) == parseInt(tmp) && placeholderVar == placeholder['var']) {
				placeholder['__nav_item_page_block_items'] = replaceContent;
				return true;
			}
			
			var find = $scope.revFind(placeholder, prevId, placeholderVar, replaceContent)
			if (find !== false) {
				return find;
			}
			return false;
		}
		
		$scope.revFind = function(placeholder, prevId, placeholderVar, replaceContent) {
			for (var i in placeholder['__nav_item_page_block_items']) {
				for (var holder in placeholder['__nav_item_page_block_items'][i]['__placeholders']) {
					var rsp = $scope.revPlaceholders(placeholder['__nav_item_page_block_items'][i]['__placeholders'][holder], prevId, placeholderVar, replaceContent);
					if (rsp !== false) {
						return rsp;
					}
				}
			}
			return false;
		}
		
		// NavItemTypePageController -->
		
		function init() {
			$scope.refresh();
		}
		
		init();
	});
	
	
	/**
	 * @param $scope.placeholder
	 *            from ng-repeat
	 */
	zaa.controller("PagePlaceholderController", function($scope, AdminClassService, PlaceholderService) {
		
		$scope.NavItemTypePageController = $scope.$parent;
		
		$scope.PlaceholderService = PlaceholderService;
		
		$scope.$watch(function() { return $scope.PlaceholderService.status }, function(n,o) {
			if (n) {
				$scope.isOpen = true;
			} else {
				$scope.isOpen = false;
			}
		});
		
		$scope.isOpen = false;
		
		$scope.toggleOpen = function() {
			$scope.isOpen = !$scope.isOpen;
		}
		
		$scope.mouseEnter = function() {
			var status = AdminClassService.getClassSpace('onDragStart');
			if (status !== undefined && !$scope.isOpen) {
				$scope.isOpen = true;
			}
		};
	});
	
	
	/**
	 * @param $scope.block
	 *            from ng-repeat
	 */
	zaa.controller("PageBlockEditController", function($scope, $sce, $http, AdminClassService, AdminToastService, ServiceBlockCopyStack, ServiceLiveEditMode) {
	
		$scope.PagePlaceholderController = $scope.$parent;
		
		$scope.onStart = function() {
			$scope.$apply(function() {
				AdminClassService.setClassSpace('onDragStart', 'page--drag-active');
			});
		};
		
		$scope.copyBlock = function() {
			ServiceBlockCopyStack.push($scope.block.id, $scope.block.name);
		};
		
		$scope.toggleHidden = function() {
			if ($scope.block.is_hidden == 0) {
				$scope.block.is_hidden = 1;
			} else {
				$scope.block.is_hidden = 0;
			}
			
			$http({
			    url: 'admin/api-cms-navitem/toggle-block-hidden', 
			    method: "GET",
			    params: { blockId : $scope.block.id, hiddenState: $scope.block.is_hidden }
			}).success(function(response) {
				/* load live url on hidden trigger */
				$scope.PagePlaceholderController.NavItemTypePageController.$parent.$parent.loadLiveUrl();
				// successfull toggle hidden state of block
				AdminToastService.notify(i18nParam('js_page_block_visbility_change', {name: $scope.block.name}), 2000);
			});
		}

		$scope.hasInfo = function(varFieldName) {
			if (varFieldName in $scope.block.field_help) {
				return true;
			}
			
			return false;
		}
		
		$scope.getInfo = function(varFieldName) {
			return $scope.block.field_help[varFieldName];
		}
		
        $scope.isEditable = function() {
            return typeof $scope.block.vars != "undefined" && $scope.block.vars.length > 0;
        };

        $scope.isConfigable = function() {
            return typeof $scope.block.cfgs != "undefined" && $scope.block.cfgs.length > 0;
        };
		
		$scope.safe = function(html) {
			return $sce.trustAsHtml(html);
		};
		
		$scope.onStop = function() {
			$scope.$apply(function() {
				AdminClassService.setClassSpace('onDragStart', undefined);
			});
		};
		
		$scope.$watch(function() { return $scope.block.values }, function(n, o) {
			$scope.data = n;
		});
		
		$scope.cfgdata = $scope.block.cfgvalues || {};
		
		$scope.edit = false;
		$scope.config = false;

		$scope.toggleBlockSettings = function() {
			$scope.edit = false;
			$scope.config = false;
		};

		$scope.toggleEdit = function() {
			if (!$scope.isEditable()) {
				return;
			}
			$scope.edit = !$scope.edit;
			$scope.config = false;
		};

		$scope.toggleConfig = function() {
			if (!$scope.isConfigable()) {
				return;
			}

			$scope.config = !$scope.config;
			$scope.edit = false;
		};
		
		$scope.renderTemplate = function(template, dataVars, cfgVars, block, extras) {
			if (template == undefined) {
				return '';
			}
			var template = twig({
			    data: template
			});
			
			var content = template.render({
				vars : dataVars,
				cfgs : cfgVars,
				block : block,
				extras : extras
			});
			
			return $sce.trustAsHtml(content);
		};
		
		$scope.removeBlock = function(block) {
			AdminToastService.confirm(i18nParam('js_page_block_delete_confirm', {name: block.name}), function($timeout, $toast) {
				$http.delete('admin/api-cms-navitempageblockitem/delete?id=' + block.id).success(function(response) {
					$scope.PagePlaceholderController.NavItemTypePageController.refresh();
					$scope.PagePlaceholderController.NavItemTypePageController.loadLiveUrl();
					$toast.close();
					AdminToastService.success(i18nParam('js_page_block_remove_ok', {name: block.name}), 2000);
				});
				/*
				ApiCmsNavItemPageBlockItem.delete({id: block.id}, function (rsp) {
					$scope.PagePlaceholderController.NavItemTypePageController.refresh();
					$scope.PagePlaceholderController.NavItemTypePageController.loadLiveUrl();
					$toast.close();
					AdminToastService.success(i18nParam('js_page_block_remove_ok', {name: block.name}), 2000);
				});
				*/
			});
		};
		
		$scope.save = function () {
			$http.put('admin/api-cms-navitempageblockitem/update?id=' + $scope.block.id, {json_config_values: $scope.data, json_config_cfg_values: $scope.cfgdata}).success(function(response) {
				AdminToastService.success(i18nParam('js_page_block_update_ok', {name: $scope.block.name}), 2000);
				$scope.edit = false;
				$scope.config = false;
				$scope.block.is_dirty = 1;
				$scope.block = angular.copy(response.objectdetail);
				$scope.PagePlaceholderController.NavItemTypePageController.loadLiveUrl();
			});
			/*
			return;
			ApiCmsNavItemPageBlockItem.update({ id : $scope.block.id }, $.param({json_config_values : JSON.stringify($scope.data), json_config_cfg_values : JSON.stringify($scope.cfgdata) }), function(rsp) {
				AdminToastService.success(i18nParam('js_page_block_update_ok', {name: $scope.block.name}), 2000);
				$scope.edit = false;
				$scope.config = false;
				$scope.block.is_dirty = 1;
				$http({
				    url: 'admin/api-cms-navitem/get-block', 
				    method: "GET",
				    params: { blockId : $scope.block.id }
				}).success(function(rsp) {
					$scope.block = rsp;
					$scope.PagePlaceholderController.NavItemTypePageController.loadLiveUrl();
				});
				
			});
			*/
		}
		
	});
	
	/**
	 * @TODO HANDLING SORT INDEX OF EACH BLOCK
	 */
	zaa.controller("DropBlockController", function($scope, $http, AdminClassService) {
		
		$scope.PagePlaceholderController = $scope.$parent;
		
		$scope.droppedBlock = {};
		
		$scope.onDrop = function($event, $ui) {
			
			var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
			
			var sortIndex = $($event.target).data('sortindex');
			var moveBlock = $scope.droppedBlock['vars'] || false;
			var event = $scope.droppedBlock['event'] || false;
			
			if (event === 'isServiceBlockCopyInstance') {
				$http.post('admin/api-cms-navitemblock/copy-block-from-stack', $.param({
					copyBlockId: $scope.droppedBlock.blockId,
					sortIndex: sortIndex,
					prevId:  $scope.placeholder.prev_id,
					placeholder_var : $scope.placeholder.var, nav_item_page_id : $scope.placeholder.nav_item_page_id
				}), headers).success(function(response) {
					$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
					$scope.droppedBlock = {};
				});
			} else {
				if (moveBlock === false) {
					$http.post('admin/api-cms-navitempageblockitem/create', { prev_id : $scope.placeholder.prev_id, sort_index : sortIndex, block_id : $scope.droppedBlock.id , placeholder_var : $scope.placeholder.var, nav_item_page_id : $scope.placeholder.nav_item_page_id }).success(function(response) {
						$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
						$scope.droppedBlock = {};
					});
					/*
					ApiCmsNavItemPageBlockItem.save($.param({ prev_id : $scope.placeholder.prev_id, sort_index : sortIndex, block_id : $scope.droppedBlock.id , placeholder_var : $scope.placeholder.var, nav_item_page_id : $scope.placeholder.nav_item_page_id }), function(rsp) {
						$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
						$scope.droppedBlock = {};
					})
					*/
				} else {
					$http.put('admin/api-cms-navitempageblockitem/update?id=' + $scope.droppedBlock.id, {
						prev_id : $scope.placeholder.prev_id,
						placeholder_var : $scope.placeholder['var'],
						sort_index : sortIndex
					}).success(function(response) {
						$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
						$scope.droppedBlock = {};
						$($ui.helper).remove(); //destroy clone
			            $($ui.draggable).remove(); //remove from list
					});
					/*
					ApiCmsNavItemPageBlockItem.update({ id : $scope.droppedBlock.id }, $.param({
						prev_id : $scope.placeholder.prev_id,
						placeholder_var : $scope.placeholder.var,
						sort_index : sortIndex
					}), function(rsp) {
						$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
						$scope.droppedBlock = {};
						$($ui.helper).remove(); //destroy clone
			            $($ui.draggable).remove(); //remove from list
					});
					*/
				}
			}
			AdminClassService.setClassSpace('onDragStart', undefined);
		}
	});
	
	zaa.controller("DroppableBlocksController", function($scope, $http, AdminClassService, ServiceBlocksData, ServiceBlockCopyStack, $sce) {
	
		// service ServiceBlocksData inheritance
		
		$scope.blocksData = ServiceBlocksData.data;
		
		$scope.blocksDataRestore = angular.copy($scope.blocksData);
		
		$scope.$on('service:BlocksData', function(event, data) {
			$scope.blocksData = data;
		});

		$scope.blocksDataReload = function() {
			return ServiceBlocksData.load(true);
		}
		
		$scope.addToFav = function(item) {
			$http.post('admin/api-cms-block/to-fav', {block: item }).success(function(response) {
				$scope.blocksDataReload();
			});
		};
		
		$scope.removeFromFav = function(item) {
			$http.post('admin/api-cms-block/remove-fav', {block: item }).success(function(response) {
				$scope.blocksDataReload();
			});
		};
		
		$scope.toggleGroup = function(group) {
			if (group.toggle_open == undefined) {
				group.toggle_open = 1;
			} else {
				group.toggle_open = !group.toggle_open;
			}
			
			$http.post('admin/api-cms-block/toggle-group', {group: group});
		}
		
		// controller logic
		
		$scope.copyStack = ServiceBlockCopyStack.stack;
		
		$scope.$on('service:CopyStack', function(event, stack) {
			$scope.copyStack = stack;
		});
		
		$scope.clearStack = function() {
			ServiceBlockCopyStack.clear();
		};
		
		$scope.searchQuery = '';
		
		$scope.searchIsDirty = false;
		
		$scope.$watch('searchQuery', function(n, o) {
			if (n !== '') {
				$scope.searchIsDirty = true;
				angular.forEach($scope.blocksData, function(value, key) {
					value.group.toggle_open = 1
				});
			} else if($scope.searchIsDirty) {
				$scope.blocksData = angular.copy($scope.blocksDataRestore);
			}
		})
		
		$scope.onStart = function() {
			$scope.$apply(function() {
				AdminClassService.setClassSpace('onDragStart', 'page--drag-active');
			});
		}
		
		$scope.safe = function(html) {
			return $sce.trustAsHtml(html);
		}
		
		$scope.onStop = function() {
			$scope.$apply(function() {
				AdminClassService.setClassSpace('onDragStart', undefined);
			});
		}
	});
	
})();