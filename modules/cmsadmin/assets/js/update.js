zaa.controller("NavController", function($scope, $stateParams, ApiAdminLang, AdminClassService) {
	
	$scope.id = parseInt($stateParams.navId);
	
	$scope.AdminClassService = AdminClassService;
	
	$scope.refresh = function() {
		$scope.langs = ApiAdminLang.query();
	}
	
	$scope.refresh();
});

/**
 * @param $scope.lang from ng-repeat
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
			$scope.refresh();
			$scope.toggleSettings();
		}).error(function(e) {
			alert('error! see console');
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
					//alert('THIS PAGE IS NOT YET TRANSLATED');
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
 * @param $scope.placeholder from ng-repeat
 */
zaa.controller("PagePlaceholderController", function($scope) {
	
	$scope.NavItemTypePageController = $scope.$parent;
	
});


/**
 * @param $scope.block from ng-repeat
 */
zaa.controller("PageBlockEditController", function($scope, $sce, ApiCmsNavItemPageBlockItem, AdminClassService) {

	$scope.data = $scope.block.values || {};
	
	$scope.cfgdata = $scope.block.cfgvalues || {};
	
	$scope.edit = false;
	
	$scope.toggleEdit = function() {
		$scope.edit = !$scope.edit;
	}

	$scope.onStart = function() {
		$scope.$apply(function() {
			AdminClassService.setClassSpace('onDragStart', 'cms--drag-active');
		});
	}
	
	$scope.onStop = function() {
		$scope.$apply(function() {
			AdminClassService.setClassSpace('onDragStart', '');
		});
	}
	
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
	}
	
	$scope.save = function () {
		ApiCmsNavItemPageBlockItem.update({ id : $scope.block.id }, $.param({json_config_values : JSON.stringify($scope.data), json_config_cfg_values : JSON.stringify($scope.cfgdata) }), function(rsp) {
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

zaa.controller("DroppableBlocksController", function($scope, $http, AdminClassService) {

	$scope.onStart = function() {
		$scope.$apply(function() {
			AdminClassService.setClassSpace('onDragStart', 'cms--drag-active');
		});
	}
	
	$scope.onStop = function() {
		$scope.$apply(function() {
			AdminClassService.setClassSpace('onDragStart', '');
		});
	}
	
	$http({
		url : 'admin/api-cms-admin/get-all-blocks',
		method : 'GET'
	}).success(function(response) {
		$scope.blocks = response;
	});
	
	
});