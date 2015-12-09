(function() {
	"use strict";
	
	// directive.js
	
	zaa.directive("menuDropdown", function(ServiceMenuData) {
		return {
			restrict : 'E',
			scope : {
				navId : '='
			},
			link : function(scope) {
				
				/* service ServiceMenuData inheritance */
				
				scope.menuData = ServiceMenuData.data;
				
				scope.$on('service:MenuData', function(event, data) {
					scope.menuData = data;
				});
				
				/*
				 * todo: replace with ServiceMenusData
				NewMenuService.get().then(function(response) {
					scope.menu = response;
				});
				*/
			},
			controller : function($scope) {
				$scope.changeModel = function(data) {
					$scope.navId = data.id;
				}
			},
			template : function() {
				return '<div class="menu-dropdown__category" ng-repeat="container in menuData.containers">' +
                            '<b class="menu-dropdown__title">{{container.name}}</b>' +
                            '<ul class="menu-dropdown__list">' +
                                '<li class="menu-dropdown__item" ng-repeat="data in menuData.items | menuparentfilter:container.id:0" ng-include="\'menuDropdownReverse.html\'"></li>' +
                            '</ul>' +
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
				return '<div class="btn" ng-click="goTo(navId)">{{path}}</div> in {{container}}';
			}
		}
	});

    zaa.directive("updateFormPage", function(ServiceLayoutsData) {
        return {
            restrict : 'EA',
            scope : {
                data : '='
            },
            templateUrl : 'updateformpage.html',
            controller : function($scope, $resource) {
            	
            	$scope.layoutsData = ServiceLayoutsData.data;
				
            	$scope.$on('service:BlocksData', function(event, data) {
            		$scope.layoutsData = data;
            	});
            	
            	function initializer() {
            		$scope.layouts = $scope.layoutsData;
            	}
            	
            	initializer();
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
			controller : function($scope, $http, $filter, ServiceMenuData, Slug, ServiceLanguagesData) {
				
				$scope.error = [];
				$scope.success = false;
				
				$scope.controller = $scope.$parent;
				
				//$scope.AdminLangService = AdminLangService;
				
				//$scope.MenuService = MenuService;
				
				//$scope.lang = $scope.AdminLangService.data;
				
				//$scope.navcontainers = $scope.MenuService.navcontainers;
				
				
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
							$scope.$parent.$parent.getItem($scope.data.lang_id, $scope.data.nav_id); /* getItem(nav_id, lang_id); */
						}
						
					}, function(reason) {
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
			controller : function($scope, $resource) {
				
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
	
	zaa.factory('ApiCmsNavContainer', function($resource) {
		return $resource('admin/api-cms-navcontainer/:id');
	});
	
	zaa.factory('ApiCmsBlock', function($resource) {
		return $resource('admin/api-cms-block/:id');
	});
	
	
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
	
	zaa.factory('PlaceholderService', function() {
		var service = [];
		
		service.status = 1; /* 1 = showplaceholders; 0 = hide placeholders */
		
		service.delegate = function(status) {
			service.status = status;
		}
		
		return service;
	})
	
	/*
	zaa.factory('DroppableBlocksService', function($http) {
		var service = [];
		
		service.blocks = [];
		
		service.load = function() {
			if (service.blocks.length == 0) {
				$http({
					url : 'admin/api-cms-admin/get-all-blocks',
					method : 'GET'
				}).success(function(response) {
					service.blocks = response;
				});
			}
		};
		
		return service;
	});
	*/
	
	/*
	zaa.factory('PropertiesService', function($http, $q) {
		var service = []
		service.data = null;
		service.get = function(forceReload) {
			return $q(function(resolve, reject) {
				if (service.data === null || forceReload === true) {
					$http({url: 'admin/api-admin-defaults/properties'}).success(function(response) {
						service.data = response;
						resolve(response);
					}).error(function(response) {
						reject(response);
					});
				} else {
					resolve(service.data);
				}
				
			});
		}
		return service;
	});
	*/
	
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
	
	/*
	zaa.service('MenuService', function($http) {
		var service = [];
		
		service.menu = [];
		
		service.navcontainers = [];
		
		service.refresh = function() {
			service.navcontainers = [];
			$http.get('admin/api-cms-menu/all').success(function(response) {
				console.log('old menu service', response);
				for (var i in response) {
					service.navcontainers.push({ name : response[i]['name'], id : parseInt(response[i]['id'])});
				}
				service.menu = response;
			});
		}
		
		service.refresh();
		
		return service;
	});
	*/
	
	zaa.controller("DraftsController", function($scope, $state, ServiceMenuData) {
		
		$scope.menuData = ServiceMenuData.data;
		
		$scope.$on('service:MenuData', function(event, data) {
			$scope.menuData = data;
		});
		
		$scope.go = function(navId) {
			$state.go('custom.cmsedit', { navId : navId });
		};
		
	});
	
	zaa.controller("DropNavController", function($scope, $http, ServiceMenuData) {
		
		$scope.droppedNavItem = null;

		$scope.errorMessageOnDuplicateAlias = function() {
			//Materialize.toast('<span class="error">In dieser Ebene existiert bereits eine Seite mit dieser URL.</span>', 5000);
		}
		
	    $scope.onBeforeDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			//console.log('onBeforeDrop itemid: ' + itemid, 'theblock', $scope.droppedNavItem);
			$http.get('admin/api-cms-navitem/move-before', { params : { moveItemId : $scope.droppedNavItem.id, droppedBeforeItemId : itemid }}).success(function(r) {
				ServiceMenuData.load(true);
			}).error(function(r) {
				$scope.errorMessageOnDuplicateAlias();
			});
	    }
	    
	    $scope.onAfterDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			//console.log('onAfterDrop itemid: ' + itemid, 'theblock', $scope.droppedNavItem);
			$http.get('admin/api-cms-navitem/move-after', { params : { moveItemId : $scope.droppedNavItem.id, droppedAfterItemId : itemid }}).success(function(r) {
				ServiceMenuData.load(true);
			}).error(function(r) {
				$scope.errorMessageOnDuplicateAlias();
				ServiceMenuData.load(true);
			});
	    }
	    
	    $scope.onChildDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			//console.log('onChildDrop itemid: ' + itemid, 'theblock', $scope.droppedNavItem);
			$http.get('admin/api-cms-navitem/move-to-child', { params : { moveItemId : $scope.droppedNavItem.id, droppedOnItemId : itemid }}).success(function(r) {
				ServiceMenuData.load(true);
			}).error(function(r) {
				$scope.errorMessageOnDuplicateAlias();
				ServiceMenuData.load(true);
			});
	    }
	    
	    $scope.onEmptyDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			//console.log('onEmptyDrop itemid: ' + itemid, 'theblock', $scope.droppedNavItem);
	    	$http.get('admin/api-cms-navitem/move-to-container', { params : { moveItemId : $scope.droppedNavItem.id, droppedOnCatId : itemid }}).success(function(r) {
	    		ServiceMenuData.load(true);
			}).error(function(r) {
				$scope.errorMessageOnDuplicateAlias();
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
	
	zaa.controller("CmsMenuTreeController", function($scope, $state, ServiceMenuData) {
	    
		// new 
		
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
		};
		
		$scope.go = function(data) {
			$state.go('custom.cmsedit', { navId : data.id });
	    };
		
	    $scope.showDrag = 0;
	    
	    $scope.isCurrentElement = function(navId) {
	    	if ($state.params.navId == navId) {
	    		return true;
	    	}
	    	
	    	return false;
	    }
	    
    	$scope.hiddenCats = {};
		
		$scope.toggleCat = function(catId) {
			if (catId in $scope.hiddenCats) {
				$scope.hiddenCats[catId] = !$scope.hiddenCats[catId];
			} else {
				$scope.hiddenCats[catId] = 1;
			}
		};
		
		$scope.toggleIsHidden = function(catId) {
			if (catId in $scope.hiddenCats) {
				if ($scope.hiddenCats[catId] == 1) {
					return true;
				}
			}
			
			return false;
		}
	    
		//$scope.containers = $scope.menuData.containers;
		
		// old
		
		/*
		
		$scope.hiddenCats = {};
		
		$scope.toggleCat = function(catId) {
			if (catId in $scope.hiddenCats) {
				$scope.hiddenCats[catId] = !$scope.hiddenCats[catId];
			} else {
				$scope.hiddenCats[catId] = 1;
			}
		};
		
		$scope.toggleIsHidden = function(catId) {
			if (catId in $scope.hiddenCats) {
				if ($scope.hiddenCats[catId] == 1) {
					return true;
				}
			}
			
			return false;
		}
		
		$scope.AdminLangService = AdminLangService;
		
		$scope.AdminLangService.load(true);
		
		NewMenuService.get();
		
		$scope.$watch(function() { return NewMenuService.data; }, function(n) {
			$scope.menu = n;
		});
		
		$scope.showDrag = false;
		
		$scope.toggleDrag = function() {
			$scope.showDrag = !$scope.showDrag;
		}
		
		DroppableBlocksService.load();
		
	    $scope.isCurrentElement = function(navId) {
	    	if ($state.params.navId == navId) {
	    		return true;
	    	}
	    	
	    	return false;
	    }
	    
	    $scope.go = function(navId) {
	    	$state.go('custom.cmsedit', { navId : navId });
	    };
	    
	    
	    $scope.onStart = function() {
		};
		
		$scope.onStop = function() {
		};
		
		*/
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
		
		function initializer() {
			$scope.navData = $filter('filter')($scope.menuData.items, {id: $scope.id}, true)[0];
			$scope.loadNavProperties();
		}
		
		
		/*
		
		$scope.$watch(function() { return $scope.navData.is_draft }, function(n, o) {
			if (n == 1) {
				AdminLangService.resetDefault();
			}
		});
		
		*/
	
	    
	    
	    /*
		$http.get('admin/api-cms-nav/detail', { params : { navId : $scope.id }}).success(function(response) {
			$scope.navData = response;
		});
		
		*/
		
		/* <!-- properties */
		
		/*
		
		PropertiesService.get().then(function(r) {
			$scope.properties = r;
		});
		
		*/
		
		$scope.propValues = {};
		
		$scope.hasValues = false;
		
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
				AdminToastService.success('Die Eigenschaften wurden aktualisiert.', 2000);
				$scope.loadNavProperties();
			});
		}
		
		$scope.trash = function() {
	    	
			AdminToastService.confirm('Möchten Sie diese Seite wirklich löschen?', function($timeout, $toast) {
				
				$http.get('admin/api-cms-nav/delete', { params : { navId : $scope.navData.id }}).success(function(response) {
	    			$scope.isDeleted = true;
	    			$scope.menuDataReload().then(function() {
	    				$toast.close();
	    			});
	    		}).error(function(response) {
					// toast error page could'nt be delete because there are redirects linking to this page
				});
			})
			
			/*
			if (confirm('Are you sure you want to delete this page?')) {
	    		$http.get('admin/api-cms-nav/delete', { params : { navId : $scope.navData.id }}).success(function(response) {
	    			//NewMenuService.get(true);
	    			$scope.isDeleted = true;
	    			$scope.menuDataReload();
	    		}).error(function(response) {
					// toast error page could'nt be delete because there are redirects linking to this page
				});;
	    	}
	    	*/
	    };
		
		/* properties --> */
		
	    $scope.$watch(function() { return $scope.navData.is_offline }, function(n, o) {
	    	if (n !== o && n !== undefined) {
	    		$http.get('admin/api-cms-nav/toggle-offline', { params : { navId : $scope.navData.id , offlineStatus : n }}).success(function(response) {
	    			// toast status changed!
	    		});
	    	}
	    });
	    
	    $scope.$watch(function() { return $scope.navData.is_hidden }, function(n, o) {
			if (n !== o && n !== undefined) {
				$http.get('admin/api-cms-nav/toggle-hidden', { params : { navId : $scope.navData.id , hiddenStatus : n }}).success(function(response) {
					// toast status changed!
				});
			}
		});
	    
	    $scope.$watch(function() { return $scope.navData.is_home }, function(n, o) {
	    	if (n !== o && n !== undefined) {
				$http.get('admin/api-cms-nav/toggle-home', { params : { navId : $scope.navData.id , homeState : n }}).success(function(response) {
					$scope.menuDataReload().then(function() {
	    				// toast status changed!
	    			});
				});
			}
		});
	    
		/*
		$scope.$watch(function() { return $scope.navData.is_home }, function(n, o) {
			if (o !== undefined) {
				$http.get('admin/api-cms-nav/toggle-home', { params : { navId : $scope.navData.id , homeState : n }}).success(function(response) {
				});
			}
		});
		
		$scope.$watch(function() { return $scope.navData.is_hidden }, function(n, o) {
			console.log(n, o);
			if (o !== undefined) {
				$http.get('admin/api-cms-nav/toggle-hidden', { params : { navId : $scope.navData.id , hiddenStatus : n }}).success(function(response) {
					//NewMenuService.get(true);
					// send toast
					if (n == 1) {
						//Materialize.toast('<span>Die Seite ist nun Unsichtbar.</span>', 2000)
					} else {
						//Materialize.toast('<span>Die Seite ist nun Sichtbar.</span>', 2000)
					}
				});
			}
		});
		
		$scope.$watch(function() { return $scope.navData.is_offline }, function(n, o) {
			if (o !== undefined) {
				$http.get('admin/api-cms-nav/toggle-offline', { params : { navId : $scope.navData.id , offlineStatus : n }}).success(function(response) {
					//NewMenuService.get(true);
					// send toast
					if (n == 1) {
						//Materialize.toast('<span>Die Seite ist nun <span style="color:red;">Offline</span>.</span>', 2000)
					} else {
						//Materialize.toast('<span>Die Seite ist nun <span style="color:green;">Online</span>.</span>', 2000)
					}
				});
			}
		});
		
	    $scope.trash = function() {
	    	if (confirm('your are sure you want to delete this page?')) {
	    		$http.get('admin/api-cms-nav/delete', { params : { navId : $scope.navData.id }}).success(function(response) {
	    			//NewMenuService.get(true);
	    			$scope.isDeleted = true;
	    		});
	    	}
	    };
		*/
		
	    /*
		$scope.AdminClassService = AdminClassService;
		
		$scope.AdminLangService = AdminLangService;
		
		$scope.refresh = function() {
			$scope.langs = $scope.AdminLangService.data;
		}
		
		$scope.refresh();
		*/
		
		initializer();
	});
	
	/**
	 * @param $scope.lang
	 *            from ng-repeat
	 */
	zaa.controller("NavItemController", function($scope, $http, $timeout, ServiceMenuData) {
		
		$scope.NavController = $scope.$parent;
		
		// serviceMenuData inheritance
		
		$scope.menuDataReload = function() {
			return ServiceMenuData.load(true);
		}
		
		// app
		
		$scope.showContainer = false;
		
		$scope.isTranslated = false;
		
		$scope.item = [];
		
		$scope.itemCopy = [];
	
		$scope.settings = false;
		
		$scope.reset = function() {
			$scope.itemCopy = angular.copy($scope.item);
			$scope.typeDataCopy = angular.copy($scope.typeData);
		}
		
		$scope.errors = [];

		$scope.save = function(itemCopy, typeDataCopy) {
			$scope.errors = [];
			var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
			var navItemId = itemCopy.id;

			typeDataCopy.title = itemCopy.title;
			typeDataCopy.alias = itemCopy.alias;
			typeDataCopy.description = itemCopy.description;
			$http.post(
				'admin/api-cms-navitem/update-page-item?navItemId=' + navItemId + '&navItemType=' + itemCopy.nav_item_type + '&navItemTypeId=' + itemCopy.nav_item_type_id,
				$.param(typeDataCopy),
				headers
			).then(function successCallback(response) {
				//Materialize.toast('<span> Die Seite «'+itemCopy.title+'» wurde aktualisiert.</span>', 2000);
				$scope.menuDataReload();
				$scope.refresh();
				$scope.toggleSettings();
			}, function errorCallback(response) {
				$scope.errors = response.data;
			});
		};
		
		$scope.toggleSettings = function() {
			$scope.reset();
			$scope.settings = !$scope.settings;
		};
	
		$scope.typeDataCopy = [];
		
		$scope.typeData = [];
		
		$scope.getItem = function(langId, navId) {
			$scope.showContainer = false;
			$http({
			    url: 'admin/api-cms-navitem/nav-lang-item', 
			    method: "GET",
			    params: { langId : langId, navId : navId }
			}).success(function(response) {
				if (response) {
					$scope.item = response;
					
					$http({
						url : 'admin/api-cms-navitem/type-data',
						method : 'get',
						params : { navItemId : response.id }
					}).success(function(r) {
						$scope.typeData = r;

					})
					
					$scope.isTranslated = true;
					
					$timeout(function() {
						$scope.showContainer = true;
						$scope.$broadcast('refreshItems');
					}, 500);
				} else {
					$timeout(function() {
						$scope.showContainer = true;
						$scope.$broadcast('refreshItems');
					}, 500);
				}
				
				$scope.reset();
				
			});
		}
		
		$scope.refresh = function() {
			$scope.getItem($scope.lang.id, $scope.NavController.id);
		}
		
		$scope.refresh();
		
	});
	
	zaa.controller("NavItemTypePageController", function($scope, $http, $timeout, LuyaLoading) {
		
		$scope.NavItemController = $scope.$parent;
		
		$scope.container = [];
		
		$scope.$on('refreshItems', function(event) { 
			$scope.refresh(true);
		});
		
		$scope.refresh = function(forceReload) {
			$http({
				url : 'admin/api-cms-navitem/tree',
				method : 'GET',
				params : { navItemPageId : $scope.NavItemController.item.nav_item_type_id }
			}).success(function(response) {
				if ($scope.container.length == 0 || forceReload === true) {
					$scope.container = response;
				} else {
					// merge new content item to placeholder
					var old_ph = $scope.container.__placeholders;
					var new_ph = response.__placeholders;
					for (var i in old_ph) {
						$scope.container.__placeholders[i]['__nav_item_page_block_items'] = new_ph[i]['__nav_item_page_block_items'];
					}
				}
				$timeout(function() {
					$scope.$parent.$parent.$parent.enableSidebar();
				}, 100);
				/*
	
	            for (var i in $scope.container.__placeholders) {
	                $scope.container.__placeholders[i]['open'] = false;
	            }
	            */
			});
		};
		
		$scope.refreshNested = function(prevId, placeholderVar) {
			
			$http({
				url : 'admin/api-cms-navitem/reload-placeholder',
				method : 'GET',
				params : { navItemPageId : $scope.NavItemController.item.nav_item_type_id, prevId : prevId, placeholderVar : placeholderVar}
			}).success(function(response) {
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
	zaa.controller("PageBlockEditController", function($scope, $sce, $http, ApiCmsNavItemPageBlockItem, AdminClassService) {
	
		$scope.onStart = function() {
			$scope.$apply(function() {
				AdminClassService.setClassSpace('onDragStart', 'page--drag-active');
			});
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
				// successfull toggle hidden state of block
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
		
		$scope.PagePlaceholderController = $scope.$parent;
		
		$scope.edit = false;
		$scope.config = false;

		$scope.toggleBlockSettings = function() {
			/* onclick="$(this).parents('.block').toggleClass('block--edit');" */
			$scope.edit = false;
			$scope.config = false;
		};

		$scope.toggleEdit = function() {
			if (!$scope.isEditable()) {
				return;
			}
			/* onclick="$(this).parents('.block').toggleClass('block--edit');" */
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
	        if (confirm('Block «' + block.name + '» wirklich löschen?')) {
	            ApiCmsNavItemPageBlockItem.delete({id: block.id}, function (rsp) {
	                $scope.PagePlaceholderController.NavItemTypePageController.refresh();
	                //Materialize.toast('Block «' + block.name + '» wurde entfernt!', 3000);
	            });
	        }
		};
		
		$scope.save = function () {
			ApiCmsNavItemPageBlockItem.update({ id : $scope.block.id }, $.param({json_config_values : JSON.stringify($scope.data), json_config_cfg_values : JSON.stringify($scope.cfgdata) }), function(rsp) {
				//Materialize.toast('<span> Block «'+$scope.block.name+'» wurde aktualisiert.</span>', 2000)
				$scope.edit = false;
				$scope.config = false;
				$scope.block.is_dirty = 1;
				
				$http({
				    url: 'admin/api-cms-navitem/get-block', 
				    method: "GET",
				    params: { blockId : $scope.block.id }
				}).success(function(rsp) {
					$scope.block = rsp;
				});
				
			});
		}
		
	});
	
	/**
	 * @TODO HANDLING SORT INDEX OF EACH BLOCK
	 */
	zaa.controller("DropBlockController", function($scope, ApiCmsNavItemPageBlockItem, AdminClassService) {
		
		$scope.PagePlaceholderController = $scope.$parent;
		
		$scope.droppedBlock = {};
		
		$scope.onDrop = function($event, $ui) {
			var sortIndex = $($event.target).data('sortindex');
			var moveBlock = $scope.droppedBlock['vars'] || false;
			if (moveBlock === false) {
				ApiCmsNavItemPageBlockItem.save($.param({ prev_id : $scope.placeholder.prev_id, sort_index : sortIndex, block_id : $scope.droppedBlock.id , placeholder_var : $scope.placeholder.var, nav_item_page_id : $scope.placeholder.nav_item_page_id }), function(rsp) {
					//console.log(rsp, $scope.placeholder.prev_id);
					$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
					//$scope.PagePlaceholderController.NavItemTypePageController.refresh();
					$scope.droppedBlock = {};
				})
			} else {
				ApiCmsNavItemPageBlockItem.update({ id : $scope.droppedBlock.id }, $.param({
					prev_id : $scope.placeholder.prev_id,
					placeholder_var : $scope.placeholder.var,
					sort_index : sortIndex
				}), function(rsp) {
					$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
					// console.log(rsp, $scope.placeholder.prev_id);
					//$scope.PagePlaceholderController.NavItemTypePageController.refresh();
					$scope.droppedBlock = {};
				});
			}
			AdminClassService.setClassSpace('onDragStart', undefined);
		}
	});
	
	zaa.controller("DroppableBlocksController", function($scope, $http, AdminClassService, ServiceBlocksData, $sce) {
	
		// service ServiceBlocksData inheritance
		
		$scope.blocksData = ServiceBlocksData.data;
		
		$scope.$on('service:BlocksData', function(event, data) {
			$scope.blocksData = data;
		});

		$scope.blocksDataReload = function() {
			return ServiceBlocksData.load(true);
		}
		
		// controller logic
		
		$scope.searchQuery = '';
		
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