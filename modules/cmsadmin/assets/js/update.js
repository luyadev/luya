zaa.controller("NavController", function($scope, $stateParams, ApiAdminLang) {
	
	$scope.id = parseInt($stateParams.navId);
	
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
zaa.controller("PageBlockEditController", function($scope, $sce, ApiCmsNavItemPageBlockItem) {

	$scope.data = $scope.block.values || {};
	
	$scope.edit = false;
	
	$scope.toggleEdit = function() {
		$scope.edit = !$scope.edit;
	}
	
	
	
	$scope.renderTemplate = function(template, dataVars) {
		
		var template = twig({
		    data: template
		});
		
		var content = template.render(dataVars);
		
		return $sce.trustAsHtml(content);
	}
	
	$scope.save = function () {
		ApiCmsNavItemPageBlockItem.update({ id : $scope.block.id }, $.param({json_config_values : JSON.stringify($scope.data) }), function(rsp) {
			$scope.edit = false;
		});
	}
	
});

zaa.controller("DropBlockController", function($scope, ApiCmsNavItemPageBlockItem) {
	
	$scope.PagePlaceholderController = $scope.$parent;
	
	$scope.droppedBlock = {};
	
	$scope.onDrop = function() {
		var moveBlock = $scope.droppedBlock['keys'] || false;
		if (moveBlock == false) {
			console.log('add_new_block', $scope.droppedBlock);
			ApiCmsNavItemPageBlockItem.save($.param({ prev_id : $scope.placeholder.prev_id, block_id : $scope.droppedBlock.id , placeholder_var : $scope.placeholder.var, nav_item_page_id : $scope.placeholder.nav_item_page_id }), function(rsp) {
				/* @todo: refresh statement, on change statement ? */
				$scope.PagePlaceholderController.NavItemTypePageController.refresh();
			})
		} else {
			console.log('move_block_to');
			console.log('current_placeholder', $scope.placeholder);
			console.log('to_move_block', $scope.droppedBlock);
			/*
			ApiCmsNavItemPageBlockItem.update($.param({ prev_id : $scope.placeholder.prev_id, block_id : $scope.droppedBlock.id , placeholder_space : $scope.placeholder.space, nav_item_page_id : $scope.placeholder.nav_item_page_id }), function(rsp) {
				$scope.par.type.refresh()
			})
			*/
		}
		
		
	}
});

zaa.controller("DroppableBlocksController", function($scope, ApiCmsBlock) {

	$scope.blocks = ApiCmsBlock.query();
	
});