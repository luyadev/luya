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
			$element.replaceWith($compile(angular.element('<' + $scope.dir + ' options="options" model="model"/>'))($scope));
		}
	}
});

zaa.directive('zaaInputText', function(){
	return {
		restrict : 'E',
		transclude : false,
		replace : true,
		scope : {
			"model" : '=',
			"name" : '=',
			"options" : '='
		},
		controller : function($scope) {
			/* console.log($scope.options) */
		},
		template : function() {
			return '<input type="text" ng-model="model" />';
		}
	}
});

zaa.directive('zaaInputPassword', function(){
	return {
		restrict : 'E',
		transclude : false,
		replace : true,
		scope : {
			"model" : '=',
			"name" : '=',
			"options" : '='
		},
		controller : function($scope) {
			/* console.log($scope.options) */
		},
		template : function() {
			return '<input type="password" ng-model="model" />';
		}
	}
});

zaa.directive('zaaTextarea', function(){
	return {
		restrict : 'E',
		transclude : false,
		replace : true,
		scope : {
			"model" : '=',
			"name" : '=',
			"options" : '='
		},
		template : function() {
			return '<textarea ng-model="model"></textarea>';
		}
	}
});

zaa.directive('zaaInputSelect', function(){
	return {
		restrict : 'E',
		transclude : false,
		replace : true,
		scope : {
			"model" : '=',
			"name" : '=',
			"options" : '='
		},
		
		controller : function($scope) {
			/* console.log($scope.options); */
		},
		
		template : function() {
			return '<select ng-options="item.value as item.label for item in options" ng-model="model" >';
		}
	}
});

zaa.directive('zaaDatepicker', function() {
	return {
		restrict : 'E',
		transclude : false,
		replace : true,
		scope : {
			"model" : "=",
			"name" : "=",
			"options" : "="
		},
		
		controller : function($scope)
		{
			
		},
		
		template: function(){
			/* TBD */
		}
	}
});