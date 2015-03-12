/*
zaa.directive('crudUpdate', function() {
	return {
		restrict : 'E',
		transclude : 'element',
		replace : true,
		template : '<div ng-show="toggler.update"><hr /><h2>Datensatz {{data.updateId}} Bearbeiten</h2><div ng-transclude></div></div>'
	}
});

zaa.directive('crudCreate', function () {
	return {
		restrict : 'E',
		transclude : true,
		replace : true,
		template : '<div ng-show="toggler.create"><h2>Hinzufügen</h2><table class="table table-bordered"><ng-transclude></ng-transclude></table></div>'
	}
});
*/
zaa.directive('crudStrap', function(){
	return {
		restrict : 'E',
		transclude : false,
		template : '<div ng-show="toggler.strap"><h2>STRAP_ITEM</h2><div style="border:1px solid red;" ng-bind-html="data.strap.content"></div></div>'
	}
})
/*
zaa.directive('crudPluginSelect', function() {
	return {
		restrict : 'EA',
		scope : {
			fieldValue : '=',
			fieldArgs : '='
		},
		controller : function($scope) {
			var newValue = $scope.fieldArgs[$scope.fieldValue];
			$scope.fieldValue = newValue;
		},
		template : function($scope) {
			return '<span>{{fieldValue}}</span>';
		}
	}
});
*/