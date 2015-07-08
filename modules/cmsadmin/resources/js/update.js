zaa.controller("NavController", function($scope, $stateParams, $http, AdminLangService, AdminClassService, MenuService, PlaceholderService) {
	
	$scope.id = parseInt($stateParams.navId);
	
	$scope.isDeleted = false;
	
	$scope.menuCats = MenuService.cats;
	
	$scope.PlaceholderService = PlaceholderService;
	
	$scope.placeholderState = $scope.PlaceholderService.status;
	
	$scope.$watch('placeholderState', function(n, o) {
		if (n !== o && n !== undefined) {
			$scope.PlaceholderService.delegate(n);
		}
	});
	
	$scope.navData = {};

    $scope.sidebar = false;
	
    $scope.enableSidebar = function() {
    	$scope.sidebar = true;
    }
    
    $scope.toggleSidebar = function() {
        $scope.sidebar = !$scope.sidebar;
    };
    
	$http.get('admin/api-cms-nav/detail', { params : { navId : $scope.id }}).success(function(response) {
		$scope.navData = response;
	});
	
	$scope.$watch(function() { return $scope.navData.is_hidden }, function(n, o) {
		if (o !== undefined) {
			$http.get('admin/api-cms-nav/toggle-hidden', { params : { navId : $scope.navData.id , hiddenStatus : n }}).success(function(response) {
				// send toast
				if (n == 1) {
					Materialize.toast('<span>Die Seite ist nun Unsichtbar.</span>', 2000)
				} else {
					Materialize.toast('<span>Die Seite ist nun Sichtbar.</span>', 2000)
				}
			});
		}
	});
	
	$scope.$watch(function() { return $scope.navData.cat_id }, function(n, o) {
		if (o != undefined && o != null && n != o) {
			$http.get('admin/api-cms-nav/update-cat', { params : { navId : $scope.navData.id , catId : n }}).success(function(response) {
				MenuService.refresh();
				Materialize.toast('<span>Die Seite wurde der Navigation ' + n + ' zugewiesen.</span>', 2000)
			});
			
		}
	});
	
    $scope.trash = function() {
    	if (confirm('your are sure you want to delete this page?')) {
    		$http.get('admin/api-cms-nav/delete', { params : { navId : $scope.navData.id }}).success(function(response) {
    			MenuService.refresh();
    			$scope.isDeleted = true;
    		});
    	}
    };
	
	$scope.AdminClassService = AdminClassService;
	
	$scope.AdminLangService = AdminLangService;
	
	$scope.refresh = function() {
		$scope.langs = $scope.AdminLangService.data;
	}
	
	$scope.refresh();
});

/**
 * @param $scope.lang
 *            from ng-repeat
 */
zaa.controller("NavItemController", function($scope, $http, $timeout, MenuService) {
	
	$scope.NavController = $scope.$parent;
	
	$scope.showContainer = false;
	
	$scope.isTranslated = false;
	
	$scope.item = [];
	
	$scope.copy = [];

	$scope.settings = false;
	
	$scope.reset = function() {
		$scope.copy = angular.copy($scope.item);
	}
	
	$scope.save = function(data) {
		
		var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};
		var navItemId = data.id;
		$http.post('admin/api-cms-navitem/update-item?navItemId=' + navItemId, $.param({ title : data.title, rewrite : data.rewrite }), headers).success(function(response) {
			Materialize.toast('<span> Die Seite «'+data.title+'» wurde aktualisiert.</span>', 2000);
			MenuService.refresh();
			$scope.refresh();
			$scope.toggleSettings();
		}).error(function(e) {
			console.log(e);
		})
	};
	
	$scope.toggleSettings = function() {
		$scope.reset();
		$scope.settings = !$scope.settings;
	};
	
	$scope.getItem = function(langId, navId) {
		$scope.showContainer = false;
		$http({
		    url: 'admin/api-cms-navitem/nav-lang-item', 
		    method: "GET",
		    params: { langId : langId, navId : navId }
		}).success(function(response) {
			if (response) {
				$scope.item = response;
				$scope.isTranslated = true;
				$timeout(function() {
					$scope.showContainer = true;
				}, 500);
			} else {
				$timeout(function() {
					$scope.showContainer = true;
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

zaa.controller("NavItemTypePageController", function($scope, $http, $timeout) {
	
	$scope.NavItemController = $scope.$parent;
	
	$scope.container = [];
	
	$scope.refresh = function() {
		$http({
			url : 'admin/api-cms-navitem/tree',
			method : 'GET',
			params : { navItemPageId : $scope.NavItemController.item.nav_item_type_id }
		}).success(function(response) {
			if ($scope.container.length == 0) {
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
	
	$scope.refresh();
	
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
	
	$scope.safe = function(html) {
		return $sce.trustAsHtml(html);
	}
	
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
	
	$scope.toggleEdit = function() {
		/* onclick="$(this).parents('.block').toggleClass('block--edit');" */
		$scope.edit = !$scope.edit;
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
                Materialize.toast('Block «' + block.name + '» wurde entfernt!', 3000);
            });
        }
	};
	
	$scope.save = function () {
		ApiCmsNavItemPageBlockItem.update({ id : $scope.block.id }, $.param({json_config_values : JSON.stringify($scope.data), json_config_cfg_values : JSON.stringify($scope.cfgdata) }), function(rsp) {
			Materialize.toast('<span> Block «'+$scope.block.name+'» wurde aktualisiert.</span>', 2000)
			$scope.edit = false;
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

zaa.controller("DroppableBlocksController", function($scope, $http, AdminClassService, DroppableBlocksService, $sce) {

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
	
	$scope.DroppableBlocksService = DroppableBlocksService;
});