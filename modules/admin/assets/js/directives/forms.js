zaa.directive('zaaInjector', function($compile) {
	return {
		restrict : 'E',
		replace : true,
		scope : {
			"dir" : '=',
			"model" : '=',
			"options" : '='
		},
		link : function($scope, $element, attr) {
			$element.replaceWith($compile(angular.element('<' + $scope.dir + ' options="options" ng-model="model"/>'))($scope));
		}
	}
});

zaa.directive('zaaInputText', function(){
	return {
		restrict : 'E',
		transclude : false,
		scope : {
			"ngModel" : '=',
			"name" : '=',
			"options" : '='
		},
		controller : function($scope) {
			/* console.log($scope.options) */
		},
		template : function() {
			return '<input type="text" ng-model="ngModel" />';
		}
	}
});

zaa.directive('zaaInputTextarea', function(){
	return {
		restrict : 'E',
		transclude : false,
		scope : {
			"ngModel" : '=',
			"name" : '=',
			"options" : '='
		},
		template : function() {
			return '<texarea ng-model="ngModel" /></textarea>';
		}
	}
});

zaa.directive('zaaInputSelect', function(){
	return {
		restrict : 'E',
		transclude : false,
		scope : {
			"ngModel" : '=',
			"name" : '=',
			"options" : '='
		},
		
		controller : function($scope) {
			/* console.log($scope.options); */
		},
		
		template : function() {
			return '<select ng-options="item.id as item.label for item in options" ng-model="ngModel" >';
		}
	}
});