
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

zaa.directive('zaaWysiwyg', function() {
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
		},
		template : function() {
			return '<textarea ng-wig="model"></textarea>';
		}
	}
});

zaa.directive('zaaNumber', function() {
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'		
		}, link: function($scope) {
			$scope.$watch(function() { return $scope.model }, function(n, o) {
				if(angular.isNumber($scope.model)) {
					$scope.isValid = true;
				} else {
					$scope.isValid = false;
				}
			})
		}, template : function() {
			return '<div class="input-field col s{{grid}}"><input ng-class="{\'invalid\' : !isValid }" type="number" ng-model="model" min="0" /><label>{{label}}</label></div>';
		}
	}
});

zaa.directive('zaaText', function(){
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

zaa.directive('zaaPassword', function(){
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



zaa.directive('zaaSelect', function($compile){
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
 * options.items[] = { 'id' : 1, 'label' => 'Label for Value 1' }
 */
zaa.directive('zaaCheckbox', function(){
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'grid' : '@grid',
			'label' : '@label'
		},
		controller : function($scope) {
			
			if ($scope.model == undefined) {
				$scope.model = [];
			}
			
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
			return '<div class="input-field col s{{grid}}"><h5>{{label}}</h5><p ng-repeat="(k, item) in options.items"><input type="checkbox" ng-checked="isChecked(item)" id="{{random}}_{{k}}" ng-click="toggleSelection(item)" /><label for="{{random}}_{{k}}">{{item.label}}</label></p></div>';
		}
	}
});

zaa.directive('zaaDatetime', function() {
	return {
		restrict : 'E',
		scope : {
			'model' : '=',
			'options' : '=',
			'label' : '@label',
			'grid' : '@grid'
		},
		link : function($scope, element, attr, ngModelCtrl) {
			$scope.reform = function() {
				var date = new Date($scope.year, ($scope.month-1), $scope.day, $scope.hour, $scope.min);
				var mil = date.getTime();
				$scope.model = (mil/1000);
			}
			
			$scope.$watch(function() { return $scope.model }, function(n, o) {
				if (n !== undefined & o == undefined) {
					var date = new Date(n*1000);
					$scope.day = date.getDate(),
					$scope.month = date.getMonth() + 1;
					$scope.year = date.getFullYear();
					$scope.min = date.getMinutes();
					$scope.hour = date.getHours();
				}
			})
		},
		template : function() {
			return '<div class="col s{{grid}}">Datum: <input ng-change="reform()" type="number" ng-model="day" min="1" max="31" style="width:34px;" />.<input ng-change="reform()" type="number" ng-model="month" min="1" max="12" style="width:34px;" />.<input ng-change="reform()" type="number" ng-model="year" min="1970" max="2050"  style="width:50px;" /> Zeit: <input ng-change="reform()" type="number" ng-model="hour" min="0" max="23" style="width:34px;" />:<input ng-change="reform()" type="number" ng-model="min" min="0" max="59" style="width:34px;" /></div>';
		}
	}
});

zaa.directive('zaaDate', function() {
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
		},
		/*
		link : function(scope) {
			scope.$watch('model', function(n) {
				if (n == undefined) {
					scope.model = new Date();
				}
			})
		},
		*/
		template: function(){
			return '<div class="input-field col s{{grid}}"><label>{{label}}</label><input input-date months-full="{{ month }}" format="dd.mm.yyyy" date-format months-short="{{ monthShort }}" weekdays-full="{{ weekdaysFull }}" weekdays-short="{{ weekdaysShort }}" weekdays-letter="{{ weekdaysLetter }}" today="today"  clear="clear" close="close" type="text" class="datepicker" ng-model="model"></input></div>';
		}
	}
});

zaa.directive('dateFormat', function() {
	return {
	    require: 'ngModel',
	    link: function(scope, element, attr, ngModelCtrl) {
			ngModelCtrl.$formatters.unshift(function(timestamp) {
				//console.log('unshift_date', timestamp);
				if (timestamp == undefined) {
					var tp = new Date();
				} else {
					var tp = new Date(timestamp*1000);
				}
				return tp.format('dd.mm.yyyy');
			});
			ngModelCtrl.$parsers.push(function(date) {
				//console.log('push_date', date);
				md = date.split(".");
				var eng = md[1] +"/" + md[0] + "/" + md[2];
				var mil = new Date(eng).getTime();
				return (mil/1000);
			});
	    }
	};
});

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
			return '<div class="col s{{grid}}"><storage-file-upload ng-model="model"></storage-file-upload><label>{{label}}</label></div>';
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
			return '<div class="col s12"><storage-image-upload ng-model="model" label="{{label}}"></storage-image-upload><div>';
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
			
			if ($scope.model == undefined) {
				$scope.model = [];
			}
			
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
			return '<div class="col s12"><h5>{{label}}</h5><div ng-repeat="(key,image) in model" class="row card-panel"><div class="col s4"><input type="text" ng-model="image.caption" /></div><div class="col s6"><storage-image-upload ng-model="image.imageId"></storage-image-upload></div><div class="col s2"><button type="button" class="btn" ng-click="remove(key)">Entfernen</button></div></div><div class="row"><div class="col s12"><button ng-click="add()" type="button" class="btn">+ Element</button></div></div></div>';
			//return '<div><ul><li style="padding:5px; margin:5px; background-color:#F0F0F0;" ng-repeat="(key,image) in model">Caption: <input type="text" ng-model="image.caption" /><button type="button" ng-click="remove(key)">Entfernen</button><storage-image-upload ng-model="image.imageId"></storage-image-upload></li></ul><button ng-click="add()" type="button">+ Element</button></div>';
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
			
			if ($scope.model == undefined) {
				$scope.model = [];
			}
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
			return '<div class="col s12"><h5>{{label}}</h5><div ng-repeat="(key,file) in model" class="row card-panel"><div class="col s4"><input type="text" ng-model="file.caption" /></div><div class="col s6"><storage-file-upload ng-model="file.fileId"></storage-file-upload></div><div class="col s2"><button type="button" class="btn" ng-click="remove(key)">Entfernen</button></div></div><div class="row"><div class="col s12"><button ng-click="add()" type="button" class="btn">+ Element</button></div></div></div>';
			
			//return '<div><ul><li style="padding:5px; margin:5px; background-color:#F0F0F0;" ng-repeat="(key,file) in model">Caption: <input type="text" ng-model="file.caption" /><button type="button" ng-click="remove(key)">Entfernen</button><storage-file-upload ng-model="file.fileId"></storage-file-upload> </li></ul><button ng-click="add()" type="button">+ Element</button></div>';
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
			return '<div class="col s12"><h5>{{label}}</h5><div ng-repeat="(key,row) in model" class="row"><div class="col input-field s10"><input type="text" ng-model="row.value" /></div><div class="col input-field s2"><button type="button" class="btn" ng-click="remove(key)">Entfernen</button></div></div><div class="row"><div class="col s12 field-input"><button ng-click="add()" class="btn" type="button">+ Hinzufügen</button></div></div></div>';
			//return '<div><ul><li ng-repeat="(key,row) in model"><input type="text" ng-model="row.value" /><button type="button" ng-click="remove(key)">Entfernen</button></li></ul><button ng-click="add()" type="button">+ Element</button></div>';
		}
	}
});