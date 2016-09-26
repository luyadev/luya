(function() {
    "use strict";

    zaa.directive("crudLoader", function($http, $sce) {
    	return {
    		restrict: "E",
    		replace: true,
    		transclude: false,
    		scope: {
    			"api": "@api",
    		},
    		controller: function($scope) {

    			$scope.showWindow = false;

    			$scope.content = null;

    			$scope.toggleWindow = function() {
    				if (!$scope.showWindow) {
    					$http.get($scope.api+'/?inline=1').then(function(response) {
    						$scope.content = $sce.trustAsHtml(response.data);
    						$scope.showWindow = true;
    					})
    				} else {
    					$scope.$parent.loadService();
    					$scope.showWindow = false;
    				}
    			}
    		},
    		template: function() {
    			return '<div class="crud-loader-tag"><button ng-click="toggleWindow()" type="button" class="btn btn-floating green lighten-1"><i class="material-icons">playlist_add</i></button><div ng-show="showWindow" class="modal__wrapper"><div class="modal"><button class="btn waves-effect waves-light modal__close btn-floating red" type="button" ng-click="toggleWindow()"><i class="material-icons">close</i></button><div class="modal-content" compile-html ng-bind-html="content"></div></div><div class="modal__background"></div></div></div>';
    		}
    	}
    });

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

    /**
     * @var object $model Contains existing data for the displaying the existing relations
     *
     * ```js
     * [
     * 	{'sortpos': 1, 'value': 1},
     *  {'sortpos': 2, 'value': 4},
     * ]
     * ```
     *
     * @var object $options Provides options to build the sort relation array:
     *
     * ```js
     * {
     * 	'sourceData': [
     * 		{'value': 1, 'label': 'Source Entry #1'}
     * 		{'value': 2, 'label': 'Source Entry #2'}
     * 		{'value': 3, 'label': 'Source Entry #3'}
     * 		{'value': 4, 'label': 'Source Entry #4'}
     * 	]
     * }
     * ```
     */
    zaa.directive("zaaSortRelationArray", function() {
    	return {
    		restrict: "E",
    		scope: {
    			"model": "=",
    			"options": "=",
    			"label": "@label",
    			"i18n": "@i18n",
                "id": "@fieldid",
                "name": "@fieldname",
    		},
    		controller: function($scope, $filter) {

    			$scope.searchString = null;

    			$scope.sourceData = [];

                $scope.dropdownOpen = false;

    			$scope.$watch(function() { return $scope.model }, function(n, o) {
    				if (n == undefined) {
    					$scope.model = [];
    				}
    			});

    			$scope.$watch(function() { return $scope.options }, function(n, o) {
    				if (n !== undefined && n !== null) {
    					$scope.sourceData = n.sourceData;
    				}
    			})

    			$scope.getSourceOptions = function() {
    				return $scope.sourceData;
    			};

    			$scope.getModelItems = function() {
    				return $scope.model;
    			}

    			$scope.addToModel = function(option) {

    				var match = false;

    				angular.forEach($scope.model, function(value, key) {
    					if (value.value == option.value) {
    						match = true;
    					}
    				})

    				if (!match) {
    					$scope.searchString = null;
    					$scope.model.push({'value': option.value, 'label': option.label});
    				}
    			};

    			$scope.removeFromModel = function(key) {
    				$scope.model.splice(key, 1);
    			}

    			$scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                }

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                };

                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                }

                $scope.elementInModel = function(item) {
            		var match = false;

    				angular.forEach($scope.model, function(value, key) {
    					if (value.value == item.value) {
    						match = true;
    					}
    				});

    				return !match;
                }
    		},
    		template: function() {
    			return '<div class="input input--sortrelation" ng-class="{\'input--hide-label\': i18n}">' +
                    '<label class="input__label" for="{{id}}">{{label}}</label>' +
                    '<div class="input__field-wrapper">' +
                        '<div class="zaa-sortrelation">' +
                            '<ul class="zaa-sortrelation__list>">' +
                                '<li class="zaa-sortrelation__entry" ng-repeat="(key, item) in getModelItems() track by key">' +
                                    '<div class="zaa-sortrelation__arrows">' +
                                        '<i ng-show="{{key > 0}}" ng-click="moveUp(key)" class="material-icons" style="transform: rotate(270deg);">play_arrow</i>' +
                                        '<i ng-show="showDownButton(key)" ng-click="moveDown(key)" class="material-icons" style="transform: rotate(90deg);">play_arrow</i>' +
                                    '</div>' +

                                    '<span class="zaa-sortrelation__text">{{item.label}}</span>' +

                                    '<div class="zaa-sortrelation__trash">' +
                                        '<i ng-click="removeFromModel(key)" class="material-icons">delete</i>' +
                                    '</div>' +
                                '</li>' +
                                '<li class="zaa-sortrelation__dropdown-filter" ng-class="{\'zaa-sortrelation__dropdown-filter--open\': dropdownOpen}">' +
                                    '<input class="zaa-sortrelation__filter" type="search" ng-model="searchString" placeholder="Hinzufügen..." ng-focus="dropdownOpen = true" />' +
                                    '<ul class="zaa-sortrelation__dropdown">' +
                                        '<li class="zaa-sortrelation__dropdown-entry" ng-repeat="option in getSourceOptions() | filter:searchString" ng-show="dropdownOpen && elementInModel(option)" ng-click="addToModel(option)">' +
                                            '<i class="material-icons">add_circle</i><span>{{ option.label }}</span>' +
                                        '</li>' +
                                    '</ul>' +
                                    '<div class="zaa-sortrelation__dropdown-arrow" ng-class="{\'zaa-sortrelation__dropdown-arrow--active\': dropdownOpen}">' +
                                        '<i ng-click="dropdownOpen = !dropdownOpen" class="material-icons">arrow_drop_down</i>' +
                                    '</div>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>';
    		}
    	}
    });

    zaa.directive("zaaLink", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "name": "@fieldname",
            },
            template: function() {
                return '<update-form-redirect data="model"></update-form-redirect>';
            }
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
                return '<textarea ng-wig="model" buttons="bold, italic, link, list1, list2" name="{{name}}"></textarea>';
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
                "placeholder": "@placeholder",
                "initvalue" : "@initvalue"
            }, link: function($scope) {
                $scope.$watch(function() { return $scope.model }, function(n, o) {
                	if (n == undefined) {
                		$scope.model = parseInt($scope.initvalue);
                	}
                    if(angular.isNumber($scope.model)) {
                        $scope.isValid = true;
                    } else {
                        $scope.isValid = false;
                    }
                })
            }, template: function() {
                return '<div class="input input--text" ng-class="{\'input--hide-label\': i18n}"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><input id="{{id}}" name="{{name}}" ng-model="model" type="number" min="0" class="input__field" ng-class="{\'invalid\' : !isValid }" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });

    zaa.directive("zaaDecimal", function() {
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
            }, controller: function($scope) {
                if ($scope.options === null) {
                    $scope.steps = 0.01;
                } else {
                    $scope.steps = $scope.options['steps'];
                }
            }, link: function($scope) {
                $scope.$watch(function() { return $scope.model }, function(n, o) {
                    if(angular.isNumber($scope.model)) {
                        $scope.isValid = true;
                    } else {
                        $scope.isValid = false;
                    }
                })
            }, template: function() {
                return '<div class="input input--text" ng-class="{\'input--hide-label\': i18n}"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><input id="{{id}}" name="{{name}}" ng-model="model" type="number" min="0" step="{{steps}}" class="input__field" ng-class="{\'invalid\' : !isValid }" placeholder="{{placeholder}}" /></div></div>';
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
                return '<div class="input input--text" ng-class="{\'input--hide-label\': i18n}"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><input id="{{id}}" insert-paste-listener maxlength="255" name="{{name}}" ng-model="model" type="text" class="input__field" placeholder="{{placeholder}}" /></div></div>';
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
            /*
            link : function(scope, element) {
            	var e = element.find('textarea')[0];
            	var h = angular.element(e).height();
            	var recalc = function(e, h) {
            		if (e.scrollHeight > h) {
            			e.style.height = (e.scrollHeight) + "px";
            		}
            	}
            	scope.$watch('model', function(n, o) {
            		recalc(e, h);
            	});
            	recalc(e, h);
            },
            */
            template: function() {
                return '<div class="input input--textarea" ng-class="{\'input--hide-label\': i18n}"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><textarea id="{{id}}" insert-paste-listener name="{{name}}" ng-model="model" type="text" class="input__field" auto-grow placeholder="{{placeholder}}"></textarea></div></div>';
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
                return '<div class="input input--text" ng-class="{\'input--hide-label\': i18n}"><label class="input__label" for="{{id}}">{{label}}</label><div class="input__field-wrapper"><input id="{{id}}" name="{{name}}" ng-model="model" type="password" class="input__field" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });

    /**
     * options=[{"value":123,"label":123-Label}, {"value":abc,"label":ABC-Label}]
     */
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
                        if (n == undefined || n == null || n == '') {
                            if (jQuery.isNumeric(scope.initvalue)) {
                                scope.initvalue = typeCastValue(scope.initvalue);
                            }
                            scope.model = scope.initvalue;
                        }
                    })
                });
            },
            template: function() {
                return '<div class="input input--select" ng-class="{\'input--hide-label\': i18n}">' +
                            '<label class="input__label" for="{{id}}">{{label}}</label>' +
                            '<div class="input__select-wrapper">' +
                                '<select name="{{name}}" id="{{id}}" class="input__field browser-default" chosen allow-single-deselect="true" width="\'100%\'" placeholder-text-single="\'' + i18n['ngrest_select_no_selection']+ '\'" ng-options="item.value as item.label for item in options" ng-model="model"><option></option></select>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * options = {'true-value' : 1, 'false-value' : 0};
     */
    zaa.directive("zaaCheckbox", function($timeout) {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "i18n": "@i18n",
                "id": "@fieldid",
                "name": "@fieldname",
                "label": "@label",
                "initvalue": "@initvalue"
            },
            controller: function($scope) {
                if ($scope.options === null) {
                    $scope.valueTrue = 1;
                    $scope.valueFalse = 0;
                } else {
                    $scope.valueTrue = $scope.options['true-value'];
                    $scope.valueFalse = $scope.options['false-value'];
                }

                $scope.init = function() {
            		if ($scope.model == undefined && $scope.model == null) {
            			$scope.model = typeCastValue($scope.initvalue);
            		}
                };
                $timeout(function() {
                	$scope.init();
            	})
            },
            template: function() {
                return '<div class="input input--single-checkbox">' +
                            '<input id="{{id}}" name="{{name}}" ng-true-value="{{valueTrue}}" ng-false-value="{{valueFalse}}" ng-model="model" type="checkbox" />' +
                            '<label for="{{id}}" class="input__label">{{label}}</label>' +
                        '</div>';
            }
        }
    });

    /**
     * options arg object:
     *
     * options.items[] = [{"value" : 1, "label" => 'Label for Value 1' }]
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
            controller: function($scope, $filter) {

                if ($scope.model == undefined) {
                    $scope.model = [];
                }

                $scope.searchString = '';

                $scope.$watch('options', function(n, o) {
                	if (n != undefined && n.hasOwnProperty('items')) {
                    	$scope.optionitems = $filter('orderBy')(n.items, 'label');
                    }
                });

                $scope.filtering = function() {
                    $scope.optionitems = $filter('filter')($scope.options.items, $scope.searchString);
                }

                $scope.toggleSelection = function (value) {
                	if ($scope.model == undefined) {
                		$scope.model = [];
                	}

                    for (var i in $scope.model) {
                        if ($scope.model[i]["value"] == value.value) {
                            $scope.model.splice(i, 1);
                            return;
                        }
                    }
                    $scope.model.push({'value': value.value});
                }

                $scope.isChecked = function(item) {
                    for (var i in $scope.model) {
                        if ($scope.model[i]["value"] == item.value) {
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
                return '<div class="input input--multiple-checkboxes"  ng-class="{\'input--hide-label\': i18n}">' +
                            '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<input class="input__searchfield" type="text" ng-change="filtering()" ng-model="searchString" placeholder="Suchen" /> {{optionitems.length}} ' + i18n['js_dir_till'] + '{{options.items.length}}'+
                                '<div ng-repeat="(k, item) in optionitems track by k">' +
                                    '<input type="checkbox" ng-checked="isChecked(item)" id="{{random}}_{{k}}" ng-click="toggleSelection(item)" />' +
                                    '<label for="{{random}}_{{k}}">{{item.label}}</label>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * https://github.com/720kb/angular-datepicker#date-validation - Date Picker
     * http://jsfiddle.net/bateast/Q6py9/1/ - Date Parse
     * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date - Date Objects
     * https://docs.angularjs.org/api/ng/filter/date - Angular Date Filter
     */
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
            controller: function($scope, $filter) {

            	$scope.isNumeric = function(num) {
            	    return !isNaN(num)
            	}
            	
            	$scope.$watch(function() { return $scope.model }, function(n, o) {
            		if (n != null && n != undefined) {
            			var datep = new Date(n*1000);
            			$scope.pickerPreselect = datep;
            			$scope.date = $filter('date')(datep, 'dd.MM.yyyy');
            			$scope.hour = $filter('date')(datep, 'H');
            			$scope.min = $filter('date')(datep, 'm');
            		} else {
            			$scope.date = null;
            			$scope.model = null;
            		}
            	});

            	$scope.refactor = function(n) {
            		if (!$scope.isNumeric($scope.hour) || $scope.hour == '') {
						$scope.hour = "0";
					}
					
					if (!$scope.isNumeric($scope.min)  || $scope.min == '') {
						$scope.min = "0";
					}
            		
            		if (n == 'Invalid Date' || n == "" || n == 'NaN') {
        				$scope.date = null;
        				$scope.model = null;
        			} else {
            			var res = n.split(".");
            			if (res.length == 3) {
            				if (res[2].length == 4) {

        						if (parseInt($scope.hour) > 23) {
        							$scope.hour = 23;
        						}

        						if (parseInt($scope.min) > 59) {
        							$scope.min = 59;
        						}

		        				var en = res[1] + "/" + res[0] + "/" + res[2] + " " + $scope.hour + ":" + $scope.min;
		        				$scope.model = (Date.parse(en)/1000);
		        				$scope.datePickerToggler = false;
            				}
            			}
        			}
            	}

            	$scope.$watch(function() { return $scope.date }, function(n, o) {
            		if (n != o && n != undefined && n != null) {
            			$scope.refactor(n);
            		}
            	});

            	$scope.autoRefactor = function() {
            		$scope.refactor($scope.date);
            	}

            	$scope.datePickerToggler = false;

            	$scope.toggleDatePicker = function() {
            		$scope.datePickerToggler = !$scope.datePickerToggler;
            	}


            	$scope.hour = "0";

            	$scope.min = "0";

            },
            template: function() {
            	return '<div class="input input--date" ng-class="{\'input--hide-label\': i18n, \'input--with-time\': model!=null && date!=null}"><label class="input__label">{{label}}</label><div class="input__field-wrapper"><datepicker date-set="{{pickerPreselect.toString()}}" datepicker-toggle="false" datepicker-show="{{datePickerToggler}}" date-format="dd.MM.yyyy"><input ng-model="date" type="text" class="input__field" /><span class="btn btn-floating date-picker-icon" ng-class="{\'red\': datePickerToggler}" ng-click="toggleDatePicker()"><i class="material-icons" ng-hide="datePickerToggler">date_range</i><i class="material-icons" style="margin-top: 1px;" ng-show="datePickerToggler">close</i></span></datepicker>'+
            	'<div ng-show="model!=null && date!=null" class="hour-selection"><span class="hour-selection__icon"><i class="material-icons">access_time</i></span><input type="text" ng-model="hour" ng-change="autoRefactor()" class="input__field input__field--hour" /><span class="time-divider">:</span><input type="text" ng-model="min" ng-change="autoRefactor()" class="input__field input__field--minute" /></div>'
            	'</div></div></div>';
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
        	controller: function($scope, $filter) {

            	$scope.$watch(function() { return $scope.model }, function(n, o) {
            		
            		if (n != null && n != undefined) {
            			var datep = new Date(n*1000);
            			$scope.pickerPreselect = datep;
            			$scope.date = $filter('date')(datep, 'dd.MM.yyyy');
            		} else {
            			$scope.date = null;
            			$scope.model = null;
            		}
            	});

            	$scope.refactor = function(n) {
            		if (n == 'Invalid Date' || n == "") {
        				$scope.date = null;
        				$scope.model = null;
        			} else {
            			var res = n.split(".");
            			if (res.length == 3) {
            				if (res[2].length == 4) {
            					var en = res[1] + "/" + res[0] + "/" + res[2];
		        				$scope.model = (Date.parse(en)/1000);
		        				$scope.datePickerToggler = false;
            				}
            			}
        			}
            	}

            	$scope.$watch(function() { return $scope.date }, function(n, o) {
            		if (n != o && n != undefined && n != null) {
            			$scope.refactor(n);
            		}
            	});

            	$scope.autoRefactor = function() {
            		$scope.refactor($scope.date);
            	}

            	$scope.datePickerToggler = false;

            	$scope.toggleDatePicker = function() {
            		$scope.datePickerToggler = !$scope.datePickerToggler;
            	}

            },
            template: function() {
            	return '<div class="input input--date"  ng-class="{\'input--hide-label\': i18n}"><label class="input__label">{{label}}</label><div class="input__field-wrapper"><datepicker date-set="{{pickerPreselect.toString()}}" datepicker-toggle="false" datepicker-show="{{datePickerToggler}}" date-format="dd.MM.yyyy"><input ng-model="date" type="text" class="input__field" /><span class="btn btn-floating date-picker-icon" ng-class="{\'red\': datePickerToggler}" ng-click="toggleDatePicker()"><i class="material-icons" ng-hide="datePickerToggler">date_range</i><i class="material-icons" style="margin-top: 1px;" ng-show="datePickerToggler">close</i></span></datepicker></div></div></div>';
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
                    $scope.model = [{0:''}];
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

                $scope.moveLeft = function(index) {
                    index = parseInt(index);
                    for (var i in $scope.model) {
                        var oldValue = $scope.model[i][index];
                        $scope.model[i][index] = $scope.model[i][index-1];
                        $scope.model[i][index-1] = oldValue;
                    }
                }

                $scope.moveRight = function(index) {
                    index = parseInt(index);
                    for (var i in $scope.model) {
                        var oldValue = $scope.model[i][index];
                        $scope.model[i][index] = $scope.model[i][index+1];
                        $scope.model[i][index+1] = oldValue;
                    }
                }

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                }

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                }

                $scope.removeRow = function(key) {
                    $scope.model.splice(key, 1);
                }

                $scope.showRightButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model[0]).length - 1) {
                        return true;
                    }
                    return false;
                }
                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                }
            },
            template: function() {
                return '<div class="zaa-table__wrapper">'+
                            '<h5 ng-show="label">{{label}}</h5>' +
                            '<table class="zaa-table">'+
                                '<thead>'+
                                    '<tr>'+
                                        '<td width="30"></td>'+
                                        '<td data-ng-repeat="(hk, hr) in model[0] track by hk">'+
                                            '<div class="zaa-table__cell-toolbar-top">'+
                                                '<button type="button" ng-show="{{hk > 0}}" ng-click="moveLeft(hk)" class="btn zaa-table__btn zaa-table__btn--cellmove zaa-table__btn--cellmove-left" tabindex="-1"><i class="material-icons" style="transform: rotate(180deg);">play_arrow</i></button>' +
                                                '<div class="zaa-table__cell-toolbar-center">'+
                                                    '<button type="button" ng-click="removeColumn(hk)" class="btn-floating zaa-table__btn zaa-table__btn--del" data-drag="true" tabindex="-1">'+
                                                        '<i class="material-icons">delete</i>'+
                                                    '</button>'+
                                                '</div>'+
                                                '<button type="button" ng-click="moveRight(hk)" ng-show="showRightButton(hk)" class="btn zaa-table__btn zaa-table__btn--cellmove zaa-table__btn--cellmove-right" tabindex="-1"><i class="material-icons">play_arrow</i></button>' +
                                            '</div>'+
                                        '</td>'+
                                    '</tr>'+
                                '</thead>' +
                                '<tr data-ng-repeat="(key, row) in model track by key">'+
                                    '<td>'+
                                        '<button type="button" class="btn-floating zaa-table__btn zaa-table__btn--del" ng-click="removeRow(key)" tabindex="-1">'+
                                            '<i class="material-icons">delete</i>'+
                                        '</button>'+
                                        '<div class="zaa-table__cell-toolbar-side">'+
                                            '<button type="button" ng-show="{{key > 0}}" ng-click="moveUp(key)" class="btn zaa-table__btn zaa-table__btn--cellmove zaa-table__btn zaa-table__btn--cellmove-top" tabindex="-1"><i class="material-icons" style="transform: rotate(270deg);">play_arrow</i></button>' +
                                            '<button type="button" ng-show="showDownButton(key)" ng-click="moveDown(key)" class="btn zaa-table__btn zaa-table__btn--cellmove zaa-table__btn zaa-table__btn--cellmove-bottom" tabindex="-1"><i class="material-icons" style="transform: rotate(90deg);">play_arrow</i></button><br/>' +
                                        '</div>'+
                                    '</td>'+
                                    '<td data-ng-repeat="(field,value) in row track by field">'+
                                        '<textarea ng-model="model[key][field]" class="zaa-table__textarea"></textarea>'+
                                    '</td>'+
                                '</tr>'+
                            '</table>'+
                            '<button ng-click="addRow()" type="button" class="[ waves-effect waves-light ] btn btn--small">'+i18n['js_dir_table_add_row']+' <i class="material-icons right">add</i></button>'+
                            '<button ng-click="addColumn()" type="button" style="float:right;" class="[ waves-effect waves-light ] btn btn--small">'+i18n['js_dir_table_add_column']+' <i class="material-icons right">add</i></button>'+
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
                return '<div class="input input--file-upload" ng-class="{\'input--hide-label\': i18n}">' +
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
                return '<div class="input input--image-upload" ng-class="{\'input--hide-label\': i18n}">' +
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
                	if ($scope.model == null || $scope.model == '' || $scope.model == undefined) {
                		$scope.model = [];
                	}
                    $scope.model.push({ imageId : 0, caption : '' });
                };

                $scope.remove = function(key) {
                    $scope.model.splice(key, 1);
                };

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                };

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                };

                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                };
            },
            template: function() {
                return '<div class="input input--image-array imagearray" ng-class="{\'input--hide-label\': i18n}">' +
                            '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<p class="list__no-entry" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                '<div ng-repeat="(key,image) in model track by key" class="row list__item">' +

                                    '<div class="list__left row">' +
                                        '<div class="col s8">' +
                                            '<storage-image-upload ng-model="image.imageId" options="options"></storage-image-upload>' +
                                        '</div>' +
                                        '<div class="input-field col s4">' +
                                            '<textarea ng-model="image.caption" class="materialize-textarea"></textarea>' +
                                            '<label>'+i18n['js_dir_image_description']+'</label>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="list__right">' +
                                    '<button type="button" class="btn-floating list__button [ red lighten-1 ]" ng-click="remove(key)" tabindex="-1"><i class="material-icons">remove</i></button>' +
                                    '<button type="button" class="btn-floating list__button [ blue lighten-1 ]" ng-click="moveUp(key)" ng-show="{{key > 0}}"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                    '<button type="button" class="btn-floating list__button [ blue lighten-1 ]" ng-click="moveDown(key)" ng-show="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                    '</div>' +
                                '</div>' +
                                '<button ng-click="add()" type="button" class="btn-floating left list__add-button [ waves-effect waves-circle waves-light ]"><i class="material-icons">add</i></button>' +
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
                	if ($scope.model == null || $scope.model == '' || $scope.model == undefined) {
                		$scope.model = [];
                	}
                    $scope.model.push({ fileId : 0, caption : '' });
                };

                $scope.remove = function(key) {
                    $scope.model.splice(key, 1);
                };

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                };

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                };

                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                };
            },
            template: function() {
                return '<div class="input input--file-array filearray" ng-class="{\'input--hide-label\': i18n}">' +
                            '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<p class="list__no-entry" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                '<div ng-repeat="(key,file) in model track by key" class="row list__item">' +
                                    '<div class="list__left row">' +
                                        '<div class="filearray__upload col s8">' +
                                            '<storage-file-upload ng-model="file.fileId"></storage-file-upload>' +
                                        '</div>' +
                                        '<div class="input-field col s4">' +
                                            '<input type="text" ng-model="file.caption" class="filearray__description-input" />' +
                                            '<label>'+i18n['js_dir_image_description']+'</label>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="list__right">' +
                                        '<button type="button" class="btn-floating list__button [ red lighten-1 ]" ng-click="remove(key)" tabindex="-1"><i class="material-icons">remove</i></button>' +
                                        '<button type="button" class="btn-floating list__button [ blue lighten-1 ]" ng-click="moveUp(key)" ng-show="{{key > 0}}"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                        '<button type="button" class="btn-floating list__button [ blue lighten-1 ]" ng-click="moveDown(key)" ng-show="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                    '</div>' +
                                '</div>' +
                                '<button ng-click="add()" type="button" class="btn-floating left list__add-button [ waves-effect waves-circle waves-light ]"><i class="material-icons">add</i></button>' +
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

                $scope.init = function() {
                	if ($scope.model == undefined || $scope.model == null) {
                        $scope.model = [];
                    }
                };

                $scope.add = function() {
                	if ($scope.model == null || $scope.model == '' || $scope.model == undefined) {
                		$scope.model = [];
                	}
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

                $scope.moveUp = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index-1];
                    $scope.model[index-1] = oldRow;
                }

                $scope.moveDown = function(index) {
                    index = parseInt(index);
                    var oldRow = $scope.model[index];
                    $scope.model[index] = $scope.model[index+1];
                    $scope.model[index+1] = oldRow;
                }

                $scope.showDownButton = function(index) {
                    if (parseInt(index) < Object.keys($scope.model).length - 1) {
                        return true;
                    }
                    return false;
                }

                $scope.init();

            },
            template: function() {
                return '<div class="input input--list list" ng-class="{\'input--hide-label\': i18n}">' +
                            '<label class="input__label">{{label}}</label>' +
                            '<div class="input__field-wrapper">' +
                                '<p class="list__no-entry" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                '<div ng-repeat="(key,row) in model track by key" class="list__item">' +
                                    '<div class="list__left" style="width:calc(100% - 140px)">' +
                                        '<input class="list__input" type="text" ng-model="row.value" />' +
                                    '</div>' +
                                    '<div class="list__right" style="width:130px">' +
                                        '<button type="button" class="btn-floating list__button [ red lighten-1 ]" ng-click="remove(key)" tabindex="-1"><i class="material-icons">remove</i></button>' +
                                        '<button type="button" class="btn-floating list__button [ blue lighten-1 ]" ng-show="{{key > 0}}" ng-click="moveUp(key)"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                        '<button type="button" class="btn-floating list__button [ blue lighten-1 ]" ng-show="showDownButton(key)" ng-click="moveDown(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                    '</div>' +
                                '</div>' +
                                '<button ng-click="add()" type="button" class="btn-floating left list__add-button [ waves-effect waves-circle waves-light ]"><i class="material-icons">add</i></button>' +
                            '</div>' +
                        '</div>';
            }
        }
    });
    // storage.js

    zaa.directive('storageFileUpload', function($http, ServiceFilesData, $filter) {
        return {
            restrict : 'E',
            scope : {
                ngModel : '='
            },
            link : function(scope) {

                // ServiceFilesData inhertiance

                scope.filesData = ServiceFilesData.data;

                scope.$on('service:FilesData', function(event, data) {
                    scope.filesData = data;
                });

                // controller logic

                scope.modal = true;
                scope.fileinfo = null;

                scope.select = function(fileId) {
                    scope.toggleModal();
                    scope.ngModel = fileId;
                }

                scope.reset = function() {
                	scope.ngModel = 0;
                	scope.fileinfo = null;
                }

                scope.toggleModal = function() {
                    scope.modal = !scope.modal;
                }

                scope.$watch(function() { return scope.ngModel }, function(n, o) {
                    if (n != 0 && n != null && n !== undefined) {
                        var filtering = $filter('filter')(scope.filesData, {id: n});
                        if (filtering && filtering.length == 1) {
                            scope.fileinfo = filtering[0];
                        }
                    }

                    /* reset file directive if an event resets the image model to undefined */
                    if (n == 0) {
                    	scope.reset();
                    }
                });
            },
            templateUrl : 'storageFileUpload'
        }
    });

    zaa.directive('storageFileDisplay', function(ServiceFilesData) {
    	return {
    		restrict: 'E',
    		scope: {
    			fileId: '@fileId'
    		},
    		controller: function($scope, $filter) {

    			// ServiceFilesData inheritance

                $scope.filesData = ServiceFilesData.data;

                $scope.$on('service:FilesData', function(event, data) {
                    $scope.filesData = data;
                });

                // controller

                $scope.fileinfo = null;

                $scope.$watch('fileId', function(n, o) {
                    if (n != 0 && n != null && n !== undefined) {
                    	var filtering = $filter('filter')($scope.filesData, {id: n});
                        if (filtering && filtering.length == 1) {
                        	$scope.fileinfo = filtering[0];
                        }
                    }
                });
    		},
    		template: function() {
                return '<div ng-show="fileinfo!==null">{{ fileinfo.name }}</div>';
            }
    	}
    });

    zaa.directive('storageImageThumbnailDisplay', function(ServiceImagesData, ServiceFilesData) {
        return {
            restrict: 'E',
            scope: {
                imageId: '@imageId'
            },
            controller: function($scope, $filter) {

                // ServiceFilesData inheritance

                $scope.filesData = ServiceFilesData.data;

                $scope.$on('service:FilesData', function(event, data) {
                    $scope.filesData = data;
                });

                // ServiceImagesData inheritance

                $scope.imagesData = ServiceImagesData.data;

                $scope.$on('service:ImagesData', function(event, data) {
                    $scope.imagesData = data;
                });

                // controller logic

                $scope.$watch(function() { return $scope.imageId }, function(n, o) {
                    if (n != 0 && n !== undefined) {

                        var filtering = $filter('findidfilter')($scope.imagesData, n, true);

                        var file = $filter('findidfilter')($scope.filesData, filtering.fileId, true);

                        if (file && file.thumbnail) {
                        	$scope.imageSrc = file.thumbnail.source;
                        }
                    }
                });

                $scope.imageSrc = null;
            },
            template: function() {
                return '<div ng-show="imageSrc!==false"><img ng-src="{{imageSrc}}" /></div>';
            }
        }
    });

    zaa.directive('storageImageUpload', function($http, $filter, ServiceFiltersData, ServiceImagesData, AdminToastService) {
        return {
            restrict : 'E',
            scope : {
                ngModel : '=',
                options : '=',
            },
            link : function(scope) {

                // ServiceImagesData inheritance

                scope.imagesData = ServiceImagesData.data;

                scope.$on('service:ImagesData', function(event, data) {
                    scope.imagesData = data;
                });

                scope.imagesDataReload = function() {
                    return ServiceImagesData.load(true);
                }

                // ServiceFiltesrData inheritance

                scope.filtersData = ServiceFiltersData.data;

                scope.$on('service:FiltersData', function(event, data) {
                    scope.filtersData = data;
                });

                // controller logic

                scope.noFilters = function() {
                    if (scope.options) {
                        return scope.options.no_filter;
                    }
                }

                scope.thumbnailfilter = null;

                scope.imageLoading = false;

                scope.fileId = 0;

                scope.filterId = 0;

                scope.imageinfo = null;

                scope.imageNotFoundError = false;

                scope.filterApply = function() {
                    var items = $filter('filter')(scope.imagesData, {fileId: scope.fileId, filterId: scope.filterId}, true);
                    if (items && items.length == 0) {
                        scope.imageLoading = true;
                        // image does not exists make request.
                        $http.post('admin/api-admin-storage/image-upload', $.param({ fileId : scope.fileId, filterId : scope.filterId }), {
                            headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                        }).success(function(success) {
                            if (!success.error) {
                                scope.imagesDataReload().then(function(r) {
                                    scope.ngModel = success.id;
                                    AdminToastService.success(i18n['js_dir_image_upload_ok'], 2000);
                                    scope.imageLoading = false;
                                });
                            }
                        }).error(function(error) {
                        	AdminToastService.error(i18n['js_dir_image_filter_error'], 7000);
                            scope.imageLoading = false;
                        });
                    } else {
                        var item = items[0];
                        scope.ngModel = item.id
                        scope.imageinfo = item;
                    }
                };

                scope.$watch(function() { return scope.filterId }, function(n, o) {
                    if (n != null && n !== undefined && scope.fileId !== 0 && n !== o && n != o) {
                        scope.filterApply();
                    }
                });

                scope.$watch(function() { return scope.fileId }, function(n, o) {
                	if (n !== undefined && n != null && n != o) {
                		if (n == 0) {
                            scope.filterId = 0;
                            scope.imageinfo = null;
                            scope.ngModel = 0;
                        } else {
                        	scope.filterApply();
                        }
                    }
                });

                scope.$watch(function() { return scope.ngModel }, function(n, o) {
                    if (n != 0 && n != null && n !== undefined) {
                        var filtering = $filter('findidfilter')(scope.imagesData, n, true);
                        if (filtering) {
                            scope.imageinfo = filtering;
                            scope.filterId = filtering.filterId;
                            scope.fileId = filtering.fileId;
                        } else {
                        	scope.imageNotFoundError = true;
                        }
                    }
                    /* reset image preview directive if an event resets the image model to undefined */
                    if (n == undefined || n == 0) {
                    	scope.fileId = 0;
                        scope.filterId = 0;
                        scope.imageinfo = null;
                        scope.thumb = false;
                    }

                });

                scope.thumb = false;

                scope.getThumbnailFilter = function() {
                	if (scope.thumbnailfilter === null) {
                		if ('medium-thumbnail' in scope.filtersData) {
                			scope.thumbnailfilter = scope.filtersData['medium-thumbnail'];
                		}
                	}
                	return scope.thumbnailfilter;
                }

                scope.$watch('imageinfo', function(n, o) {
                	if (n != 0 && n != null && n !== undefined) {
                		if (n.filterId != 0) {
                			scope.thumb = n;
                		} else {
                			var result = $filter('findthumbnail')(scope.imagesData, n.fileId, scope.getThumbnailFilter().id);
                			if (!result) {
                				scope.thumb = n;
                			} else {
                				scope.thumb = result;
                			}
                		}
                	}
                })
            },
            templateUrl : 'storageImageUpload'
        }
    });

    zaa.filter("filemanagerdirsfilter", function() {
        return function(input, parentFolderId) {
            var result = [];
            angular.forEach(input, function(value, key) {
                if (value.parentId == parentFolderId) {
                    result.push(value);
                }
            });

            return result;
        };
    });

    zaa.filter("findthumbnail", function() {
    	return function(input, fileId, thumbnailFilterId) {
    		var result = false;
    		angular.forEach(input, function(value, key) {
    			if (!result) {
	    			if (value.fileId == fileId && value.filterId == thumbnailFilterId) {
	    				result = value;
	    			}
    			}
    		})

    		return result;
    	}
    });

    zaa.filter("findidfilter", function() {
        return function(input, id) {

            var result = false;

            angular.forEach(input, function(value, key) {
                if (value.id == id) {
                    result = value;
                }
            });

            return result;
        }
    });

    zaa.filter("filemanagerfilesfilter", function() {
        return function(input, folderId, onlyImages) {

            var result = [];

            angular.forEach(input, function(data) {
                if (onlyImages) {
                    if (data.folderId == folderId && data.isImage == true) {
                        result.push(data);
                    }
                } else {
                    if (data.folderId == folderId) {
                        result.push(data);
                    }
                }
            });

            return result;
        };
    });

    /**
     * FILE MANAGER DIR
     */
    zaa.directive("storageFileManager", function(Upload, ServiceFoldersData, ServiceFilesData, LuyaLoading, AdminToastService, ServiceFoldersDirecotryId) {
        return {
            restrict : 'E',
            transclude : false,
            scope : {
                allowSelection : '@selection',
                onlyImages : '@onlyImages'
            },
            controller : function($scope, $http, $filter, $timeout) {

                // ServiceFoldersData inheritance

                $scope.foldersData = ServiceFoldersData.data;

                $scope.$on('service:FoldersData', function(event, data) {
                    $scope.foldersData = data;
                });

                $scope.foldersDataReload = function() {
                    return ServiceFoldersData.load(true);
                }

                // ServiceFilesData inheritance

                $scope.filesData = ServiceFilesData.data;

                $scope.$on('service:FilesData', function(event, data) {
                    $scope.filesData = data;
                });

                $scope.filesDataReload = function() {
                    return ServiceFilesData.load(true);
                }

                // ServiceFolderId

                $scope.currentFolderId = ServiceFoldersDirecotryId.folderId;

                $scope.$on('FoldersDirectoryId', function(event, folderId) {
                	$scope.currentFolderId = folderId;
                });

                $scope.foldersDirecotryIdReload = function() {
                	return ServiceFoldersDirecotryId.load(true);
                }

                // upload logic

                $scope.$watch('uploadingfiles', function (uploadingfiles) {
                    if (uploadingfiles != null) {
                        $scope.uploadResults = 0;
                        LuyaLoading.start(i18n['js_dir_upload_wait']);
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
                            $scope.filesDataReload().then(function() {
                            	AdminToastService.success(i18n['js_dir_manager_upload_image_ok'], 2000);
                                LuyaLoading.stop();
                            });
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

                // selector logic

                $scope.selectedFiles = [];

                $scope.toggleSelectionAll = function() {
                	var files = $filter('filemanagerfilesfilter')($scope.filesData, $scope.currentFolderId, $scope.onlyImages);
                	files.forEach(function(value, key) {
                		$scope.toggleSelection(value);
                	})
                }

                $scope.toggleSelection = function(file) {
                    if ($scope.allowSelection == 'true') {
                        // parent inject
                        $scope.$parent.select(file.id);
                        return;
                    }

                    var i = $scope.selectedFiles.indexOf(file.id);
                    if (i > -1) {
                        $scope.selectedFiles.splice(i, 1);
                    } else {
                        $scope.selectedFiles.push(file.id);
                    }
                };

                $scope.inSelection = function(file) {
                    var response = $scope.selectedFiles.indexOf(file.id);

                    if (response != -1) {
                        return true;
                    }

                    return false;
                };

                // folder add

                $scope.showFolderForm = false;

                $scope.createNewFolder = function(newFolderName) {
                    $http.post('admin/api-admin-storage/folder-create', $.param({ folderName : newFolderName , parentFolderId : $scope.currentFolderId }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).success(function(transport) {
                        $scope.foldersDataReload().then(function() {
                            $scope.folderFormToggler();
                        })
                    });
                };

                $scope.folderFormToggler = function() {
                    $scope.showFolderForm = !$scope.showFolderForm;
                };

                // controller logic

                $scope.searchQuery = '';

                $scope.sortField = 'name';

                $scope.changeSortField = function(name) {
                	$scope.sortField = name;
                }

                $scope.changeCurrentFolderId = function(folderId) {
                    $scope.currentFolderId = folderId;
                    ServiceFoldersDirecotryId.folderId = folderId;
                    $http.post('admin/api-admin-common/save-filemanager-folder-state', {folderId : folderId});
                };

                $scope.toggleFolderItem = function(data) {
                    if (data.toggle_open == undefined) {
                        data['toggle_open'] = 1;
                    } else {
                        data['toggle_open'] = !data.toggle_open;
                    }
                    $http.post('admin/api-admin-common/filemanager-foldertree-history', {data : data});
                };

                $scope.folderUpdateForm = false;

                $scope.folderDeleteForm = false;

                $scope.folderDeleteConfirmForm = false;

                $scope.toggleFolderMode = function(mode) {
                    if (mode == 'edit') {
                        $scope.folderUpdateForm = true;
                        $scope.folderDeleteForm = false;
                        $scope.folderDeleteConfirmForm = false;
                    } else if (mode == 'remove') {
                        $scope.folderUpdateForm = false;
                        $scope.folderDeleteForm = true;
                        $scope.folderDeleteConfirmForm = false;
                    } else if (mode == 'removeconfirm') {
                        $scope.folderUpdateForm = false;
                        $scope.folderDeleteForm = false;
                        $scope.folderDeleteConfirmForm = true;
                    } else {
                        $scope.folderUpdateForm = false;
                        $scope.folderDeleteForm = false;
                        $scope.folderDeleteConfirmForm = false;
                    }
                };

                $scope.updateFolder = function(folder) {
                    $http.post('admin/api-admin-storage/folder-update?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).success(function(transport) {
                        $scope.toggleFolderMode(false);
                    });
                }

                $scope.checkEmptyFolder = function(folder) {
                    $http.post('admin/api-admin-storage/is-folder-empty?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).success(function(transport) {
                        if (transport == true) {
                            $scope.deleteFolder(folder);
                        } else {
                            $scope.toggleFolderMode('removeconfirm');
                        }
                        /*
                        if (transport == false) {
                            // not empty
                            folder.remove = false;
                            folder.notempty = true;
                        } else {
                            // empty
                            $scope.deleteFolder(folder);
                        }
                        */
                    });
                };

                $scope.deleteFolder = function(folder) {
                    // check if folder is empty
                    $http.post('admin/api-admin-storage/folder-delete?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).success(function(transport) {
                        $scope.foldersDataReload().then(function() {
                            $scope.filesDataReload().then(function() {
                                $scope.toggleFolderMode(false);
                                $scope.currentFolderId = 0;
                            });
                        });
                    });
                };

                $scope.fileDetail = false;

                $scope.showFoldersToMove = false;

                $scope.openFileDetail = function(file) {
                    $scope.fileDetail = file;
                };

                $scope.closeFileDetail = function() {
                    $scope.fileDetail = false;
                };

                $scope.moveFilesTo = function(folderId) {
                    $http.post('admin/api-admin-storage/filemanager-move-files', $.param({'fileIds' : $scope.selectedFiles, 'toFolderId' : folderId}), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).success(function(transport) {
                        $scope.filesDataReload().then(function() {
                            $scope.selectedFiles = [];
                            $scope.showFoldersToMove = false;
                        });
                    });
                };

                $scope.removeFiles = function() {
                    AdminToastService.confirm(i18n['js_dir_manager_rm_file_confirm'], function($timeout, $toast) {
                        $http.post('admin/api-admin-storage/filemanager-remove-files', $.param({'ids' : $scope.selectedFiles}), {
                            headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                        }).success(function(transport) {
                            $scope.filesDataReload().then(function() {
                                $toast.close();
                                AdminToastService.success(i18n['js_dir_manager_rm_file_ok'], 2000);
                                $scope.selectedFiles = [];
                            });
                        });
                    });
                }

                // file detail view logic

                $scope.storeFileCaption = function(fileDetail) {
                	$http.post('admin/api-admin-storage/filemanager-update-caption', $.param({'id': fileDetail.id, 'captionsText' : fileDetail.captionArray}), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).success(function(transport) {
                    	AdminToastService.success('Captions has been updated', 2000);
                    });
                }

            },
            templateUrl : 'storageFileManager'
        }
    });

})();
