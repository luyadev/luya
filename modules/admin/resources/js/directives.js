(function() {
	"use strict";

	// form.js
	zaa.directive("zaaInjector", function($compile) {
		return {
			restrict: "E",
			replace: true,
			transclude: false,
			scope: {
				"dir": "=",
				"model": "=",
				"options": "=",
				"label": "@label",
				"grid": "@grid",
				"fieldid": "@fieldid",
				"fieldname": "@fieldname",
				"placeholder": "@placeholder",
				"initvalue": "@initvalue"
			},
			link: function($scope, $element) {
				var elmn = $compile(angular.element('<' + $scope.dir + ' options="options" initvalue="{{initvalue}}" fieldid="{{fieldid}}" fieldname="{{fieldname}}" placeholder="{{placeholder}}" model="model" label="{{label}}" i18n="{{grid}}" />'))($scope);
				$element.replaceWith(elmn);
			},
		}
	});
	
	zaa.directive("zaaWysiwyg", function() {
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			template: function() {
				return '<textarea ng-wig="model" name="{{name}}"></textarea>';
			}
		}
	});
	
	zaa.directive("zaaNumber", function() {
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname",
				"placeholder": "@placeholder"
			}, link: function($scope) {
				$scope.$watch(function() { return $scope.model }, function(n, o) {
					if(angular.isNumber($scope.model)) {
						$scope.isValid = true;
					} else {
						$scope.isValid = false;
					}
				})
			}, template: function() {
				//return '<div class="input-field col s{{grid}}"><input placeholder="{{placeholder}}" name="{{name}}" id="{{id}}" ng-class="{\'invalid\' : !isValid }" type="number" ng-model="model" min="0" /><label for="{{id}}">{{label}}</label></div>';
                return '<div class="input input--text"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><input id="{{id}}" name="{{name}}" ng-model="model" type="number" min="0" class="input__field" ng-class="{\'invalid\' : !isValid }" placeholder="{{placeholder}}" /><div class="input__active"></div></div></div>';
			}
		}
	});
	
	zaa.directive("zaaText", function(){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname",
				"placeholder": "@placeholder"
			},
			template: function() {
                //return '<div class="input-field col s{{grid}}"><input placeholder="{{placeholder}}" id="{{id}}" name="{{name}}" ng-model="model" type="text" /><label for="{{id}}">{{label}}</label></div>';
                return '<div class="input input--text" ng-class="{\'input--hide-label\': i18n}"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><input id="{{id}}" name="{{name}}" ng-model="model" type="text" class="input__field" placeholder="{{placeholder}}" /><div class="input__active"></div></div></div>';
			}
		}
	});
	
	zaa.directive("zaaTextarea", function(){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname",
				"placeholder": "@placeholder"
			},
			template: function() {
				//return '<div class="input-field col s{{grid}}"><textarea placeholder="{{placeholder}}" id="{{id}}" name="{{name}}" ng-model="model" class="materialize-textarea"></textarea><label for="{{id}}">{{label}}</label></div>';
                return '<div class="input input--textarea" ng-class="{\'input--hide-label\': i18n}"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><textarea id="{{id}}" name="{{name}}" ng-model="model" type="text" class="input__field" placeholder="{{placeholder}}"></textarea><div class="input__active"></div></div></div>';
			}
		}
	});
	
	zaa.directive("zaaPassword", function(){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			template: function() {
                return '<div class="input input--text" ng-class="{\'input--hide-label\': i18n}"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><input id="{{id}}" name="{{name}}" ng-model="model" type="password" class="input__field" placeholder="{{placeholder}}" /><div class="input__active"></div></div></div>';
			}
		}
	});
	
	zaa.directive("zaaSelect", function($timeout){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname",
				"initvalue": "@initvalue"
			},
			link: function(scope) {
				$timeout(function(){
					scope.$watch(function() { return scope.model }, function(n, o) {
						if (n === undefined && o === undefined) {
							if (jQuery.isNumeric(scope.initvalue)) {
								scope.initvalue = parseInt(scope.initvalue);
							}
							scope.model = scope.initvalue;
						}
					})
				});
			},
			template: function() {
				// return '<div class="col s{{grid}}"><label for="{{id}}">{{label}}</label><select name="{{name}}" id="{{id}}" class="browser-default" ng-options="item.value as item.label for item in options" ng-model="model"></select></div>';
                return '<div class="input input--select"><label class="input__label" for="{{id}}">{{label}}</label><select name="{{name}}" id="{{id}}" class="input__field browser-default" ng-options="item.value as item.label for item in options" ng-model="model"></select></div>';
			}
		}
	});
	
	/**
	 * options = {'true-value' : 1, 'false-value' : 0};
	 */
	zaa.directive("zaaCheckbox", function() {
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname",
				"label": "@label"
			},
			controller: function($scope) {
				if ($scope.options === null) {
					$scope.valueTrue = 1;
					$scope.valueFalse = 0;
				} else {
					$scope.valueTrue = $scope.options['true-value'];
					$scope.valueFalse = $scope.options['false-value'];	
				}
			},
			template: function() {
				return '<div class="input input--single-checkbox">' +
                            '<input type="checkbox" id="{{id}}" name="{{name}}" ng-true-value="{{valueTrue}}" ng-false-value="{{valueFalse}}" ng-model="model" type="checkbox" />' +
                            '<label for="{{id}}" class="input__label">{{label}}</label>' +
                        '</div>';
			}
		}
	});
	
	/** 
	 * options arg object:
	 * 
	 * options.items[] = { "id" : 1, "label" => 'Label for Value 1' }
	 * 
	 * new
	 * 
	 * options.items[] = { "value" : 1, "label" => 'Label for Value 1' }
	 */
	zaa.directive("zaaCheckboxArray", function(){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname",
				"label": "@label"
			},
			controller: function($scope) {
				
				if ($scope.model == undefined) {
					$scope.model = [];
				}
				
				$scope.toggleSelection = function (value) {
					for (var i in $scope.model) {
						if ($scope.model[i]["id"] == value.value) {
							$scope.model.splice(i, 1);
							return;
						}
					}
					$scope.model.push({ id: value.value});
				}
				
				$scope.isChecked = function(item) {
					for (var i in $scope.model) {
						if ($scope.model[i]["id"] == item.value) {
							return true;
						}
					}
					return false;
				}
			},
			link: function(scope) {
				scope.random = Math.random().toString(36).substring(7);
			},
			template: function() {
				return '<div class="input input--multiple-checkboxes">' +
                    '<label class="input__label">{{label}}</label>' +
                    '<div class="input__field-wrapper">' +
                        '<div ng-repeat="(k, item) in options.items track by k">' +
                            '<input type="checkbox" ng-checked="isChecked(item)" id="{{random}}_{{k}}" ng-click="toggleSelection(item)" />' +
                            '<label for="{{random}}_{{k}}">{{item.label}}</label>' +
                        '</div>' +
                    '</div>';
			}
		}
	});
	
	zaa.directive("zaaDatetime", function() {
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"id": "@fieldid",
				"name": "@fieldname",
				"i18n": "@i18n"
			},
			controller: function($scope) {
				$scope.reform = function() {
					var date = new Date($scope.year, ($scope.month-1), $scope.day, $scope.hour, $scope.min);
					var mil = date.getTime();
					$scope.model = (mil/1000);
				}
				
				$scope.onInit = function() {
					if ($scope.model === undefined) {
						var date = new Date();
						$scope.day = date.getDate(),
						$scope.month = date.getMonth() + 1;
						$scope.year = date.getFullYear();
						$scope.min = date.getMinutes();
						$scope.hour = date.getHours();
						$scope.reform();
					}
				}
				
				$scope.onInit();
				
				$scope.$watch(function() { return $scope.model }, function(n, o) {
					if (n !== undefined) {
						var date = new Date(n*1000);
						$scope.day = date.getDate(),
						$scope.month = date.getMonth() + 1;
						$scope.year = date.getFullYear();
						$scope.min = date.getMinutes();
						$scope.hour = date.getHours();
					} else {
						var date = new Date();
						$scope.day = date.getDate(),
						$scope.month = date.getMonth() + 1;
						$scope.year = date.getFullYear();
						$scope.min = date.getMinutes();
						$scope.hour = date.getHours();
					}
				})
			},
			template: function() {
				/*
				return '<div class="col s{{grid}} form__datetimepicker">' +
							'<label>{{label}}</label>' +
							'<input ng-blur="reform()" type="text" ng-model="day" placeholder="Tag" />.' +
							'<input ng-blur="reform()" type="text" ng-model="month" placeholder="Monat" />.' + 
							'<input ng-blur="reform()" type="text" ng-model="year" placeholder="Jahr" /> - ' + 
							'<input ng-blur="reform()" type="text" ng-model="hour" placeholder="Stunde" />:' +
							'<input ng-blur="reform()" type="text" ng-model="min" placeholder="Minute" />' +
						'</div>';
				*/
				return '<div class="input input--date">' +
						'<label class="input__label">{{label}}</label>' +
		                '<div class="input__field-wrapper">' +
			                    '<input ng-blur="reform()" type="text" ng-model="day" placeholder="Tag" class="input__field" /><span class="input__divider">.</span>' +
			                    '<input ng-blur="reform()" type="text" ng-model="month" placeholder="Monat" class="input__field" /><span class="input__divider">.</span>' +
			                    '<input ng-blur="reform()" type="text" ng-model="year" placeholder="Jahr" class="input__field" /><span class="input__divider">-</span>' +
			                    '<input ng-blur="reform()" type="text" ng-model="hour" placeholder="Stunde" class="input__field" /><span class="input__divider">:</span>' +
			                    '<input ng-blur="reform()" type="text" ng-model="min" placeholder="Minute" class="input__field" />' +
		                    '</div>'
		               '</div>';
			}
		}
	});
	
	zaa.directive("zaaDate", function() {
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"id": "@fieldid",
				"name": "@fieldname",
				"i18n": "@i18n"
			},
			controller: function($scope) {
				$scope.reform = function() {
					var date = new Date($scope.year, ($scope.month-1), $scope.day);
					var mil = date.getTime();
					$scope.model = (mil/1000);
				}
				
				$scope.onInit = function() {
					if ($scope.model === undefined) {
						var date = new Date();
						$scope.day = date.getDate(),
						$scope.month = date.getMonth() + 1;
						$scope.year = date.getFullYear();
						$scope.reform();
					}
				}
				
				$scope.onInit();
				
				$scope.$watch(function() { return $scope.model }, function(n, o) {
					if (n !== undefined) {
						var date = new Date(n*1000);
						$scope.day = date.getDate(),
						$scope.month = date.getMonth() + 1;
						$scope.year = date.getFullYear();
					} else {
						var date = new Date();
						$scope.day = date.getDate(),
						$scope.month = date.getMonth() + 1;
						$scope.year = date.getFullYear();
					}
				})
			},
			template: function() {
				return '<div class="input input--date">' +
							'<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<input ng-blur="reform()" type="text" ng-model="day" placeholder="Tag" class="input__field" /><span class="input__divider">.</span>' +
                                '<input ng-blur="reform()" type="text" ng-model="month" placeholder="Monat" class="input__field" /><span class="input__divider">.</span>' +
                                '<input ng-blur="reform()" type="text" ng-model="year" placeholder="Jahr" class="input__field" />' +
                            '</div>'
						'</div>';
			}
		}
	});
	
	zaa.directive("zaaTable", function() {
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			controller: function($scope) {
				
				if ($scope.model == undefined) {
					$scope.model = [{}];
				}
				
				$scope.addColumn = function() {
					var len = 0;
					for (var o in $scope.model[0]) {
						len++;
					}
					
					for(var i in $scope.model) {
						 $scope.model[i][len] = '';
					}
				}
				
				$scope.addRow = function() {
					var elmn = $scope.model[0];
					var ins = {};
					for (var i in elmn) {
						ins[i] = '';
					}
					
					$scope.model.push(ins);
				}
				
				$scope.removeColumn = function(key) {
					for (var i in $scope.model) {
						var item = $scope.model[i];
                        if(item instanceof Array) {
                            item.splice(key, 1);
                        } else {
                            delete item[key];
                        }
					}
				}
				
				$scope.removeRow = function(key) {
					$scope.model.splice(key, 1);
				}
			},
			template: function() {
				return '<div><h5>{{label}}</h5>' +
							'<button ng-click="addColumn()" type="button" style="float:right;">Spalte Rechts einfügen</button>'+
							'<table>'+
							'<thead><tr><td width="90"></td><td data-ng-repeat="(hk, hr) in model[0] track by hk"><strong><button type="button" ng-click="removeColumn(hk)" class="btn-floating"><i class="material-icons">delete</i></button></strong></td></tr></thead>' +
							'<tr data-ng-repeat="(key, row) in model track by key"><td>#{{key+1}} <button type="button" class="btn-floating" ng-click="removeRow(key)"><i class="material-icons">delete</i></button></td><td data-ng-repeat="(field,value) in row track by field"><input type="text" ng-model="model[key][field]" /></td></tr>'+
							'</table><button ng-click="addRow()" type="button">Neue Zeile einfügen</button>'+
						'</div>';
			}
		}
	});
	
	zaa.directive("zaaFileUpload", function($compile){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			template: function() {
				return '<div class="input input--file-upload">' +
                            '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<storage-file-upload ng-model="model"></storage-file-upload>' +
                            '</div>' +
                        '</div>';
			}
		}
	});
	
	zaa.directive("zaaImageUpload", function($compile){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			template: function() {
				return '<div class="input input--image-upload">' +
                            '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<storage-image-upload options="options" ng-model="model"></storage-image-upload>' +
                            '</div>' +
                        '</div>';
			}
		}
	});
	
	zaa.directive("zaaImageArrayUpload", function(){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			controller: function($scope) {
				
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
			template: function() {
				return '<div class="input input--image-array imagearray">' +
	                        '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<p class="list__no-entry" ng-hide="model.length > 0">Noch keine Einträge erfasst. Neue Einträge fügen Sie mit dem <span class="teal-text">+</span> links unten ein.</p>' +
                                '<div ng-repeat="(key,image) in model track by key" class="row list__item">' +

                                    '<div class="list__left row">' +
                                        '<div class="col s8">' +
                                            '<storage-image-upload ng-model="image.imageId"></storage-image-upload>' +
                                        '</div>' +
                                        '<div class="input-field col s4">' +
                                            '<textarea ng-model="image.caption" class="materialize-textarea"></textarea>' +
                                            '<label>Beschreibung</label>' +
                                        '</div>' +
                                    '</div>' +

                                    '<div class="list__right">' +
                                        '<button type="button" class="btn-floating left list__delete-button [ red lighten-1 ][ waves-effect waves-circle waves-light ]" ng-click="remove(key)" tabindex="-1"><i class="material-icons">remove</i></button>' +
                                    '</div>' +

                                '</div>' +
                                '<button ng-click="add()" type="button" class="btn-floating left list__add-button [ teal ][ waves-effect waves-circle waves-light ]"><i class="material-icons">add</i></button>' +
                            '</div>' +
	                    '</div>';
			}
		}
	});
	
	zaa.directive("zaaFileArrayUpload", function(){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			controller: function($scope, $element, $timeout) {
				
				if ($scope.model == undefined) {
					$scope.model = [];
				}
	
				$scope.add = function() {
					$scope.model.push({ fileId : 0, caption : '' });
				};
				
				$scope.remove = function(key) {
					$scope.model.splice(key, 1);
				};
				
				$scope.debug = function() {
					console.log($scope.model);
				}
	
			},
			template: function() {
				return '<div class="input input--file-array filearray">' +
			                '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<p class="list__no-entry" ng-hide="model.length > 0">Noch keine Einträge erfasst. Neue Einträge fügen Sie mit dem <span class="teal-text">+</span> links unten ein.</p>' +
                                '<div ng-repeat="(key,file) in model track by key" class="row list__item">' +

                                    '<div class="list__left row">' +
                                        '<div class="filearray__upload col s8">' +
                                            '<storage-file-upload ng-model="file.fileId"></storage-file-upload>' +
                                        '</div>' +
                                        '<div class="input-field col s4">' +
                                            '<input type="text" ng-model="file.caption" class="filearray__description-input" />' +
                                            '<label>Beschreibung</label>' +
                                        '</div>' +
                                    '</div>' +

                                    '<div class="list__right">' +
                                        '<button class="btn-floating left list__delete-button [ red lighten-1 ][ waves-effect waves-circle waves-light ]" ng-click="remove(key)" tabindex="-1"><i class="material-icons">remove</i></button>' +
                                    '</div>' +
                                '</div>' +
                                '<button ng-click="add()" type="button" class="btn-floating left list__add-button [ teal ][ waves-effect waves-circle waves-light ]"><i class="material-icons">add</i></button>' +
                            '</div>' +
			            '</div>';
			}
		}
	});
	
	zaa.directive("zaaListArray", function() {
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			controller: function($scope, $element, $timeout) {
	
				if ($scope.model == undefined) {
					$scope.model = [];
				}
				
				$scope.add = function() {
					$scope.model.push({ value : '' });
	                $scope.setFocus();
				};
				
				$scope.remove = function(key) {
					$scope.model.splice(key, 1);
				};
				
				$scope.refactor = function(key, row) {
					if (key !== ($scope.model.length -1)) {
						if (row['value'] == "") {
							$scope.remove(key);
						}
					}
				};
	
	            $scope.setFocus = function() {
	                $timeout(function() {
	                    var input = $element.children('.list').children('.list__item:last-of-type').children('.list__left').children('input');
	
	                    if(input.length == 1) {
	                        input[0].focus();
	                    }
	                }, 50);
	            }
	
			},
			template: function() {
				return '<div class="input input--list list">' +
	                        '<label class="input__label">Auflistung</label>' +
                            '<div class="input__field-wrapper">' +
                                '<p class="list__no-entry" ng-hide="model.length > 0">Noch keine Einträge erfasst. Neue Einträge fügen Sie mit dem <span class="teal-text">+</span> links unten ein.</p>' +
                                '<div ng-repeat="(key,row) in model track by key" class="list__item">' +
                                    '<div class="list__left">' +
                                        '<input class="list__input" type="text" ng-model="row.value" />' +
                                    '</div>' +
                                    '<div class="list__right">' +
                                        '<button class="btn-floating left list__delete-button [ red lighten-1 ][ waves-effect waves-circle waves-light ]" ng-click="remove(key)" tabindex="-1"><i class="material-icons">remove</i></button>' +
                                    '</div>' +
                                '</div>' +
                                '<button ng-click="add()" type="button" class="btn-floating left list__add-button [ teal ][ waves-effect waves-circle waves-light ]"><i class="material-icons">add</i></button>' +
                            '</div>' +
	                    '</div>';
			}
		}
	});
	
	zaa.directive("zaaCmsPage", function(NewMenuService, $timeout){
		return {
			restrict: "E",
			scope: {
				"model": "=",
				"options": "=",
				"label": "@label",
				"i18n": "@i18n",
				"id": "@fieldid",
				"name": "@fieldname"
			},
			controller: function($scope) {
				$scope.click = function(value) {
					$scope.model = parseInt(value);
				};
			},
			template: function(){
				return '<div class="col s{{grid}}"><h3>{{label}}</h3><p ng-repeat="(key, title) in options track by key"><input type="radio" ng-model="model" ng-click="click(key)" name="cmsPageNavId" value="{{key}}" id="{{id}}_{{key}}" /> <label for="{{id}}_{{key}}">{{title}}</label></p></div>';
			}
		}
	});
	
	// storage.js
	
	zaa.factory('FileListeService', function($http, $q) {
		var service = [];
		
		service.data = [];
		
		service.get = function(folderId, forceReload) {
			return $q(function(resolve, reject) {
				if (folderId in service.data && forceReload !== true) {
					resolve(service.data[folderId]);
				} else {
					$http.get('admin/api-admin-storage/get-files', { params : { folderId : folderId } }).success(function(response) {
						service.data[folderId] = response;
						resolve(response);
					});
				}
			});
			
		}
		
		return service;
	});
	
	zaa.factory('FileIdService', function($http, $q) {
		var service = [];
		
		service.data = [];
		
		service.get = function(fileId, forceReload) {
			return $q(function(resolve, reject) {
				if (fileId in service.data && forceReload !== true) {
					//console.log('request existing fileId', fileId);
					resolve(service.data[fileId]);
				} else {
					$http.get('admin/api-admin-storage/file-path', { params: { fileId : fileId } }).success(function(response) {
						service.data[fileId] = response;
						resolve(response);
					}).error(function(response) {
						console.log('Error while loading fileID ' + fileId, response);
					})
				}
			});
		}
		
		return service;
	});
	
	zaa.factory('ImageIdService', function($http, $q) {
		var service = [];
		
		service.data = [];
		
		service.get = function(imageId, forceReload) {
			return $q(function(resolve, reject) {
				if (imageId in service.data && forceReload !== true) {
					//console.log('request existing imageId', imageId);
					resolve(service.data[imageId]);
				} else {
					$http.get('admin/api-admin-storage/image-path', { params: { imageId : imageId } }).success(function(response) {
						service.data[imageId] = response;
						//console.log('request NOT EXISTING imageId', imageId);
						resolve(response);
					}).error(function(response) {
						console.log('Error while loading imageId ' + imageId, response);
					})
				}
			});
		}
		
		return service;
	});
	
	zaa.factory('FilemanagerFolderService', function() {
		var service = [];
		
		service.folderId = 0;
		
		service.set = function(id) {
			service.folderId = id;
		}
		
		service.get = function() {
			return service.folderId;
		}
		
		return service;
	});
	
	zaa.factory('FilemanagerFolderListService', function($http, $q) {
		var service = [];
		
		service.data = null;
		
		service.get = function(forceReload) {
			return $q(function(resolve, reject) {
				if (service.data === null || forceReload === true) {
					$http.get('admin/api-admin-storage/get-folders').success(function(response) {
						service.data = response;
						resolve(response);
					}).error(function(response) {
						reject(response);
					});
				} else {
					resolve(service.data);
				}
				
			});
		}
		
		return service;
	});
	
	zaa.directive('storageFileUpload', function($http, FileIdService) {
		return {
			restrict : 'E',
			scope : {
				ngModel : '='
			},
			link : function(scope) {
				
				scope.modal = true;
				scope.fileinfo = null;
				
				scope.select = function(fileId) {
					scope.toggleModal();
					scope.ngModel = fileId;
				}
				
				scope.toggleModal = function() {
					scope.modal = !scope.modal;
				}
				
				scope.$watch(function() { return scope.ngModel }, function(n, o) {
					if (n != 0 && n != null && n !== undefined) {
						FileIdService.get(n).then(function(response) {
							scope.fileinfo = response;
						});
					}
				});
			},
			templateUrl : 'storageFileUpload'
		}
	});
	
	zaa.directive('storageImageUpload', function($http, ApiAdminFilter, ImageIdService) {
		return {
			restrict : 'E',
			scope : {
				ngModel : '=',
				options : '=',
			},
			link : function(scope) {
	
				scope.noFilters = function() {
					if (scope.options) {
						return scope.options.no_filter;
					}
				}
				
	            scope.imageLoading = false;
				scope.fileId = 0;
				scope.filterId = 0;
				scope.imageinfo = null;
				
				scope.filters = ApiAdminFilter.query();
				scope.originalFileIsRemoved = false;
				
				scope.lastapplyFileId = 0;
				scope.lastapplyFilterId = 0;
				
				scope.filterApply = function() {
					
					if (scope.fileId == 0) {
						alert('Sie müssen zuerst eine Datei auswählen um den Filter anzuwenden.');
						return;
					}
					
					if (scope.lastapplyFileId == scope.fileId && scope.lastapplyFilterId == scope.filterId) {
						return;
					}
					
					scope.originalFileIsRemoved = false;
					
	                scope.imageLoading = true;
	
	                scope.lastapplyFileId = scope.fileId;
	                scope.lastapplyFilterId = scope.filterId;
	                
					$http.post('admin/api-admin-storage/image-upload', $.param({ fileId : scope.fileId, filterId : scope.filterId }), {
			        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			        }).success(function(success) {
			        	if (!success) {
			        		alert('Beim Anwenden des Filters auf die Datei ist ein Fehler Passiert');
			        	} else {
			        		if (success.image.file_is_deleted == 1) {
			        			scope.originalFileIsRemoved = true;
			        		}
			        		scope.ngModel = success.id;
			        	}
	
	                    scope.imageLoading = false;
					}).error(function(error) {
						alert('Beim Anwenden des Filters auf die Datei ist ein Fehler Passiert');
	                    scope.imageLoading = false;
					});
				};
				
				scope.$watch(function() { return scope.filterId }, function(n, o) {
					if (n != null && n !== undefined && scope.fileId !== 0 && n !== o) {
						scope.filterApply();
					}
				});
				
				scope.$watch(function() { return scope.fileId }, function(n, o) {
					if (n != 0 && n !== undefined && n !== o) {
						scope.filterApply();
					}
				});
				
				scope.$watch(function() { return scope.ngModel }, function(n, o) {
					if (n != 0 && n != null && n !== undefined) {
						ImageIdService.get(n).then(function(response) {
							scope.imageinfo = response;
							scope.filterId = response.filter_id;
							scope.fileId = response.file_id;
						});
					}
				})
			},
			templateUrl : 'storageImageUpload'
		}
	});
	
	
	
	
	/**
	 * FILE MANAGER DIR
	 */
	zaa.directive("storageFileManager", function(FileListeService, Upload, FilemanagerFolderService, FilemanagerFolderListService) {
		return {
			restrict : 'E',
			transclude : false,
			scope : {
				allowSelection : '@selection',
				onlyImages : '@onlyImages'
			},
			controller : function($scope, $http, $timeout) {
				
				$scope.showFolderForm = false;
				
				$scope.files = [];
				
				$scope.folders = [];
				
				$scope.selectedFiles = [];
				
				$scope.uploading = false;
				
				$scope.showFoldersToMove = false;
				
				$scope.serverProcessing = false;
				
				$scope.uploadResults = null;
				
				$scope.$watch('uploadingfiles', function (uploadingfiles) {
			        if (uploadingfiles != null) {
						$scope.uploadResults = 0;
						$scope.uploading = true;
			            for (var i = 0; i < uploadingfiles.length; i++) {
			                $scope.errorMsg = null;
			                (function (uploadingfiles) {
			                	$scope.uploadUsingUpload(uploadingfiles);
			                })(uploadingfiles[i]);
			            }
			        }
			    });
	
				$scope.$watch('uploadResults', function(n, o) {
					if ($scope.uploadingfiles != null) {
						if (n == $scope.uploadingfiles.length) {
							$scope.serverProcessing = true;
							$scope.getFiles($scope.currentFolderId, true);
						}
					}
				})
				
				$scope.uploadUsingUpload = function(file) {
			        file.upload = Upload.upload({
			        	url: 'admin/api-admin-storage/files-upload',
	                    fields: {'folderId': $scope.currentFolderId},
	                    file: file
			        });
	
			        file.upload.then(function (response) {
			            $timeout(function () {
		            		$scope.uploadResults++;
			            	file.processed = true;
			                file.result = response.data;
			                
			                if (file.result.upload == false) {
			                	$scope.errorMsg = file.result.message;
			                }
			            });
			        }, function (response) {
			        	if (response.status > 0) {
			                $scope.errorMsg = response.status + ': ' + response.data;
			            }
			        });
	
			        file.upload.progress(function (evt) {
			        	file.processed = false;
			            // Math.min is to fix IE which reports 200% sometimes
			            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
			        });
			    }
				
				$scope.hasSelection = function() {
					if ($scope.selectedFiles.length > 0) {
						return true;
					}
					
					return false;
				}
				
				$scope.moveFilesTo = function(folder) {
					$http.post('admin/api-admin-storage/files-move', $.param({'fileIds' : $scope.selectedFiles, 'toFolderId' : folder.id}), {
			        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			        }).success(function(transport) {
			        	$scope.showFoldersToMove = false;
						$scope.clearSelection();
						
						$scope.getFiles($scope.currentFolderId, true);
						
						FileListeService.get(folder.id, true).then(function(r) {
						});
						
			        });
				}

                $scope.deleteFolder = function(folder) {
                    $http.post('admin/api-admin-storage/folder-delete?folderId=' + folder.data.id, $.param({ name : folder.data.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).success(function(transport) {
                        folder.remove = false;
                        FilemanagerFolderListService.get(true).then(function(r) {
                            $scope.folders = r;
                        });

                    });
                }
				
				$scope.updateFolder = function(folder) {
					$http.post('admin/api-admin-storage/folder-update?folderId=' + folder.data.id, $.param({ name : folder.data.name }), {
			        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			        }).success(function(transport) {
			        	folder.edit = false;
			        });
				}
				
				$scope.clearSelection = function() {
					$scope.selectedFiles = [];
				}
				
				$scope.toggleSelection = function(file) {
					if ($scope.allowSelection == 'true') {
						$scope.selectFile(file);
						return;
					}
	
					var i = $scope.selectedFiles.indexOf(file.id);
					if (i > -1) {
						$scope.selectedFiles.splice(i, 1);
					} else {
						$scope.selectedFiles.push(file.id);
					}
				}
	
				$scope.toggleSelectionAll = function() {
					if ($scope.allowSelection == 'false') {
						if ($scope.selectedFiles.length > 0 && $scope.selectedFiles.length != $scope.files.length) {
							$scope.selectedFiles = [];
						}
	
						for (var i = $scope.files.length - 1; i >= 0; i--) {
							$scope.toggleSelection($scope.files[i]);
						};
					}
				}
				
				$scope.inSelection = function(file) {
					var response = $scope.selectedFiles.indexOf(file.id);
					
					if (response != -1) {
						return true;
					}
					
					return false;
				}
				
				$scope.removeSelectedItems = function() {
					var cfm = confirm("Möchten Sie diese Datei wirklich entfernen?");
					if (cfm) {
						$http.post('admin/api-admin-storage/files-delete', $.param({'ids' : $scope.selectedFiles}), {
				        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
				        }).success(function(transport) {
				        	if (transport) {
				        		$scope.getFiles(FilemanagerFolderService.get(), true);
				        		$scope.clearSelection();
				        	}
				        });
					}
				}
				
				$scope.createNewFolder = function(newFolderName) {
					$http.post('admin/api-admin-storage/folder-create', $.param({ folderName : newFolderName , parentFolderId : $scope.currentFolderId }), {
			        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			        }).success(function(transport) {
			        	if (transport) {
			        		$scope.showFolderForm = false;
			        		$scope.newFolderName = '';
			        		$http.get('admin/api-admin-storage/get-folders').success(function(response) {
			        			$scope.folders = response;
			        		});
			        	}
			        });
				}
				
				$scope.verifyFileHidden = function(file) {
					if ($scope.onlyImages) {
						if (!file.is_image) {
							return true;
						}
					}
					return false;
				}
				
				$scope.folderFormToggler = function() {
					$scope.showFolderForm = !$scope.showFolderForm;
				}
				
				$scope.selectFile = function(file) {
					$scope.$parent.select(file.id);
				}
	
	            $scope.toggleModal = function() {
	                $scope.$parent.toggleModal();
	            }
				
				$scope.loadFolder = function(folderId) {
					$scope.showFoldersToMove = false;
					$scope.clearSelection();
					FilemanagerFolderService.set(folderId);
					$scope.currentFolderId = folderId;
					$scope.getFiles(folderId);
				}
				
				$scope.getFiles = function(folderId, forceReload) {
					FileListeService.get(folderId, forceReload).then(function(r) {
						$scope.files = r;
						$scope.uploading = false;
						$scope.serverProcessing = false;
					});
				}
				
				$timeout(function() {
					FilemanagerFolderListService.get().then(function(r) {
						$scope.folders = r;
		    			$scope.getFiles(FilemanagerFolderService.get());
		    			$scope.currentFolderId = FilemanagerFolderService.get();
					});
				}, 100);
			},
			templateUrl : 'storageFileManager'
		}
	});

})();