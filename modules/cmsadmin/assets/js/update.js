zaa.controller("NavController", function($scope, $stateParams, $http, AdminLangService, AdminClassService, MenuService) {
	
	$scope.id = parseInt($stateParams.navId);
	
	$scope.isDeleted = false;
	
	$scope.menuCats = MenuService.cats;
	
	$scope.navData = {};
	
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
    }
	
	$scope.AdminClassService = AdminClassService;
	
	$scope.AdminLangService = AdminLangService;
	
	$scope.refresh = function() {
		$scope.AdminLangService.load();
		$scope.langs = $scope.AdminLangService.data;
	}
	
	$scope.refresh();
});

/**
 * @param $scope.lang
 *            from ng-repeat
 */
zaa.controller("NavItemController", function($scope, $http) {
	
	$scope.NavController = $scope.$parent;
	
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
			Materialize.toast('<span> Die Seite «'+data.title+'» wurde aktualisiert.</span>', 2000)
			$scope.refresh();
			$scope.toggleSettings();
		}).error(function(e) {
			console.log(e);
		})
	}
	
	$scope.toggleSettings = function() {
		$scope.reset();
		$scope.settings = !$scope.settings;
	}
	
	$scope.getItem = function(langId, navId) {
		$http({
		    url: 'admin/api-cms-navitem/nav-lang-items', 
		    method: "GET",
		    params: { langId : langId, navId : navId }
		}).success(function(rsp) {
			if (rsp.length > 1) {
				alert('FEHLER BEIM LADEN DER LANG. NAVID,LANGID Kombination kann nur 1 Datensatz erhalten.')
			} else {
				if (rsp.length == 0) {
					// alert('THIS PAGE IS NOT YET TRANSLATED');
				} else {
					$scope.item = rsp[0];
					$scope.reset();
				}
			}
		});
	}
	
	$scope.refresh = function() {
		$scope.getItem($scope.lang.id, $scope.NavController.id);
	}
	
	$scope.refresh();
	
});

zaa.controller("NavItemTypePageController", function($scope, $http) {
	
	$scope.NavItemController = $scope.$parent;
	
	$scope.container = [];
	
	$scope.refresh = function() {
		$http({
			url : 'admin/api-cms-navitem/tree',
			method : 'GET',
			params : { navItemPageId : $scope.NavItemController.item.nav_item_type_id }
		}).success(function(response) {
			$scope.container = response;
		});
	}
	
	$scope.refresh();
	
});

/**
 * @param $scope.placeholder
 *            from ng-repeat
 */
zaa.controller("PagePlaceholderController", function($scope) {
	
	$scope.NavItemTypePageController = $scope.$parent;
	
});


/**
 * @param $scope.block
 *            from ng-repeat
 */
zaa.controller("PageBlockEditController", function($scope, $sce, ApiCmsNavItemPageBlockItem, AdminClassService) {

	$scope.onStart = function() {
		$scope.$apply(function() {
			AdminClassService.setClassSpace('onDragStart', 'page--drag-active');
		});
	};
	
	$scope.onStop = function() {
		$scope.$apply(function() {
			AdminClassService.setClassSpace('onDragStart', '');
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
		});
	}
	
});

/**
 * @TODO HANDLING SORT INDEX OF EACH BLOCK
 */
zaa.controller("DropBlockController", function($scope, ApiCmsNavItemPageBlockItem) {
	
	$scope.PagePlaceholderController = $scope.$parent;
	
	$scope.droppedBlock = {};
	
	$scope.onDrop = function($event, $ui) {
		var sortIndex = $($event.target).data('sortindex');
		var moveBlock = $scope.droppedBlock['vars'] || false;
		if (moveBlock == false) {
			ApiCmsNavItemPageBlockItem.save($.param({ prev_id : $scope.placeholder.prev_id, sort_index : sortIndex, block_id : $scope.droppedBlock.id , placeholder_var : $scope.placeholder.var, nav_item_page_id : $scope.placeholder.nav_item_page_id }), function(rsp) {
				/* @todo: refresh statement, on change statement ? */
				$scope.PagePlaceholderController.NavItemTypePageController.refresh();
			})
		} else {
			ApiCmsNavItemPageBlockItem.update({ id : $scope.droppedBlock.id }, $.param({
				prev_id : $scope.placeholder.prev_id,
				placeholder_var : $scope.placeholder.var,
				sort_index : sortIndex
			}), function(rsp) {
				$scope.PagePlaceholderController.NavItemTypePageController.refresh();
				return;
			});
		}
		
		
	}
});

zaa.controller("DroppableBlocksController", function($scope, $http, AdminClassService, DroppableBlocksService) {

	$scope.onStart = function() {
		$scope.$apply(function() {
			AdminClassService.setClassSpace('onDragStart', 'page--drag-active');
		});
	}
	
	$scope.onStop = function() {
		$scope.$apply(function() {
			AdminClassService.setClassSpace('onDragStart', '');
		});
	}
	
	$scope.DroppableBlocksService = DroppableBlocksService;
});