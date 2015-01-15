zaa.controller("CreateInlineController", function($scope, $resource, ApiCmsNavItemPage) {
	
	$scope.layouts = $resource('admin/api-cms-layout/:id').query();

	$scope.dataPage = {
			nav_id : 1,
			lang_id : 1,
			nav_item_type : 1,
			nav_item_type_id : 0,
			title : 'der titel',
			rewrite : 'dierewrite'
	};
	
	$scope.submitPage = function() {
		
		ApiCmsNavItemPage.save($.param({'layout_id' : 1}), function(rsp) {
			
			var nav_item_type_page_id = rsp.id;
			
			$scope.dataPage.nav_item_type_id = nav_item_type_page_id;
			
			/*
			.save($.param($scope.dataPage), function(response) {
				console.log(response);
			});
			*/
			
		});
		
	}
	
});