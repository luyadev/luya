(function() {
	"use strict";

	// CrudController.js
	zaa.controller("CrudController", function($scope, $http, $sce, $state) {
		
		/*
		 * 6.10.2015: remove dialogs, add variable toggler to display. added ngSwitch
		 */
		
		/**
		 * 0 = list
		 * 1 = add
		 * 2 = edit
		 */
		$scope.crudSwitchType = 0;
		
		$scope.switchTo = function(type) {
			$scope.crudSwitchType = type;
		};
		
		/* old definitions */
		
		$scope.loading = true;
		
		$scope.parentController = $scope.$parent;
		
		$scope.orderBy = "+id";
		
		$scope.showCrudList = true;
		
		$scope.currentMenuItem = null;
		
		$scope.createErrors = [];
		
		$scope.updateErrors = [];
		
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
		};
		
		$scope.debug = function() {
			console.log('config', $scope.config);
			console.log('data', $scope.data);
		};
		
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
				//dispatchEvent('onCrudActiveWindowLoad');
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
		
		$scope.deleteErrors = [];
		
		$scope.deleteItem = function(id, $event) {
			var cfm = confirm("Möchten Sie diesen Eintrag wirklich entfernen? (Kann nicht rückgängig gemacht werden.)");
			if (cfm == true) {
				$scope.deleteErrors = [];
				$http.delete($scope.config.apiEndpoint + '/'+id).success(function(r) {
					$scope.loadList();
					Materialize.toast('Der Datensatz wurde erfolgreich entfernt.', 3000);
				}).error(function(r) {
					for (var i in r) {
						angular.forEach(r[i], function(v, k) {
							$scope.deleteErrors.push(v);
						})
					}
				});
			}
		};
		
		$scope.toggleUpdate = function(id, $event) {
			$scope.data.updateId = id;
			$http.get($scope.config.apiEndpoint + '/'+id+'?' + $scope.config.apiUpdateQueryString).success(function(data) {
				$scope.data.update = data;
				$scope.switchTo(2);
			}).error(function(data) {
				alert('ERROR LOADING UPDATE DATA');
			});
		};
		
		$scope.closeUpdate = function () {
			$scope.switchTo(0);
	    };
		
		$scope.closeCreate = function() {
			$scope.switchTo(0);
		};
		
		
		$scope.openActiveWindow = function() {
			$('#activeWindowModal').openModal();
		};
		
		$scope.closeActiveWindow = function() {
			$('#activeWindowModal').closeModal();
		};
		
		/*
		$scope.openCreate = function () {
			$('#createModal').openModal({
				dismissible: false
			});
		};
		*/
	    
		$scope.submitUpdate = function () {
			
			$scope.updateErrors = [];
			
			$http.put($scope.config.apiEndpoint + '/' + $scope.data.updateId, angular.toJson($scope.data.update, true)).success(function(data) {
				$('#updateModal').closeModal();
				$scope.loadList();
				Materialize.toast('Der Datensatz wurde erfolgreich aktualsiert.', 3000);
				$scope.switchTo(0);
			}).error(function(data) {
				$scope.updateErrors = data;
			});
		};
		
		$scope.submitCreate = function() {
			
			$scope.createErrors = [];
			
			$http.post($scope.config.apiEndpoint, angular.toJson($scope.data.create, true)).success(function(data) {
				$('#createModal').closeModal();
				$scope.loadList();
				$scope.data.create = {};
				Materialize.toast('Der neue Datensatz wurde erfolgreich erstellt.', 3000);
				$scope.switchTo(0);
			}).error(function(data) {
				$scope.createErrors = data;
			});
		};
	
		$scope.loadList = function() {
			$scope.loading = true;
			$http.get($scope.config.apiEndpoint + '/?' + $scope.config.apiListQueryString).success(function(data) {
				$scope.loading = false;
				$scope.data.list = data;
			});
			
			$http.get($scope.config.apiEndpoint + '/services').success(function(rsp) {
				$scope.service = rsp;
			});
		};
		
		$scope.service = [];
		
		/*
		$scope.toggler = {
			create : false,
			update : false
		}
		*/
		
		$scope.data = {
			create : {},
			update : {},
			aw : {},
			list : {},
			updateId : 0
		};
		
		$scope.config = {};
		
	});
	
	// activeWindowController.js
	
	zaa.controller("ActiveWindowGalleryController", function($scope, $http, Upload, $timeout) {
		
		$scope.crud = $scope.$parent; // {{ data.aw.itemId }}
		
		/* UPLOAD */
		$scope.uploading = false;
		
		$scope.serverProcessing = false;
		
		$scope.uploadResults = null;
		
		$scope.$watch('uploadingfiles', function (uploadingfiles) {
	        if (uploadingfiles != null) {
				$scope.uploadResults = 0;
				$scope.uploading = true;
	            for (var i = 0; i < uploadingfiles.length; i++) {
	                $scope.errorMsg = null;
	                (function (uploadingfiles) {
	                	$scope.uploadUsingUpload(uploadingfiles);
	                })(uploadingfiles[i]);
	            }
	        }
	    });
	
		$scope.$watch('uploadResults', function(n, o) {
			if ($scope.uploadingfiles != null) {
				if (n == $scope.uploadingfiles.length) {
					$scope.serverProcessing = true;
					$scope.loadImages();
				}
			}
		});
		
		$scope.uploadUsingUpload = function(file) {
	        file.upload = Upload.upload({
	        	url: $scope.crud.getActiveWindowCallbackUrl('upload'),
	            file: file
	        });
	
	        file.upload.then(function (response) {
	            $timeout(function () {
	            	$scope.uploadResults++;
	            	file.processed = true;
	                file.result = response.data;
	            });
	        }, function (response) {
	            if (response.status > 0)
	                $scope.errorMsg = response.status + ': ' + response.data;
	        });
	
	        file.upload.progress(function (evt) {
	        	file.processed = false;
	            // Math.min is to fix IE which reports 200% sometimes
	            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
	        });
	    };
		
		$scope.images = [];
		
		$scope.loadImages = function() {
			$http.get($scope.crud.getActiveWindowCallbackUrl('images')).success(function(response) {
				$scope.images = response;
			})
		};
		
		$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
			$scope.loadImages();
		});
		
	});
	
	zaa.controller("ActiveWindowChangePassword", function($scope) {
		
		$scope.crud = $scope.$parent;
		
		$scope.init = function() {
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
				$scope.transport = response.data.transport;
			})
		};
	});
	
	// DefaultController.js.
	
	zaa.controller("DefaultController", function ($scope, $http, $state, $stateParams) {
		
		$scope.moduleId = $state.params.moduleId;
		
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
				if ($state.current.name == 'default.route') {
					var params = [$stateParams.moduleRouteId, $stateParams.controllerId, $stateParams.actionId];
					var route = params.join("-");
					
					if ($scope.itemRoutes.indexOf(route)) {
						$scope.currentItem = $scope.itemRoutes[route];
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
			.error(function(data) {
				console.log('error', data);
			});
		};
		
		$scope.init();
	});
	
	zaa.controller("DashboardController", function ($scope) {
	    $scope.logItemOpen = false;
	});
	
	// LayoutMenuController.js
	
	zaa.controller("LayoutMenuController", function ($scope, $http, $state, $location, $timeout) {
	
	    $scope.userMenuOpen = false;
	
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