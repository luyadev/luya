(function() {
	"use strict";
	
	zaa.config(function($stateProvider, resolverProvider) {
		$stateProvider
		.state("default.route.detail", {
			url: "/:id",
			parent: 'default.route',
			template: '<ui-view/>',
			controller:function($scope, $stateParams) {
				
				$scope.crud = $scope.$parent;
				
				$scope.init = function() {
					if (!$scope.crud.config.inline) {
						if ($scope.crud.data.updateId != $stateParams.id) {
							$scope.crud.toggleUpdate($stateParams.id);
						}
					}
				}
				
				$scope.init();
			}
		})
	});
	
	// CrudController.js
	/**
	 * Base Crud Controller
	 * 
	 * Assigned config variables from the php view assigned from child to parent:
	 * 
	 * + bool $config.inline Determines whether this crud is in inline mode orno
	 */
	zaa.controller("CrudController", function($scope, $filter, $http, $sce, $state, $timeout, $injector, AdminLangService, LuyaLoading, AdminToastService) {
		
		LuyaLoading.start();
		
		$scope.toast = AdminToastService;
		
		/*
		 * 6.10.2015: remove dialogs, add variable toggler to display. added ngSwitch
		 */
		$scope.AdminLangService = AdminLangService;
		
		/**
		 * As we have changed to ng-if some variables need to get pased by an object in order to keep the parent scope, as ng-if create a new scope.
		 */
		$scope.config = {
			filter: '0', groupBy: 0, groupByField: '0', pagerHiddenByAjaxSearch: false, fullSearchContainer: false,
			minLengthWarning: false
		};
		
		/**
		 * 0 = list
		 * 1 = add
		 * 2 = edit
		 */
		$scope.crudSwitchType = 0;
		
		$scope.switchTo = function(type, reset) {
			if (reset) {
				$scope.resetData();
			}
			if (type == 0 || type == 1) {
				if (!$scope.config.inline) {
					$state.go('default.route');
				}
			}
			$scope.crudSwitchType = type;
		};
		
		$scope.changeGroupByField = function() {
			if ($scope.config.groupByField == 0) {
				$scope.config.groupBy = 0;
			} else {
				$scope.config.groupBy = 1;
			}
		}
		
		// ng-change event triggers this method
		// this method is also used withing after save/update events in order to retrieve current selecter filter data.
		$scope.realoadCrudList = function(pageId) {
			LuyaLoading.start();
			if ($scope.config.filter == 0) {
				 $scope.loadList(pageId);
			} else {
				var url = $scope.config.apiEndpoint + '/filter?filterName=' + $scope.config.filter + '&' + $scope.config.apiListQueryString;
				if (pageId) {
					url = url + '&page=' + pageId;
				}
				if ($scope.orderBy) {
					url = url + '&sort=' + $scope.orderBy.replace("+", "");
				}
				$http.get(url).then(function(response) {
					$scope.setPagination(
						response.headers('X-Pagination-Current-Page'),
						response.headers('X-Pagination-Page-Count'),
						response.headers('X-Pagination-Per-Page'),
						response.headers('X-Pagination-Total-Count')
					);
					LuyaLoading.stop();
					$scope.data.list = response.data;
					$scope.data.listArray = response.data;
					$scope.reApplyOrder();
				});
			}
		};
		
		$scope.$watch('config.searchQuery', function(n, o) {
			
			if (n == o) {
				return;
			}
			
			var blockRequest = false;
			
			if ($scope.pager) {
				if (n.length == 0) {
					$timeout.cancel($scope.searchPromise);
					$scope.data.listArray = $scope.data.list;
					$scope.config.pagerHiddenByAjaxSearch = false;
				} else {
					$timeout.cancel($scope.searchPromise);
					
					if (blockRequest) {
						return;
					}
					
					$scope.searchPromise = $timeout(function() {
						if ($scope.config.fullSearchContainer) {
							$scope.data.listArray = $filter('filter')($scope.config.fullSearchContainer, n);
							$scope.config.pagerHiddenByAjaxSearch = true;
						} else {
							LuyaLoading.start();
							blockRequest = true;
							$http.post($scope.config.apiEndpoint + '/full-response?' + $scope.config.apiListQueryString, {query: n}).success(function(response) {
								$scope.config.pagerHiddenByAjaxSearch = true;
								$scope.config.fullSearchContainer = response;
								$scope.data.listArray = $filter('filter')(response, n);
								blockRequest = false;
								LuyaLoading.stop();
							});
						}
					}, 500)
				}
			} else {
				$scope.config.pagerHiddenByAjaxSearch = false;
				$scope.data.listArray = $filter('filter')($scope.data.list, n);
			}
		});
		
		/* export */
		
		$scope.exportLoading = false;
		
		$scope.exportResponse = false;
		
		$scope.exportDownloadButton = false;
		
		$scope.exportData = function() {
			$scope.exportLoading = true;
			$http.get($scope.config.apiEndpoint + '/export').success(function(response) {
				$scope.exportLoading = false;
				$scope.exportResponse = response;
				$scope.exportDownloadButton = true;
			});
		};
		
		$scope.exportDownload = function() {
			$scope.exportDownloadButton = false;
			window.open($scope.exportResponse.url);
			return false;
		}
		
		/* old definitions */
		
		$scope.parentController = $scope.$parent;
		
		$scope.applySaveCallback = function() {
			if ($scope.saveCallback != 0 && $scope.saveCallback != null && $scope.saveCallback != false) {
				$injector.invoke($scope.saveCallback, this);
			}
		}
		
		$scope.showCrudList = true;
		
		$scope.currentMenuItem = null;
		
		$scope.init = function () {
			$scope.loadList();
			$scope.$watch(function() { return $scope.parentController.currentItem }, function(newValue) {
				$scope.currentMenuItem = newValue;
			});
		};
		
		$scope.isOrderBy = function(field) {
			if (field == $scope.orderBy) {
				return true;
			}
			
			return false;
		};
		
		$scope.changeOrder = function(field, sort) {
			$scope.orderBy = sort + field;
			if ($scope.pager && !$scope.config.pagerHiddenByAjaxSearch) {
				$scope.realoadCrudList(1);
			} else {
				$scope.data.listArray = $filter('orderBy')($scope.data.listArray, sort + field);
			}
		};
		
		$scope.reApplyOrder = function() {
			$scope.data.listArray = $filter('orderBy')($scope.data.listArray, $scope.orderBy);
		};
		
		$scope.activeWindowReload = function() {
			$scope.getActiveWindow($scope.data.aw.hash, $scope.data.aw.itemId);
		}
		
		$scope.getActiveWindow = function (activeWindowId, id, $event) {
			$http.post('admin/ngrest/render', $.param({ itemId : id, activeWindowHash : activeWindowId , ngrestConfigHash : $scope.config.ngrestConfigHash }), {
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			})
			.success(function(data) {
				$scope.openActiveWindow();
				$scope.data.aw.itemId = id;
				$scope.data.aw.configCallbackUrl = $scope.config.activeWindowCallbackUrl;
				$scope.data.aw.configHash = $scope.config.ngrestConfigHash;
				$scope.data.aw.hash = activeWindowId;
				$scope.data.aw.id = activeWindowId; /* @todo: remove! BUT: equal to above, but still need in jquery accessing */
				$scope.data.aw.content = $sce.trustAsHtml(data);
				$scope.$broadcast('awloaded', {id: activeWindowId});
			})
		};
	
		$scope.getActiveWindowCallbackUrl = function(callback) {
			return $scope.data.aw.configCallbackUrl + '?activeWindowCallback=' + callback + '&ngrestConfigHash=' + $scope.data.aw.configHash + '&activeWindowHash=' + $scope.data.aw.hash;
		};
		
		/**
		 * new returns a promise promise.hten(function(answer) {
		 * 
		 * }, function(error) {
		 * 
		 * }, function(progress) {
		 * 
		 * });
		 * 
		 * instead of return variable
		 */
		$scope.sendActiveWindowCallback = function(callback, data) {
			var data = data || {};
			return $http.post($scope.getActiveWindowCallbackUrl(callback), $.param(data), {
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
		};
		
		$scope.deleteItem = function(id, $event) {
			AdminToastService.confirm(i18n['js_ngrest_rm_page'], function($timeout, $toast) {
				$http.delete($scope.config.apiEndpoint + '/'+id).success(function(r) {
					$scope.loadList();
					$toast.close();
					AdminToastService.success(i18n['js_ngrest_rm_confirm'], 2000);
				}).error(function(data) {
					$scope.printErrors(data);
				});
			});
		};
		
		$scope.toggleUpdate = function(id) {
			$scope.resetData();
			$http.get($scope.config.apiEndpoint + '/'+id+'?' + $scope.config.apiUpdateQueryString).success(function(data) {
				$scope.data.update = data;
				$scope.switchTo(2);
				if (!$scope.config.inline) {
					$state.go('default.route.detail', {id : id});
				}
				$scope.data.updateId = id;
			}).error(function(data) {
				AdminToastService.error(i18n['js_ngrest_error'], 2000);
			});
		};
		
		$scope.closeUpdate = function () {
			$scope.switchTo(0, true);
	    };
		
		$scope.closeCreate = function() {
			$scope.switchTo(0, true);
		};
		
		$scope.activeWindowModal = true;
		
		$scope.openActiveWindow = function() {
			$scope.activeWindowModal = false;
		};
		
		$scope.closeActiveWindow = function() {
			$scope.activeWindowModal = true;
		};
		
		$scope.highlightId = 0;
		
		$scope.isHighlighted = function(itemId) {
			if (itemId[$scope.config.pk] == $scope.highlightId) {
				return true;
			}
			
			return false;
		};
		
		$scope.printErrors = function(data) {
			angular.forEach(data, function(value, key) {
				AdminToastService.error(value.message, 4500);
			});
		};
		
		$scope.submitUpdate = function () {
			$http.put($scope.config.apiEndpoint + '/' + $scope.data.updateId, angular.toJson($scope.data.update, true)).success(function(data) {
				if ($scope.pager) {
					$scope.realoadCrudList($scope.pager.currentPage);
				} else {
					$scope.realoadCrudList();
				}
				
				$scope.applySaveCallback();
				AdminToastService.success(i18n['js_ngrest_rm_update'], 2000);
				$scope.switchTo(0, true);
				$scope.highlightId = $scope.data.updateId;
				$timeout(function() {
					$scope.highlightId = 0;
				}, 4000);
			}).error(function(data) {
				$scope.printErrors(data);
			});
		};
		
		$scope.submitCreate = function() {
			$http.post($scope.config.apiEndpoint, angular.toJson($scope.data.create, true)).success(function(data) {
				$scope.realoadCrudList();
				$scope.applySaveCallback();
				AdminToastService.success(i18n['js_ngrest_rm_success'], 2000);
				$scope.switchTo(0, true);
			}).error(function(data) {
				$scope.printErrors(data);
			});
		};
	
		$scope.loadService = function() {
			$http.get($scope.config.apiEndpoint + '/services').success(function(serviceResponse) {
				$scope.service = serviceResponse;
			});
		}
		
		$scope.loadList = function(pageId) {
			LuyaLoading.start();
			$http.get($scope.config.apiEndpoint + '/services').success(function(serviceResponse) {
				$scope.service = serviceResponse;
				var url = $scope.config.apiEndpoint + '/?' + $scope.config.apiListQueryString;
				if (pageId !== undefined) {
					url = url + '&page=' + pageId;
				}
				if ($scope.orderBy) {
					url = url + '&sort=' + $scope.orderBy.replace("+", "");
				}
				$http.get(url).then(function(response) {
					$scope.setPagination(
						response.headers('X-Pagination-Current-Page'),
						response.headers('X-Pagination-Page-Count'),
						response.headers('X-Pagination-Per-Page'),
						response.headers('X-Pagination-Total-Count')
					);

					// return data
					LuyaLoading.stop();
					$scope.data.list = response.data;
					$scope.data.listArray = response.data;
					$scope.reApplyOrder();
				});
			});
		};
		
		$scope.service = false;
		
		$scope.resetData = function() {
			$scope.data.create = angular.copy({});
			$scope.data.update = angular.copy({});
		}
		
		$scope.pagerPrevClick = function() {
			if ($scope.pager.currentPage != 1) {
				$scope.realoadCrudList(parseInt($scope.pager.currentPage)-1);
			}
		};
		
		$scope.pagerNextClick = function() {
			if ($scope.pager.currentPage != $scope.pager.pageCount) {
				$scope.realoadCrudList(parseInt($scope.pager.currentPage)+1);
			}
		};
		
		$scope.pager = false;
		
		$scope.setPagination = function(currentPage, pageCount, perPage, totalItems) {
			if (currentPage != null && pageCount != null && perPage != null && totalItems != null) {
				
				var i = 1;
				var urls = [];
				for (i = 1; i <= pageCount; i++) {
					urls.push(i);
				}
				
				$scope.pager = {
					'currentPage': currentPage,
					'pageCount': pageCount,
					'perPage': perPage,
					'totalItems': totalItems,
					'pages': urls,
				};
			} else {
				$scope.pager = false;
			}
		}
		
		$scope.data = {
			create : {},
			update : {},
			aw : {},
			list : {},
			updateId : 0
		};
	});
	
// activeWindowController.js
	
	zaa.controller("ActiveWindowTagController", function($scope, $http, AdminToastService) {

		$scope.crud = $scope.$parent; // {{ data.aw.itemId }}
		
		$scope.tags = [];
		
		$scope.relation = {};
		
		$scope.newTagName = null;
		
		$scope.loadTags = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('LoadTags')).success(function(transport) {
				$scope.tags = transport;
			});
		};
		
		$scope.loadRelations = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('LoadRelations')).success(function(transport) {
				$scope.relation = {};
				transport.forEach(function(value, key) {
					$scope.relation[value.tag_id] = 1;
				});
			});
		};
		
		$scope.saveTag = function() {
			var tagName = $scope.newTagName;

			if (tagName !== "") {
				$scope.crud.sendActiveWindowCallback('SaveTag', {'tagName': tagName}).then(function(response) {
					if (response.data) {
						$scope.tags.push({id: response.data, name: tagName});
						AdminToastService.success(tagName + ' wurde gespeichert.', 2000);
					} else {
						AdminToastService.error(tagName + ' ' + i18n['js_tag_exists'], 2000);
					}
					$scope.newTagName = null;
				});
			}
		};
		
		$scope.saveRelation = function(tag, value) {
			$scope.crud.sendActiveWindowCallback('SaveRelation', {'tagId': tag.id, 'value': value}).then(function(response) {

				$scope.relation[tag.id] = response.data;

				AdminToastService.success(i18n['js_tag_success'], 2000);
			});
		};
		
		$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
			$scope.loadRelations();
		});
		
		$scope.loadTags();
		
	});
	
	/**
	 * ActiveWindow GalleryController
	 * 
	 * Ability to upload images, removed images from index, add new images via selecting from
	 * filemanager.
	 * 
	 * Changes content when parent crud controller changes value for active aw.itemId.
	 */
	zaa.controller("ActiveWindowGalleryController", function($scope, $http) {
		
		$scope.crud = $scope.$parent; // {{ data.aw.itemId }}
		
		$scope.files = {};
		
		$scope.isEmptyObject = function(files) {
			return angular.equals({}, files);
		};
		
		$scope.select = function(id) {
			if (!(id in $scope.files)) {
				$scope.crud.sendActiveWindowCallback('AddImageToIndex', {'fileId' : id }).then(function(response) {
					var data = response.data;
					$scope.files[data.fileId] = data;
				});
			}
		};
		
		$scope.loadImages = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('loadAllImages')).success(function(response) {
				$scope.files = {}
				response.forEach(function(value, key) {
					$scope.files[value.fileId] = value;
				});
			})
		};
		
		$scope.remove = function(file) {
			$scope.crud.sendActiveWindowCallback('RemoveFromIndex', {'imageId' : file.id }).then(function(response) {
				delete $scope.files[file.fileId];
			});
		};
		
		$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
			$scope.loadImages();
		});
		
	});
	
	zaa.controller("ActiveWindowChangePassword", function($scope) {
		
		$scope.crud = $scope.$parent;
		
		$scope.init = function() {
			$scope.errorMessage = [];
			$scope.error = false;
			$scope.submitted = false;
			$scope.transport = [];
			$scope.newpass = null;
			$scope.newpasswd = null;
		};
		
		$scope.$watch(function() { return $scope.crud.data.aw.itemId }, function(n, o) {
			$scope.init();
		});
		
		$scope.submit = function() {
			$scope.crud.sendActiveWindowCallback('save', {'newpass' : $scope.newpass, 'newpasswd' : $scope.newpasswd}).then(function(response) {
				$scope.submitted = true;
				$scope.error = response.data.error;
				$scope.transport = response.data.message;
				if ($scope.error) {
					$scope.errorMessage = response.data.message;
				}
			})
		};
	});
	
	zaa.controller("ActiveWindowGroupAuth", function($scope, $http, CacheReloadService) {
		
		$scope.crud = $scope.$parent; // {{ data.aw.itemId }}
		
		$scope.reload = function() {
			CacheReloadService.reload();
		};
		
		$scope.rights = [];
		
		$scope.auths = [];
		
		$scope.save = function(data) {
			$scope.crud.sendActiveWindowCallback('saveRights', {'data' : data }).then(function(response) {
				$scope.getRights();
				$scope.reload();
			});
		};
		
		$scope.toggleAll = function() {
			angular.forEach($scope.auths,function(value, key) {
				$scope.rights[value.id] = {base: 1, create: 1, update: 1, 'delete': 1 };
			})
		};
		
		$scope.untoggleAll = function() {
			angular.forEach($scope.auths,function(value, key) {
				$scope.rights[value.id] = {base: 0, create: 0, update: 0, 'delete': 0 };
			})
		};
		
		$scope.getRights = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('getRights')).success(function(response) {
				$scope.rights = response.rights;
				$scope.auths = response.auths;
			})
		};
		
		$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
			$scope.getRights();
		});
	});
	
