
zaa.directive('zaaInjector', function($compile) {
	return {
		restrict : 'E',
		replace : true,
		transclude : false,
		scope : {
			"dir" : '=',
			"model" : '=',
			"options" : '=',
			"label" : "@label",
			'grid' : '@grid'
		},
		link : function($scope, $element, attr) {
			var elmn = $compile(angular.element('<' + $scope.dir + ' options="options" model="model" label="{{label}}" grid="{{grid}}" />'))($scope);
			$element.replaceWith(elmn);
		},
	}
});

zaa.directive('zaaInputText', function(){
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
		},
		template : function() {
			return '<div class="input-field col s{{grid}}"><input ng-model="model" type="text" /><label>{{label}}</label></div>';
		}
	}
});

zaa.directive('zaaTextarea', function(){
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
		},
		template : function() {
			return '<div class="input-field col s{{grid}}"><textarea ng-model="model" class="materialize-textarea"></textarea><label>{{label}}</label></div>';
		}
	}
});

zaa.directive('zaaInputPassword', function(){
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid',
		},
		template : function() {
			return '<div class="input-field col s{{grid}}"><input type="password" ng-model="model" /><label>{{label}}</label></div>';
		}
	}
});



zaa.directive('zaaInputSelect', function($compile){
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
		},
		template : function() {
			return '<div class="col s{{grid}}"><label>{{label}}</label><select class="browser-default" ng-options="item.value as item.label for item in options" ng-model="model"></select></div>';
		}
	}
});

/** 
 * options arg object:
 * 
 * options.checked = [value1, value2],
 * options.items[] = { 'value' : 1, 'label' => 'Label for Value 1' }
 */
zaa.directive('zaaInputCheckbox', function(){
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'grid' : '@grid'
		},
		controller : function($scope) {
			
			$scope.model = [];
			
			$scope.toggleSelection = function (value) {
				for (var i in $scope.model) {
					if ($scope.model[i]['id'] == value.id) {
						$scope.model.splice(i, 1);
						return;
					}
				}
				$scope.model.push(value);
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
		link : function(scope) {
			scope.random = Math.random().toString(36).substring(7);
		},
		template : function() {
			return '<div class="input-field col s{{grid}}"><p ng-repeat="(k, item) in options.items"><input type="checkbox" ng-checked="isChecked(item)" id="{{random}}_{{k}}" ng-click="toggleSelection(item)" /><label for="{{random}}_{{k}}">{{item.label}}</label></p></div>';
		}
	}
});

/**
 * <input input-date
    type="text"
    name="created"
    id="inputCreated"
    ng-model="currentTime"
    format="dd/mm/yyyy"
    months-full="{{ month }}"
    months-short="{{ monthShort }}"
    weekdays-full="{{ weekdaysFull }}"
    weekdays-short="{{ weekdaysShort }}"
    weekdays-letter="{{ weekdaysLetter }}"
    today="today"
    clear="clear"
    close="close"
    on-start="onStart()"
    on-render="onRender()"
    on-open="onOpen()"
    on-close="onClose()"
    on-set="onSet()"
    on-stop="onStop()" />
 */
zaa.directive('zaaDatepicker', function() {
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
		},
		controller : function($scope) {
			$scope.month = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
			$scope.monthShort = ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'];
			$scope.weekdaysFull = ['Sonntag', 'Monatg', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
			$scope.weekdaysLetter = ['S', 'M', 'D', 'M', 'D', 'F', 'S'];
			$scope.today = 'Heute';
			$scope.clear = 'Leeren';
			$scope.close = 'Schliessen';
			$scope.onStart = function () {
				if ($scope.model == undefined) {
					$scope.model = new Date();
					//console.log('start hat kein date!');
				} else {
					//console.log('start', $scope.model);
				}
			    //console.log('onStart', $scope.model);
			};
			$scope.onRender = function () {
				if ($scope.model == undefined) {
					$scope.model = new Date();
					//console.log('render HAT DATE!');
				} else {
					//console.log('render', $scope.model);
				}
			};
			$scope.onOpen = function () {
			    //console.log('onOpen', $scope.model);
			};
			$scope.onClose = function () {
			    //console.log('onClose', $scope.model);
			};
			$scope.onSet = function () {
			    //console.log('onSet', $scope.model);
			};
			$scope.onStop = function () {
			    //console.log('onStop', $scope.model);
			};
		},
		template: function(){
			return '<div class="input-field col s{{grid}}"><label>{{label}}</label><input type="text" ng-model="model"></input></div>';
			return '<div class="input-field col s{{grid}}"><label>{{label}}</label><input months-full="{{ month }}" months-short="{{ monthShort }}" weekdays-full="{{ weekdaysFull }}" weekdays-short="{{ weekdaysShort }}" weekdays-letter="{{ weekdaysLetter }}" today="today" clear="clear" close="close" on-start="onStart()" on-render="onRender()" on-open="onOpen()" on-close="onClose()" on-set="onSet()" on-stop="onStop()" input-date type="text" ng-model="model" format="dd/mm/yyyy"></input></div>';
		}
	}
});

/*
zaa.directive('zaaDatepicker', function() {
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
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
					$scope.datemodel = new Date(res[2], (res[1]-1), res[0]);
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
*/

zaa.directive('zaaFileUpload', function($compile){
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
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
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
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
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
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
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
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
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
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