
zaa.directive('zaaInjector', function($compile) {
	return {
		restrict : 'E',
		replace : true,
		transclude : false,
		scope : {
			"dir" : '=',
			"model" : '=',
			"options" : '='
		},
		link : function($scope, $element, attr) {
			var elmn = $compile(angular.element('<' + $scope.dir + ' options="options" model="model" />'))($scope);
			$element.replaceWith(elmn);
		},
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

zaa.directive('zaaFileUpload', function($compile){
	return {
		restrict : 'E',
		scope : {
			"model" : "="
		},
		template : function() {
			return '<storage-file-upload ng-model="model"></storage-file-upload>';
		}
	}
});

zaa.directive('zaaImageUpload', function($compile){
	return {
		restrict : 'E',
		scope : {
			"model" : "="
		},
		template : function() {
			return '<storage-image-upload ng-model="model"></storage-image-upload>';
		}
	}
});