// DefaultController.js.
	
	zaa.controller("DefaultController", function ($scope, $http, $state, $stateParams) {
		
		$scope.moduleId = $state.params.moduleId;
		
		$scope.loadDashboard = function() {
			$scope.currentItem = null;
			return $state.go('default', { 'moduleId' : $scope.moduleId});
		}
		
		$scope.items = [];
		
		$scope.itemRoutes = [];
		
		$scope.currentItem = null;
		
		$scope.dashboard = [];
		
		$scope.itemAdd = function (name, items) {
			
			$scope.items.push({name : name, items : items});
			
			for(var i in items) {
				var data = items[i];
				$scope.itemRoutes[data.route] = {
					alias : data.alias, icon : data.icon
				}
			}
		};
		
		$scope.getDashboard = function(nodeId) {
			$http.get('admin/api-admin-menu/dashboard', { params : { 'nodeId' : nodeId }} )
			.success(function(data) {
				$scope.dashboard = data;
			});
		};
		
		$scope.init = function() {
			$scope.get();
			$scope.getDashboard($scope.moduleId);
		};
		
		$scope.resolveCurrentItem = function() {
			if (!$scope.currentItem) {
				if ($state.current.name == 'default.route' || $state.current.name == 'default.route.detail') {
					var params = [$stateParams.moduleRouteId, $stateParams.controllerId, $stateParams.actionId];
					var route = params.join("-");
					if ($scope.itemRoutes.indexOf(route)) {
						$scope.currentItem = $scope.itemRoutes[route];
						$scope.currentItem.route = route;
					}
				}
			}
		};
		
		$scope.click = function(item) {
			$scope.currentItem = item;
			
			var id = item.route;
			
			var res = id.split("-");
			$state.go('default.route', { moduleRouteId : res[0], controllerId : res[1], actionId : res[2]});
		};
		
		$scope.get = function () {
			$http.get('admin/api-admin-menu/items', { params : { 'nodeId' : $scope.moduleId }} )
			.success(function(data) {
				for (var itm in data.groups) {
					var grp = data.groups[itm];				
					$scope.itemAdd(grp.name, grp.items);
				}
				$scope.resolveCurrentItem();
			})
		};
		
		$scope.$on('topMenuClick', function(e) {
			$scope.currentItem = null;
		});
		
		$scope.init();
	});
	
	zaa.controller("DashboardController", function ($scope) {
		$scope.logItemOpen = false;
	});
	
	// LayoutMenuController.js
	
	zaa.controller("LayoutMenuController", function ($scope, $http, $state, $location, $timeout, CacheReloadService, LuyaLoading, AdminToastService) {
	
		$scope.LuyaLoading = LuyaLoading;
		
		$scope.toastQueue = AdminToastService.queue;
		
		$scope.reload = function() {
			CacheReloadService.reload();
		}
	
		$scope.sidePanelUserMenu = false;
		
		$scope.sidePanelHelp = false;
		
		$scope.toggleHelpPanel = function() {
			$scope.sidePanelHelp = !$scope.sidePanelHelp;
			$scope.sidePanelUserMenu = false;
		};
		
		$scope.toggleUserPanel = function() {
			$scope.sidePanelUserMenu = !$scope.sidePanelUserMenu;
			$scope.sidePanelHelp = false;
		};
		
	    $scope.userMenuOpen = false;
	
		$scope.notify = null;
		
		$scope.forceReload = 0;
		
		$scope.showOnlineContainer = false;
		
		$scope.searchDetailClick = function(itemConfig, itemData) {
			if (itemConfig.type == 'custom') {
				$scope.click(itemConfig.menuItem).then(function() {
					if (itemConfig.stateProvider) {
						var params = {};
						angular.forEach(itemConfig.stateProvider.params, function(value, key) {
							params[key] = itemData[value];
						})
						
						$state.go(itemConfig.stateProvider.state, params).then(function() {
							$scope.closeSearchInput();
						})
					} else {
						$scope.closeSearchInput();
					}
				});
				
			} else {
				$scope.click(itemConfig.menuItem.module).then(function() {
					var res = itemConfig.menuItem.route.split("-");
					$state.go('default.route', { moduleRouteId : res[0], controllerId : res[1], actionId : res[2]}).then(function() {
						if (itemConfig.stateProvider) {
							var params = {};
							angular.forEach(itemConfig.stateProvider.params, function(value, key) {
								params[key] = itemData[value];
							})
							$state.go(itemConfig.stateProvider.state, params).then(function() {
								$scope.closeSearchInput();
							})
						} else {
							$scope.closeSearchInput();
						}
					})
				});
			}
		};
		
		(function tick(){
			$http.get('admin/api-admin-timestamp', { ignoreLoadingBar: true }).success(function(response) {
				$scope.forceReload = response.forceReload;
				if ($scope.forceReload) {
					AdminToastService.confirm(i18n['js_admin_reload'], function($timeout, $toast) {
						$scope.reload();
					});
				}
				$scope.notify = response.useronline;
				$timeout(tick, 60000);
			})
		})();
		
		$scope.searchQuery = null;
	
	    $scope.searchInputOpen = false;
	
	    $scope.escapeSearchInput = function() {
	        if( $scope.searchInputOpen ) {
	            $scope.closeSearchInput();
	        }
	    };
	
	    $scope.openSearchInput = function() {
	        $scope.searchInputOpen = true;
	    };
	
	    $scope.closeSearchInput = function() {
	        $scope.searchInputOpen = false;
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
			$scope.mobileOpen = false;
			$scope.$broadcast('topMenuClick', { menuItem : menuItem });
			if (menuItem.template) {
				return $state.go('custom', { 'templateId' : menuItem.template });
			} else {
				return $state.go('default', { 'moduleId' : menuItem.id});
			}
		};
		
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
		};
		
		$scope.get = function () {
			$http.get('admin/api-admin-menu')
			.success(function(data) {
				$scope.items = data;
			});
		};
		
		$scope.get();
	});

})();