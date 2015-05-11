
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
			return '<input class="form__input" type="text" ng-model="model" />';
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
			return '<select class="browser-default" ng-options="item.value as item.label for item in options" ng-model="model" >';
		}
	}
});

zaa.directive('zaaInputCheckbox', function(){
	return {
		restrict : 'E',
		transclude : false,
		scope : {
			"model" : '=',
			"name" : '=',
			"options" : '=' 
			/* 
			 * options.checked = [value1, value2],
			 * options.items[] = { 'value' : 1, 'label' => 'Label for Value 1' }
			 */
		},
		
		controller : function($scope) {
			
			$scope.model = [];
			
			$scope.toggleSelection = function (value) {
				console.log(value);
				for (var i in $scope.model) {
					if ($scope.model[i]['id'] == value.id) {
						$scope.model.splice(i, 1);
						return;
					}
				}
				
				$scope.model.push(value);
			}
			
			$scope.ctrlclick = function() {
				console.log($scope.model);
			}
			
			$scope.isChecked = function(item) {
				for (var i in $scope.model) {
					if ($scope.model[i]['id'] == item.id) {
						return true;
					}
				}
				return false;
			}
		},
		
		template : function() {
			return '<p ng-repeat="item in options.items"><input type="checkbox" ng-checked="isChecked(item)" ng-click="toggleSelection(item)" /><label>{{item.label}}</label></p>';
		}
	}
});

zaa.directive('zaaDatepicker', function() {
	return {
		restrict : 'E',
		scope : {
			"model" : "=",
			"name" : "=",
			"options" : "="
		},
		controller : function($scope, $filter) {
			
			$scope.datemodel = null;
			
			$scope.open = function($event) {
			    $event.preventDefault();
			    $event.stopPropagation();
			    $scope.opened = true;
			};
			
			$scope.$watch(function() { return $scope.model }, function(n) {
				if ($scope.model !== undefined) {
					var res = $scope.model.split("-");
					$scope.datemodel = new Date(res[2], (res[1]-1), res[0]); /* $scope.model; */
				}
			});
			
			$scope.dateOptions = {
				formatYear: 'yyyy',
				startingDay: 1
			};
			
			$scope.changer = function() {
				$scope.model = $filter('date')($scope.datemodel, 'dd-MM-yyyy');
			}
		},
		template: function(){
			return '<div><input type="text" datepicker-options="dateOptions" ng-change="changer()" datepicker-popup="dd-MM-yyyy" ng-model="datemodel" is-open="opened" close-text="Close" /><button type="button" ng-click="open($event)">OPEN</button></div>';
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

zaa.directive('zaaImageArrayUpload', function(){
	return {
		restrict : 'E',
		scope : {
			"model" : "="
		},
		controller : function($scope) {
			
			$scope.model = [];
			
			$scope.add = function() {
				$scope.model.push({ imageId : 0, caption : '' });
			}
			
			$scope.remove = function(key) {
				$scope.model.splice(key, 1);
			}
			
			$scope.debug = function() {
				console.log($scope.model);
			}
			
		},
		template : function() {
			return '<div><ul><li style="padding:5px; margin:5px; background-color:#F0F0F0;" ng-repeat="(key,image) in model">Caption: <input type="text" ng-model="image.caption" /><button type="button" ng-click="remove(key)">Entfernen</button><storage-image-upload ng-model="image.imageId"></storage-image-upload></li></ul><button ng-click="add()" type="button">+ Element</button></div>';
		}
	}
});

zaa.directive('zaaFileArrayUpload', function(){
	return {
		restrict : 'E',
		scope : {
			"model" : "="
		},
		controller : function($scope) {
			
			$scope.model = [];
			
			$scope.add = function() {
				$scope.model.push({ fileId : 0, caption : '' });
			}
			
			$scope.remove = function(key) {
				$scope.model.splice(key, 1);
			}
			
			$scope.debug = function() {
				console.log($scope.model);
			}
		},
		template : function() {
			return '<div><ul><li style="padding:5px; margin:5px; background-color:#F0F0F0;" ng-repeat="(key,file) in model">Caption: <input type="text" ng-model="file.caption" /><button type="button" ng-click="remove(key)">Entfernen</button><storage-file-upload ng-model="file.fileId"></storage-file-upload> </li></ul><button ng-click="add()" type="button">+ Element</button></div>';
		}
	}
});

zaa.directive("zaaListArray", function() {
	return {
		restrict : 'E',
		scope : {
			"model" : "="
		},
		controller : function($scope) {

			if ($scope.model == undefined) {
				$scope.model = [];
			}
			
			$scope.add = function() {
				$scope.model.push({ value : '' });
			}
			
			$scope.remove = function(key) {
				$scope.model.splice(key, 1);
			}
			
			$scope.debug = function() {
				console.log($scope.model);
			}
			
		},
		template : function() {
			return '<div><ul><li ng-repeat="(key,row) in model"><input type="text" ng-model="row.value" /><button type="button" ng-click="remove(key)">Entfernen</button></li></ul><button ng-click="add()" type="button">+ Element</button></div>';
		}
	}
});