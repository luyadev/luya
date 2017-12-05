(function() {
    "use strict";

    /* GLOBAL DIRECTIVES */
    
    /**
     * Controller: $scope.content = $sce.trustAsHtml(response.data);
     * Template: <div compile-html ng-bind-html="content | trustAsUnsafe"></div>
     */
    zaa.directive("compileHtml", function ($compile, $parse) {
        return {
            restrict: "A",
            link: function (scope, element, attr) {
                var parsed = $parse(attr.ngBindHtml);
                scope.$watch(function () {
                    return (parsed(scope) || "").toString();
                }, function () {
                    $compile(element, null, -9999)(scope);  //The -9999 makes it skip directives so that we do not recompile ourselves
                });
            }
        };
    });

    /**
     * Usage:
     *
     * ```
     * <div zaa-esc="methodClosesThisDiv()" />
     * ```
     */
    zaa.directive("zaaEsc", function () {
        return function (scope, element, attrs) {
            $(document).on("keyup", function (e) {
                if (e.keyCode == 27) {
                    scope.$apply(function () {
                        scope.$eval(attrs.zaaEsc);
                    });
                }
            });
        };
    });

    zaa.directive("linkObjectToString", function () {
        return {
            restrict: 'E',
            relace: true,
            scope: {
                'link': '='
            },
            template: function () {
                return '<span>' +
                	'<span ng-if="link.type==1"><show-internal-redirection nav-id="link.value" /></span>' +
                	'<span ng-if="link.type==2">{{link.value}}</span>' +
                    '<span ng-if="link.type==3"><storage-file-display file-id="{{link.value}}"></storage-file-display></span>' +
                    '<span ng-if="link.type==4">{{link.value}}</span>' +
                '</span>';
            }
        }
    });

    /**
     * Generate a Tool Tip – usage:
     *
     * The default tooltip is positioned on the right side of the element:
     *
     * ```html
     * <span tooltip tooltip-text="Tooltip">...</span>
     * ```
     *
     *
     * You can provide an Image URL beside or instead of text.
     *
     * ```html
     * <span tooltip tooltip-image-url="http://image.url">...</span>
     * ```
     *
     * Change the position (`top`, `right`, `bottom` or `left`):
     *
     * ```html
     * <span tooltip tooltip-text="Tooltip" tooltip-position="top">...</span>
     * ```
     *
     *
     * Add an offset to the generated position. The example below adds 5px offset from left and pulls the tooltip 5px up.
     *
     * ```html
     * <span tooltip tooltip-text="Tooltip" tooltip-offset-left="5" tooltip-offset-top="-5">...</span>
     * ```
     *
     *
     * In order to trigger an expression call instead of a static text use:
     *
     * ```html
     * <span tooltip tooltip-expression="scopeFunction(fooBar)">Span Text</span>
     * ```
     *
     *
     * Disable tooltip based on variable (two way binding):
     *
     * ```html
     * <span tooltip tooltip-text="Tooltip" tooltip-disabled="variableMightBeTrueMightBeFalseMightChange">Span Text</span>
     * ```
     */
    zaa.directive("tooltip", function ($document) {
        return {
            restrict: 'A',
            scope: {
                'tooltipText': '@',
                'tooltipExpression': '=',
                'tooltipPosition': '@',
                'tooltipOffsetTop': '@',
                'tooltipOffsetLeft': '@',
                'tooltipImageUrl': '@',
                'tooltipDisabled': '='
            },
            link: function (scope, element, attr) {
                var defaultPosition = 'right';

                var positions = {
                    top: function() {
                        var bcr = element[0].getBoundingClientRect();
                        return {
                            top: bcr.top - scope.pop.outerHeight(),
                            left: (bcr.left + (bcr.width / 2)) - (scope.pop.outerWidth() / 2),
                        }
                    },
                    bottom: function() {
                        var bcr = element[0].getBoundingClientRect();
                        return {
                            top: bcr.top + bcr.height,
                            left: (bcr.left + (bcr.width / 2)) - (scope.pop.outerWidth() / 2),
                        }
                    },
                    right: function() {
                        var bcr = element[0].getBoundingClientRect();
                        return {
                            top: (bcr.top + (bcr.height / 2)) - (scope.pop.outerHeight() / 2),
                            left: bcr.left + bcr.width
                        }
                    },
                    left: function() {
                        var bcr = element[0].getBoundingClientRect();
                        return {
                            top: (bcr.top + (bcr.height / 2)) - (scope.pop.outerHeight() / 2),
                            left: bcr.left - scope.pop.outerWidth()
                        }
                    }
                };

                var onScroll = function() {
                    var offset = {};
                    if(typeof positions[scope.tooltipPosition] === 'function') {
                        offset = positions[scope.tooltipPosition]();
                    } else {
                        offset = positions[defaultPosition]();
                    }

                    if (typeof scope.tooltipOffsetTop == 'number') {
                        offset.top = offset.top + scope.tooltipOffsetTop;
                    }

                    if (typeof scope.tooltipOffsetLeft == 'number') {
                        offset.left = offset.left + scope.tooltipOffsetLeft;
                    }

                    scope.pop.css(offset);
                };

                element.on('mouseenter', function () {

                    // Generate tooltip HTML for the first time
                    if(!scope.pop && (typeof scope.tooltipDisabled === 'undefined' || scope.tooltipDisabled === false)) {
                        if (scope.tooltipExpression) {
                            scope.tooltipText = scope.tooltipExpression;
                        }

                        var html =  '<div class="tooltip tooltip-' + (scope.tooltipPosition || defaultPosition) + (scope.tooltipImageUrl ? ' tooltip-image' : '') + '" role="tooltip">' +
                                        '<div class="tooltip-arrow"></div>' +
                                        '<div class="tooltip-inner">' +
                                        (scope.tooltipText ? ('<span class="tooltip-text">' + scope.tooltipText +  '</span>') : '') +
                                        '</div>' +
                                    '</div>';

                        var $html = $(html);

                        if(scope.tooltipImageUrl) {
                            var image = new Image();
                            image.onload = function() {
                                onScroll();
                            };
                            image.src = scope.tooltipImageUrl;
                            $html.find('.tooltip-inner').append(image);
                        }

                        scope.pop = $html;

                        $document.find('body').append(scope.pop);
                        scope.pop.hide();
                    }

                    // If tooltip shall be display...
                    if(scope.pop && (typeof scope.tooltipDisabled === 'undefined' || scope.tooltipDisabled === false)) {

                        // ..check position
                        onScroll();

                        // todo: Improve performance ...? x)
                        // ..register scroll listener
                        element.parents().on('scroll', onScroll);

                        // ..show popup
                        scope.pop.show();
                    }
                });

                element.on('mouseleave', function () {
                    element.parents().off('scroll', onScroll);

                    if(scope.pop) {
                        scope.pop.hide();
                    }
                });

                scope.$on('$destroy', function() {
                    if(scope.pop) {
                        scope.pop.remove();
                    }
                });
            }
        }
    });

    /**
     * Convert a string to number value, usefull in selects.
     *
     * ```
     * <select name="filterId" ng-model="filterId" convert-to-number>
     * ```
     */
    zaa.directive('convertToNumber', function () {
        return {
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                ngModel.$parsers.push(function (val) {
                    return val != null ? parseInt(val, 10) : null;
                });
                ngModel.$formatters.push(function (val) {
                    return val != null ? '' + val : null;
                });
            }
        };
    });

    /**
     * Directive to trigger fixed table head
     */
    zaa.directive("fixedTableHead", function ($window) {
        return function (scope, element, attrs) {
            /**
             * Calculate the offset of the "thead" and apply it as transform
             */
            var onScroll = function () {
                var table = angular.element(element.find('table'));
                var thead = angular.element(table.find('thead'));

                if (table.length > 0 && thead.length > 0) {
                    thead.css('background-color', '#fff');

                    var tableOffset = table.offset().top - $('.navbar-fixed').height();

                    if (tableOffset <= 0) {
                        thead.css('transform', 'translateY(' + (-1 - tableOffset) + 'px)');
                        thead.css('box-shadow', '0 2px 2px 0 rgba(0, 0, 0, 0.05), 0 1px 5px 0 rgba(0, 0, 0, 0.04), 0 3px 1px -2px rgba(0, 0, 0, 0.1)');
                    } else {
                        thead.css('transform', 'none');
                        thead.css('box-shadow', 'none');
                    }
                }
            };

            onScroll();

            angular.element(element).bind("scroll", function () {
                onScroll();
            });
        };
    });

    /**
     * Apply auto generated height for textareas based on input values
     */
    zaa.directive('autoGrow', function () {
        return function (scope, element, attr) {
            var $shadow = null;

            var destroy = function () {
                if ($shadow != null) {
                    $shadow.remove();
                    $shadow = null;
                }
            };

            var update = function () {
                if ($shadow == null) {
                    $shadow = angular.element('<div></div>').css({
                        position: 'absolute',
                        top: -10000,
                        left: -10000,
                        resize: 'none'
                    });

                    angular.element(document.body).append($shadow);
                }

                $shadow.css({
                    fontSize: element.css('font-size'),
                    fontFamily: element.css('font-family'),
                    lineHeight: element.css('line-height'),
                    width: element.width(),
                    paddingTop: element.css('padding-top'),
                    paddingBottom: element.css('padding-bottom')
                });

                var times = function (string, number) {
                    for (var i = 0, r = ''; i < number; i++) {
                        r += string;
                    }
                    return r;
                };

                var val = element.val().replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/&/g, '&amp;')
                    .replace(/\n$/, '<br/>&nbsp;')
                    .replace(/\n/g, '<br/>')
                    .replace(/\s{2,}/g, function (space) {
                        return times('&nbsp;', space.length - 1) + ' '
                    });

                $shadow.html(val);

                element.css('height', $shadow.outerHeight() + 10 + 'px');
            };

            element.bind('keyup keydown keypress change click', update);
            element.bind('blur', destroy);
            update();
        }
    });

    zaa.directive('resizer', function ($document) {

        return {
            scope: {
                trigger: '@'
            },
            link: function ($scope, $element, $attrs) {

                $scope.$watch('trigger', function (n, o) {
                    if (n == 0) {
                        $($attrs.resizerLeft).removeAttr('style');
                        $($attrs.resizerRight).removeAttr('style');
                    }
                })

                $element.on('mousedown', function (event) {
                    event.preventDefault();
                    $document.on('mousemove', mousemove);
                    $document.on('mouseup', mouseup);
                });

                function mousemove(event) {

                    $($attrs.resizerCover).show();
                    // Handle vertical resizer
                    var x = event.pageX;
                    var i = window.innerWidth;

                    if (x < 600) {
                        x = 600;
                    }

                    if (x > (i - 400)) {
                        x = (i - 400);
                    }

                    var wl = $($attrs.resizerLeft).width();
                    var wr = $($attrs.resizerRight).width();

                    $($attrs.resizerLeft).css({
                        width: x + 'px'
                    });
                    $($attrs.resizerRight).css({
                        width: (i - x) + 'px'
                    });
                }

                function mouseup() {
                    $($attrs.resizerCover).hide();
                    $document.unbind('mousemove', mousemove);
                    $document.unbind('mouseup', mouseup);
                }
            }
        }
    });

    /**
     * Readded ng-confirm-click in order to provide quick ability to implement confirm boxes.
     *
     * ```
     * <button ng-confirm-click="Are you sure you want to to delete {{data.title}}?" confirmed-click="remove(data)">Remove</button>
     * ```
     */
    zaa.directive("ngConfirmClick", function () {
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.confirmedClick;
                element.bind("click", function (event) {
                    if (window.confirm(msg)) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
    });

    /**
     * Focus a given input field if the statement is true.
     * 
     * ```
     * <input type="text" focus-me="searchInputOpen" />
     * ```
     */
    zaa.directive('focusMe', ['$timeout', '$parse', function ($timeout, $parse) {
        return {
            link: function (scope, element, attrs) {
                var model = $parse(attrs.focusMe);
                scope.$watch(model, function (value) {
                    if (value === true) {
                        $timeout(function () {
                            element[0].focus();
                        });
                    }
                });
                // on blur event:
                /*
                element.bind('blur', function () {
                    scope.$apply(model.assign(scope, false));
                });
                */
            }
        };
    }]);

    /**
     * ```
     * <a href="#" click-paste-pusher="foobar">Test</a>
     * ```
     */
    zaa.directive("clickPastePusher", ['$rootScope', '$compile', function ($rootScope, $compile) {
        return {
            restrict: 'A',
            replace: false,
            link: function (scope, element, attrs) {
                element.bind('click', function () {
                    $rootScope.$broadcast('insertPasteListener', attrs['clickPastePusher']);
                })
            }
        }
    }]);

    /**
     *
     * ```
     * $rootScope.$broadcast('insertPasteListener', $scope.someInput);
     * ```
     *
     * ```
     * <textarea insert-paste-listener></textarea>
     * ```
     */
    zaa.directive('insertPasteListener', ['$rootScope', function ($rootScope) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.bind("focus", function () {
                    $rootScope.lastElement = element[0];
                    var offCallFn = $rootScope.$on('insertPasteListener', function (e, val) {
                        var domElement = $rootScope.lastElement;

                        if (domElement != element[0] || !domElement) {
                            return false;
                        }

                        $rootScope.$$listeners.insertPasteListener = [];

                        if (document.selection) {
                            domElement.focus();
                            var sel = document.selection.createRange();
                            sel.text = val;
                            domElement.focus();
                        } else if (domElement.selectionStart || domElement.selectionStart === 0) {
                            var startPos = domElement.selectionStart;
                            var endPos = domElement.selectionEnd;
                            var scrollTop = domElement.scrollTop;
                            domElement.value = domElement.value.substring(0, startPos) + val + domElement.value.substring(endPos, domElement.value.length);
                            domElement.focus();
                            domElement.selectionStart = startPos + val.length;
                            domElement.selectionEnd = startPos + val.length;
                            domElement.scrollTop = scrollTop;
                        } else {
                            domElement.value += val;
                            domElement.focus();
                        }
                    });
                });
            }
        }
    }]);
    

    /**
     * Example usage of luya admin modal:
     *
     * ```js
     * <button ng-click="modalState=!modalState">Toggle Modal</button>
     * <modal is-modal-hidden="modalState" modal-title="I am the Title">
     *     <h1>Modal Container</h1>
     *     <p>Hello world!</p>
     * </modal>
     * ```
     * 
     * If you want to hidden use ng-if with modals, you have to use ng-if inside the modal like:
     * 
     * ```js
     * <modal is-modal-hidden="modalState">
     *    <div ng-if="!modalState">
     *        <p>This is only linked when modalState is visible</p>
     *    </div>
     * </modal>
     * ```
     * 
     * > Using the ng-if outside of the modal wont work as it does not trigger the modalState due to child scope creation each time
     * > the ng-if is visible.
     * 
     */
    zaa.directive("modal", function ($timeout) {
        return {
            restrict: "E",
            scope: {
                isModalHidden: "=",
                title: '@modalTitle'
            },
            replace: true,
            transclude: true,
            templateUrl: "modal",
            controller : function($scope, AdminClassService) {
            	$scope.$watch('isModalHidden', function(n, o) {
            		if (n !== o) {
            			if (n) { // is hidden
            				AdminClassService.modalStackRemove();
                		} else { // is visible
                			AdminClassService.modalStackPush();
                		}
            		}
            	});
            	
            	/* ESC Key will close ALL modals, therefore we ensure the correct spaces */
            	$scope.escModal = function() {
            		$scope.isModalHidden = true;
            		AdminClassService.modalStackRemoveAll();
            	};
            },
            link: function (scope, element) {
            	scope.$on('$destroy', function() {
            		element.remove();
            	});
            	angular.element(document.body).append(element);
            }
        }
    });
    
    /* CRUD, FORMS & FILE MANAGER */
    
    /**
     * If modelSelection and modelSetter is enabled, you can select a given row based in its primary key which will triggered the ngrest of the parent CRUD form.
     * 
     * ```
     * <crud-loader api="admin/api-admin-proxy" alias="Name of the CRUD Active Window"></crud-loader>
     * ```
     */
    zaa.directive("crudLoader", function($http, $sce) {
    	return {
    		restrict: "E",
    		replace: true,
    		transclude: false,
    		scope: {
    			"api": "@",
    			"alias" : "@",
    			"modelSelection" : "@",
    			"modelSetter": "="
    		},
    		controller: function($scope) {

    			$scope.input = { showWindow : true};

    			$scope.content = null;

    			$scope.toggleWindow = function() {
    				if ($scope.input.showWindow) {
    					$http.get($scope.api+'/?inline=1&modelSelection=' + $scope.modelSetter).then(function(response) {
    						$scope.content = $sce.trustAsHtml(response.data);
    						$scope.input.showWindow = false;
    					});
    				} else {
    					$scope.$parent.loadService();
    					$scope.input.showWindow = true;
    				}
    			};
    			
    			$scope.$watch('input.showWindow', function(n, o) {
    				if (n !== o && n == 1) {
    					$scope.$parent.loadService();
    				}
    			});
    			
    			/**
    			 * @param integer $value contains the primary key
    			 * @param array $row contains the full row from the crud loader model in order to display data.
    			 */
    			$scope.setModelValue = function(value, row) {
    				$scope.modelSetter = value;
    				$scope.toggleWindow();
    			};
    		},
    		template: function() {
    			return '<div class="crud-loader-tag"><button ng-click="toggleWindow()" type="button" class="btn btn-info btn-icon"><i class="material-icons">playlist_add</i></button><modal is-modal-hidden="input.showWindow" modal-title="{{alias}}"><div class="modal-body" compile-html ng-bind-html="content"></modal></div>';
    		}
    	}
    });
    
    zaa.directive("crudRelationLoader", function($http, $sce) {
    	return {
    		restrict: "E",
    		replace: true,
    		transclude: false,
    		scope: {
    			"api": "@api",
    			"arrayIndex": "@arrayIndex",
    			"modelClass" : "@modelClass",
    			"id": "@id"
    		},
    		controller: function($scope) {
    			$scope.content = null;
    			$http.get($scope.api+'/?inline=1&relation='+$scope.id+'&arrayIndex='+$scope.arrayIndex+'&modelClass='+$scope.modelClass).then(function(response) {
					$scope.content = $sce.trustAsHtml(response.data);
    			});
    		},
    		template: function() {
    			return '<div compile-html ng-bind-html="content"></div>';
    		}
    	}
    });

    /**
     * Generate form input types based on ZAA Directives.
     * 
     * Usage inside another Angular Template:
     * 
     * ```php
     * <zaa-injector dir="zaa-text" options="{}" fieldid="myFieldId" initvalue="0" label="My Label" model="mymodel"></zaa-injector>
     * ```
     */
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
                "placeholder": "@placeholder",
                "initvalue": "@initvalue"
            },
            link: function($scope, $element) {
                var elmn = $compile(angular.element('<' + $scope.dir + ' options="options" initvalue="{{initvalue}}" fieldid="{{fieldid}}" placeholder="{{placeholder}}" model="model" label="{{label}}" i18n="{{grid}}" />'))($scope);
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
                "id": "@fieldid"
    		},
    		controller: function($scope, $filter) {

    			$scope.searchString;

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
    				});

    				if (!match) {
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
    			return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                    '<div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div>' +
                    '<div class="form-side">' +
                            '<div class="list">' +
                                '<div class="list-item" ng-repeat="(key, item) in getModelItems() track by key">' +
                                    '<div class="list-buttons">' +
                                        '<i ng-show="!$first" ng-click="moveUp(key)" class="material-icons" style="transform: rotate(270deg);">play_arrow</i>' +
                                        '<i ng-show="!$last" ng-click="moveDown(key)" class="material-icons" style="transform: rotate(90deg);">play_arrow</i>' +
                                    '</div>' +

                                    '<span>{{item.label}}</span>' +

                                    '<div class="float-right">' +
                                        '<i ng-click="removeFromModel(key)" class="material-icons">delete</i>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="list-item" ng-show="sourceData.length != model.length">' +
                                    '<input class="form-control" type="search" ng-model="searchString" ng-focus="dropdownOpen = true" />' +
                                    '<ul class="list-group">' +
                                        '<li class="list-group-item list-group-item-action" ng-repeat="option in getSourceOptions() | filter:searchString" ng-show="dropdownOpen && elementInModel(option)" ng-click="addToModel(option)">' +
                                            '<i class="material-icons">add_circle</i><span>{{ option.label }}</span>' +
                                        '</li>' +
                                    '</ul>' +
                                    '<div class="list-chevron">' +
                                        '<i ng-click="dropdownOpen=!dropdownOpen" class="material-icons" ng-show="dropdownOpen">arrow_drop_up</i>' +
                                        '<i ng-click="dropdownOpen=!dropdownOpen" class="material-icons" ng-show="!dropdownOpen">arrow_drop_down</i>' +
                                    '</div>' +
                                '</div>' +
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
                "id": "@fieldid"
            },
            controller: function($scope) {
            	$scope.unset = function() {
            		$scope.model = false;
            		$scope.data.model = null;
            	};
            	
            	$scope.data = {
            		modalState: 1,
            		model: null
            	};
            	
            	$scope.$watch('model', function(n, o) {
            		if (n) {
            			$scope.data.model = n;
            		}
            	}, true);
            	
            	$scope.$watch('data.model', function(n, o) {
            		if (n) {
            			$scope.model = n;
            		}
            	}, true);
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><labelfor="{{id}}">{{label}}</label></div><div class="form-side">' +
                    '<div ng-if="model">' +
                        '<div class="link-selector">' +
                            '<div class="link-selector-actions">' +
                                '<div class="link-selector-btn btn btn-secondary" ng-click="data.modalState=0">' +
                                    '<i class="material-icons left">insert_link</i>' +
                                    '<span>' + i18n['js_link_set_value'] + '</span>' +
                                '</div>' +
                                '<span ng-hide="model | isEmpty" class="link-selector-reset" ng-click="unset()"><i class="material-icons">remove_circle</i></span>' + 
                            '</div><link-object-to-string class="ml-2" link="model"></link-object-to-string>' +
                        '</div>' +
                    '</div>' +
                    '<div ng-if="!model">' +
                        '<div class="link-selector">' +
                            '<div class="link-selector-actions">' +
                                '<div class="link-selector__btn btn btn-secondary" ng-click="data.modalState=0">' +
                                    '<i class="material-icons left">insert_link</i>' +
                                    '<span>'+i18n['js_link_set_value']+'</span>' +
                                '</div>' +
                                '<span style="margin-left:10px;">'+i18n['js_link_not_set']+'</span>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<modal is-modal-hidden="data.modalState" modal-title="{{label}}"><form ng-submit="data.modalState=1">'+
                        '<update-form-redirect data="data.model"></update-form-redirect>' +
                        '<button ng-click="data.modalState=1" class="btn btn-icon btn-save" type="submit">'+i18n['js_link_set_value']+'</button></form>' +
                    '</modal>'+
                '</div></div>';
            }
        }
    });

    zaa.directive("zaaSlug", function() {
    	return {
    		restrict: "E",
    		scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
    		controller: function($scope, $filter) {
    			$scope.$watch(function() { return $scope.model; }, function(n, o) {
    				if (n!=o) {
    					$scope.model = $filter('slugify')(n);
    				}
    			});
    		},
    		template:function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" insert-paste-listener ng-model="model" type="text" class="form-control" placeholder="{{placeholder}}" /></div></div>';
    		}
    	}
    });
    
    zaa.directive("zaaColor", function() {
    	return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
            controller: function($scope) {
                function getTextColor(){
                    if(typeof $scope.model === 'undefined') {
                        return '#000';
                    }

                    var hex = $scope.model;

                    if(typeof $scope.model === 'string') {
                        hex = hex.substr(1);
                    }

                    if(hex.length === 3) {
                        var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
                        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
                            return r + r + g + g + b + b;
                        });
                    }

                    if(hex.length === 6) {
                        var r = parseInt(hex.substr(0, 2), 16);
                        var g = parseInt(hex.substr(2, 2), 16);
                        var b = parseInt(hex.substr(4, 2), 16);
                        var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
                        return (yiq >= 128) ? '#000' : '#fff';
                    }

                    return '#000';
                }

                $scope.textColor = getTextColor();

                $scope.$watch(function() { return $scope.model; }, function(n, o) {
                    $scope.textColor = getTextColor();
                });
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label for="{{id}}">{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="colorwheel">' +
                                    '<div class="colorwheel-background" style="background-color: {{model}};">' +
                                        '<input class="colorwheel-input" type="text" ng-model="model" style="color: {{textColor}}; border-color: {{textColor}};" maxlength="7" />' +
                                    '</div>' +
                                    '<div class="colorwheel-wheel"><div ng-colorwheel="{ size: 150, segments: 120 }" ng-model="model"></div></div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
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
                "id": "@fieldid"
            },
            template: function() {
                return '<ng-wig ng-disabled="false" ng-model="model" buttons="bold, italic, link, list1, list2"></ng-wig>';
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
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" ng-model="model" type="number" min="0" class="form-control" ng-class="{\'invalid\' : !isValid }" placeholder="{{placeholder}}" /></div></div>';
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
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" ng-model="model" type="number" min="0" step="{{steps}}" class="form-control" ng-class="{\'invalid\' : !isValid }" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });

    /**
     * <zaa-text model="itemCopy.title" label="<?= Module::t('view_index_page_title'); ?>" />
     */
    zaa.directive("zaaText", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "placeholder": "@placeholder"
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" insert-paste-listener ng-model="model" type="text" class="form-control" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });
    
    /**
     * <zaa-async-value model="theModel" label="Hello world" api="admin/admin-users" fields="[foo,bar]" />
     */
    zaa.directive("zaaAsyncValue", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "api" : "@",
                "fields" : "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid"
            },
            controller: function($scope, $timeout, $http) {
            	$timeout(function() {
            		$scope.$watch('model', function(n, o) {
            			if (n) {
                    		$scope.value = '';
            				$http.get($scope.api + "/" + n + "?fields=" + $scope.fields.join()).then(function(response) {
            					$scope.value;
            					angular.forEach(response.data, function(value) {
            						if (value) {
            							$scope.value = $scope.value + value + " ";
            						}
            					});
            				});
            			}
            		});
            	});
            	
            	$scope.resetValue = function() {
            		$scope.model = 0;
            		$scope.value = null;
            	};
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><span ng-bind="value"></span><button type="button" class="btn btn-icon btn-cancel" ng-click="resetValue()" ng-show="model"></button></div></div>';
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
                "placeholder": "@placeholder"
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><textarea id="{{id}}" insert-paste-listener ng-model="model" type="text" class="form-control" auto-grow placeholder="{{placeholder}}"></textarea></div></div>';
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
                "id": "@fieldid"
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}"><div class="form-side form-side-label"><label for="{{id}}">{{label}}</label></div><div class="form-side"><input id="{{id}}" ng-model="model" type="password" class="form-control" placeholder="{{placeholder}}" /></div></div>';
            }
        }
    });

    /**
     * <zaa-radio model="model" options="[{label:'foo', value: 'bar'}, {...}]">
     */
    zaa.directive("zaaRadio", function() {
    	return {
	    	restrict: "E",
	    	scope: {
	            "model": "=",
	            "options": "=",
	            "label": "@label",
	            "i18n": "@i18n",
	            "id": "@fieldid",
	            "initvalue": "@initvalue"
	    	},
	    	controller: function($scope) {
	    		$scope.setModelValue = function(value) {
	    			$scope.model = value;
	    		};
	    	},
	    	template: function() {
	    		return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
				            '<div class="form-side form-side-label">' +
				            	'<label for="{{id}}">{{label}}</label>' +
				            '</div>' +
				            '<div class="form-side">' +
					        	'<div ng-repeat="(key, item) in options" class="form-check">'+
                                    '<input value="{{item.value}}" type="radio" ng-click="setModelValue(item.value)" ng-checked="item.value == model" name="{{id}}_{{key}}" class="form-check-input" id="{{id}}_{{key}}">' +
					        		'<label class="form-check-label" for="{{id}}_{{key}}">' +
					        			'{{item.label}}' +
					        		'</label>'+
					        	'</div>'+
					        '</div>'+
				        '</div>';
	    	}
    	};
    });
    
    /**
     * 
     * Usage Example:
     * 
     * ```js
     * <zaa-select model="data.module_name" label="<?= Module::t('view_index_module_select'); ?>" options="modules" />
     * ```
     * 
     * If an initvalue is provided, you can not reset the model to null.
     * 
     * Options value defintion:
     * 
     * ```js
     * options=[{"value":123,"label":123-Label}, {"value":abc,"label":ABC-Label}]
     * ```
     * 
     * In order to change the value and label keys which should be used to take the value and label keys within the given array use:
     * 
     * ```js
     * <zaa-select model="create.fromVersionPageId" label="My Label" options="typeData" optionslabel="version_alias" optionsvalue="id" />
     * ```
     */
    zaa.directive("zaaSelect", function($timeout, $rootScope) {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "optionsvalue" : "@optionsvalue",
                "optionslabel" : "@optionslabel",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
                "initvalue": "@initvalue"
            },
            controller: function($scope) {
            	
            	/* default scope values */
            	
            	$scope.isOpen = 0;
            	
            	if ($scope.optionsvalue == undefined) {
            		$scope.optionsvalue = 'value';
            	}
            	
            	if ($scope.optionslabel == undefined) {
            		$scope.optionslabel = 'label';
            	}
            	
		        if (jQuery.isNumeric($scope.model)){
		            $scope.model = typeCastValue($scope.model);
		        }
            	
		        /* listeners */
		        
            	$scope.$on('closeAllSelects', function() {
            		if ($scope.isOpen) {
            			$scope.closeSelect();
            		}
            	});
            	
                $timeout(function(){
                    $scope.$watch(function() { return $scope.model }, function(n, o) {
                        if (n == undefined || n == null || n == '') {
                            if (jQuery.isNumeric($scope.initvalue)) {
                                $scope.initvalue = typeCastValue($scope.initvalue);
                            }
                            var exists = $scope.valueExistsInOptions(n);
                            
                            if (!exists) {
                            	$scope.model = $scope.initvalue;
                            }
                        }
                    });
                });
            	
                /* methods */
                
                $scope.valueExistsInOptions = function(value) {
                	var exists = false;
                	angular.forEach($scope.options, function(item) {
                		if (value == item.value) {
                			exists = true;
                		}
                	});
                	return exists;
                };
                
            	$scope.toggleIsOpen = function() {
            		if (!$scope.isOpen) {
            			$rootScope.$broadcast('closeAllSelects');
            		}
            		$scope.isOpen = !$scope.isOpen;
            	};
            		
            	$scope.closeSelect = function() {
            		$scope.isOpen = 0;
            	};
                
                $scope.setModelValue = function(option) {
                	$scope.model = option[$scope.optionsvalue];
                	$scope.closeSelect();
                };
                
                $scope.getSelectedLabel = function() {
                	var defaultLabel = i18n['ngrest_select_no_selection'];
                	angular.forEach($scope.options, function(item) {
                		if ($scope.model == item[$scope.optionsvalue]) {
                			defaultLabel = item[$scope.optionslabel];
                		}
                	});
                	
                	return defaultLabel;
                };
                
                $scope.hasSelectedValue = function() {
                	var modelValue = $scope.model;
                	
                	if ($scope.valueExistsInOptions(modelValue) && modelValue != $scope.initvalue) {
                		return true;
                	}
                	
                	return false;
                };
            },
            template: function() {
                return '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label for="{{id}}">{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="zaaselect" ng-class="{\'open\':isOpen, \'selected\':hasSelectedValue()}">' +
                                    '<select class="zaaselect-select" ng-model="model">' +
                                        '<option ng-repeat="opt in options" ng-value="opt[optionsvalue]">{{opt[optionslabel]}}</option>' +
                                    '</select>' +
                                    '<div class="zaaselect-selected">' +
                                        '<span class="zaaselect-selected-text" ng-click="toggleIsOpen()">{{getSelectedLabel()}}</span>' +
                                        '<i class="material-icons zaaselect-clear-icon" ng-click="model=initvalue">clear</i>' +
                                        '<i class="material-icons zaaselect-dropdown-icon" ng-click="toggleIsOpen()">keyboard_arrow_down</i>' +
                                    '</div>' +
                                    '<div class="zaaselect-dropdown">' +
                                        '<div class="zaaselect-search">' +
                                            '<input class="zaaselect-search-input" type="search" focus-me="isOpen" ng-model="searchQuery" />' +
                                        '</div>' +
                                        '<div class="zaaselect-overflow">' +
                                            '<div class="zaaselect-item" ng-repeat="opt in options | filter:searchQuery" ng-click="setModelValue(opt)">' +
                                                '<span ng-class="{\'zaaselect-active\': opt[optionsvalue] == model}">{{opt[optionslabel]}}</span>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
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
                "label": "@label",
                "initvalue": "@initvalue"
            },
            controller: function($scope) {
                if ($scope.options === null || $scope.options === undefined) {
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
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label for="{{id}}">{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="form-check">' +
                                    '<input id="{{id}}" ng-true-value="{{valueTrue}}" ng-false-value="{{valueFalse}}" ng-model="model" type="checkbox" class="form-check-input-standalone" />' +
                                    '<label for="{{id}}"></label>' +
                                '</div>' +
                            '</div>' +
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
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label for="{{id}}">{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +

                                '<div class="input-group mb-3">' +
                                    '<div class="input-group-addon">' +
                                        '<i class="material-icons">search</i>' +
                                    '</div>' +
                                    '<input class="form-control" type="text" ng-change="filtering()" ng-model="searchString" placeholder="Enter search term...">' +

                                    '<span class="zaa-checkbox-array-counter badge badge-secondary">{{optionitems.length}} ' + i18n['js_dir_till'] + ' {{options.items.length}}</span>' +
                                '</div>' +

                                '<div class="form-check" ng-repeat="(k, item) in optionitems track by k">' +
                                    '<input type="checkbox" class="form-check-input" ng-checked="isChecked(item)" id="{{random}}_{{k}}" ng-click="toggleSelection(item)" />' +
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
     * 
     * resetable: 1/0, This will enable or disable the ability to press the reset (set to null) button. use integer value
     */
    zaa.directive("zaaDatetime", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "id": "@fieldid",
                "i18n": "@i18n",
                "resetable" : "@resetable",
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
            	};

            	$scope.datePickerToggler = false;

            	$scope.toggleDatePicker = function() {
            		$scope.datePickerToggler = !$scope.datePickerToggler;
            	};

            	$scope.openDatePicker = function() {
                    $scope.datePickerToggler = true;
                };

                $scope.closeDatePicker = function() {
                    $scope.datePickerToggler = false;
                };

            	$scope.hour = "0";

            	$scope.min = "0";
            	
            	$scope.reset = function() {
            		$scope.model = null;
            	};
            	
            	$scope.getIsResetable = function() {
            		if ($scope.resetable) {
            			return parseInt($scope.resetable);
            		}
            		
            		return true;
            	};
            },
            template: function() {
            	return  '<div class="form-group form-side-by-side zaa-datetime" ng-class="{\'input--hide-label\': i18n, \'input--with-time\': model!=null && date!=null}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side form-inline datepicker-wrapper">' +
                                '<datepicker date-set="{{pickerPreselect.toString()}}" date-week-start-day="1" datepicker-toggle="false" datepicker-show="{{datePickerToggler}}" date-format="dd.MM.yyyy">' +
                                        '<input class="form-control datepicker-date-input" ng-model="date" type="text" ng-focus="openDatePicker()" />' +
                                        '<div class="input-group-addon" ng-click="toggleDatePicker()">' +
                                            '<i class="material-icons" ng-hide="datePickerToggler">date_range</i>' +
                                            '<i class="material-icons" ng-show="datePickerToggler">close</i>' +
                                        '</div>' +
                                '</datepicker>' +
            	                '<div ng-show="model!=null && date!=null" class="hour-selection">' +
                                    '<div class="input-group">' +
                                        '<div class="input-group-addon">' +
                                            '<i class="material-icons">access_time</i>' +
                                        '</div>' +
                                        '<input class="form-control zaa-datetime-hour-input" type="text" ng-model="hour" ng-change="autoRefactor()" />' +
                                    '</div>' +
                                    '<div class="input-group">' +
                                        '<div class="input-group-addon zaa-datetime-time-colon">:</div>' +
                                        '<input class="form-control zaa-datetime-minute-input" type="text" ng-model="min" ng-change="autoRefactor()" />' +
                                    '</div>' +
            	                '</div>' +
            	                '<div ng-show="model && getIsResetable()"><button type="button" ng-click="reset()" class="ml-2 btn btn-icon btn-cancel"></nutton></div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * resetable: whether rest button is enabled or not.
     */
    zaa.directive("zaaDate", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "id": "@fieldid",
                "i18n": "@i18n",
                "resetable" : "@resetable"
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
            	};

            	$scope.datePickerToggler = false;

            	$scope.toggleDatePicker = function() {
            		$scope.datePickerToggler = !$scope.datePickerToggler;
            	};

                $scope.openDatePicker = function() {
                    $scope.datePickerToggler = true;
                };

                $scope.closeDatePicker = function() {
                    $scope.datePickerToggler = false;
                };
                
                $scope.reset = function() {
            		$scope.model = null;
            	};
            	
            	$scope.getIsResetable = function() {
            		if ($scope.resetable) {
            			return parseInt($scope.resetable);
            		}
            		
            		return true;
            	};
            },
            template: function() {
            	return  '<div class="form-group form-side-by-side zaa-date" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side datepicker-wrapper">' +
                                '<datepicker date-set="{{pickerPreselect.toString()}}" date-week-start-day="1" datepicker-toggle="false" datepicker-show="{{datePickerToggler}}" date-format="dd.MM.yyyy">' +
                                    '<input class="form-control datepicker-date-input" ng-model="date" type="text" ng-focus="openDatePicker()" />' +
                                    '<div class="input-group-addon" ng-click="toggleDatePicker()">' +
                                        '<i class="material-icons" ng-hide="datePickerToggler">date_range</i>' +
                                        '<i class="material-icons" ng-show="datePickerToggler">close</i>' +
                                    '</div>' +
                                '</datepicker>' +
                                '<div ng-show="model && getIsResetable()"><button type="button" ng-click="reset()" class="ml-2 btn btn-icon btn-cancel"></nutton></div>' +
                            '</div>' +
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
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label ng-if="label">{{label}}</label>' +
                                '<label ng-if="!label">Table</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="zaa-table-wrapper">' +
                                    '<table class="zaa-table table table-bordered">' +
                                        '<tbody>' +
                                            '<tr>' +
                                                '<th scope="col" width="35px"></th>' +
                                                '<th scope="col" data-ng-repeat="(hk, hr) in model[0] track by hk" class="zaa-table-buttons">' +
                                                    '<div class="btn-group" role="group">' +
                                                        '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveLeft(hk)" ng-if="hk > 0"><i class="material-icons">keyboard_arrow_left</i></button>' +
                                                        '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveRight(hk)" ng-if="showRightButton(hk)"><i class="material-icons">keyboard_arrow_right</i></button>' +
                                                        '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="removeColumn(hk)"><i class="material-icons">remove</i></button>' +
                                                    '</div>' +
                                                '</th>' +
                                            '</tr>' +
                                            '<tr data-ng-repeat="(key, row) in model track by key">' +
                                                '<td width="35px" scope="row" class="zaa-table-buttons">' +
                                                    '<div class="btn-group-vertical" role="group">' +
                                                        '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(key)" ng-if="key > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                        '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(key)" ng-if="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                        '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="removeRow(key)"><i class="material-icons">remove</i></button>' +
                                                    '</div>' +
                                                '</td>' +
                                                '<td data-ng-repeat="(field,value) in row track by field">'+
                                                    '<textarea ng-model="model[key][field]" class="zaa-table__textarea"></textarea>'+
                                                '</td>'+
                                            '</tr>' +
                                        '</tbody>' +
                                    '</table>' +
                                    '<button ng-click="addRow()" type="button" class="zaa-table-add-row btn btn-sm btn-success"><i class="material-icons">add</i></button>'+
                                    '<button ng-click="addColumn()" type="button" class="zaa-table-add-column btn btn-sm btn-success"><i class="material-icons">add</i></button>'+
                                '</div>' +
                            '</div>' +
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
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
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
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
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
            },
            link: function(scope, element, attributes){
                scope.$watch('model', function(newValue, oldValue) {
                    if(newValue.length >= 1) {
                        $(element).removeClass('is-empty').addClass('is-not-empty');
                    } else {
                        $(element).removeClass('is-not-empty').addClass('is-empty');
                    }
                }, true);
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
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="list zaa-file-array-upload">' +
                                    '<p class="alert alert-info" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                    '<div ng-repeat="(key,image) in model track by key" class="list-item">' +
                                        '<div class="list-section">' +
                                            '<div class="list-left">' +
                                                '<storage-image-upload ng-model="image.imageId" options="options"></storage-image-upload>' +
                                            '</div>' +
                                            '<div class="list-right">' +
                                                '<div class="form-group">' +
                                                    '<label for="{{image.id}}">' + i18n['js_dir_image_description'] + '</label>' +
                                                    '<textarea ng-model="image.caption" id="{{image.id}}" class="zaa-file-array-upload-description form-control" auto-grow></textarea>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="list-buttons">' +
                                            '<div class="btn-group" role="group">' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(key)" ng-if="key > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(key)" ng-if="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="remove(key)"><i class="material-icons">remove</i></button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<button ng-click="add()" type="button" class="btn btn-sm btn-success list-add-button"><i class="material-icons">add</i></button>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * Multiple selection of files.
     */
    zaa.directive("zaaFileArrayUpload", function(){
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
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
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="list zaa-file-array-upload">' +
                                    '<p class="alert alert-info" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                    '<div ng-repeat="(key,file) in model track by key" class="list-item">' +
                                    	'<div class="list-section" ng-if="file.hiddenStorageUploadSource">' +
                                    		'<a ng-href="{{file.hiddenStorageUploadSource}}" target="_blank" class="btn btn-primary">{{file.hiddenStorageUploadName}}</a>'+
                                    	'</div>' + 
                                        '<div class="list-section" ng-if="!file.hiddenStorageUploadSource">' +
                                            '<div class="list-left">' +
                                                '<storage-file-upload ng-model="file.fileId"></storage-file-upload>' +
                                            '</div>' +
                                            '<div class="list-right">' +
                                                '<div class="form-group">' +
                                                    '<label for="{{file.id}}">' + i18n['js_dir_image_description'] + '</label>' +
                                                    '<textarea ng-model="file.caption" id="{{file.id}}" class="zaa-file-array-upload-description form-control" auto-grow></textarea>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="list-buttons"  ng-if="!file.hiddenStorageUploadSource">' +
                                            '<div class="btn-group" role="group">' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(key)" ng-if="key > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(key)" ng-if="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="remove(key)"><i class="material-icons">remove</i></button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                                '<button ng-click="add()" type="button" class="btn btn-sm btn-success list-add-button"><i class="material-icons">add</i></button>' +
                            '</div>' +
                        '</div>';
            }
        }
    });

    /**
     * Generates an array where each array element can contain another directive from zaa types.
     * 
     * @retunr array
     */
    zaa.directive("zaaMultipleInputs", function() {
        return {
            restrict: "E",
            scope: {
                "model": "=",
                "options": "=",
                "label": "@label",
                "i18n": "@i18n",
                "id": "@fieldid",
            },
            controller: function ($scope, $timeout) {
                $scope.init = function() {
                    if ($scope.model == undefined || $scope.model == null) {
                        $scope.model = [];
                    } else {
                    	angular.forEach($scope.model, function(value, key) {
                    		var len = Object.keys(value).length;
                    		/* issue #1519: if there are no keys, ensure the item is an object */
                    		if (len == 0) {
                    			$scope.model[key] = {};
                    		}
                    	})
                    }
                };

                $scope.add = function() {
                    if ($scope.model == null || $scope.model == '' || $scope.model == undefined) {
                        $scope.model = [];
                    }

                    $scope.model.push({});
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
                    return parseInt(index) < Object.keys($scope.model).length - 1;
                };

                $timeout(function() {
                	$scope.init();
                });
            },
            template: function() {
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="list zaa-multiple-inputs">' +
                                    '<p class="alert alert-info" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                    '<div ng-repeat="(msortKey,row) in model track by msortKey" class="list-item" ng-init="ensureRow(row)">' +
                                        '<div ng-repeat="(mutliOptKey,opt) in options track by mutliOptKey"><zaa-injector dir="opt.type" options="opt.options" fieldid="id-{{msortKey}}-{{mutliOptKey}}" initvalue="{{opt.initvalue}}" label="{{opt.label}}" model="row[opt.var]"></zaa-injector></div>' +
                                        '<div class="list-buttons">' +
                                            '<div class="btn-group" role="group">' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(msortKey)" ng-if="msortKey > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(msortKey)" ng-if="showDownButton(msortKey)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="remove(msortKey)"><i class="material-icons">remove</i></button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<button ng-click="add()" type="button" class="btn btn-sm btn-success list-add-button"><i class="material-icons">add</i></button>' +
                                '</div>' +
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
                };

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
                return  '<div class="form-group form-side-by-side" ng-class="{\'input--hide-label\': i18n}">' +
                            '<div class="form-side form-side-label">' +
                                '<label>{{label}}</label>' +
                            '</div>' +
                            '<div class="form-side">' +
                                '<div class="list zaa-file-array-upload">' +
                                    '<p class="alert alert-info" ng-hide="model.length > 0">'+i18n['js_dir_no_selection']+'</p>' +
                                    '<div ng-repeat="(key,row) in model track by key" class="list-item">' +
                                        '<input class="form-control list-input" type="text" ng-model="row.value" />' +
                                        '<div class="list-buttons">' +
                                            '<div class="btn-group" role="group">' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveUp(key)" ng-if="key > 0"><i class="material-icons">keyboard_arrow_up</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-info" ng-click="moveDown(key)" ng-if="showDownButton(key)"><i class="material-icons">keyboard_arrow_down</i></button>' +
                                                '<button type="button" class="btn btn-sm btn-outline-danger" ng-click="remove(key)"><i class="material-icons">remove</i></button>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<button ng-click="add()" type="button" class="btn btn-sm btn-success list-add-button"><i class="material-icons">add</i></button>' +
                                '</div>' +
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
            },
            controller: function($scope) {


                // ServiceFilesData inhertiance

            	$scope.filesData = ServiceFilesData.data;

            	$scope.$on('service:FilesData', function(event, data) {
            		$scope.filesData = data;
                });

                // controller logic

            	$scope.modal = {state: 1};
            	
            	$scope.modalContainer = false;
            	
            	$scope.fileinfo = null;

            	$scope.select = function(fileId) {
                	$scope.toggleModal();
                	$scope.ngModel = fileId;
                };

            	$scope.reset = function() {
            		$scope.ngModel = 0;
            		$scope.fileinfo = null;
                };

            	$scope.toggleModal = function() {
            		$scope.modalContainer = !$scope.modalContainer;
            		$scope.modal.state = !$scope.modal.state;
                };

            	$scope.$watch(function() { return $scope.ngModel }, function(n, o) {
                    if (n != 0 && n != null && n !== undefined) {
                        var filtering = $filter('filter')($scope.filesData, {id: parseInt(n)}, true);
                        if (filtering && filtering.length == 1) {
                        	$scope.fileinfo = filtering[0];
                        }
                    }

                    /* reset file directive if an event resets the image model to undefined */
                    if (n == 0) {
                    	$scope.reset();
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
                    	var filtering = $filter('filter')($scope.filesData, {id: parseInt(n)}, true);
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
                        }).then(function(transport) {
                            if (!transport.data.error) {
                                scope.imagesDataReload().then(function(r) {
                                    scope.ngModel = transport.data.id;
                                    AdminToastService.success(i18n['js_dir_image_upload_ok']);
                                    scope.imageLoading = false;
                                });
                            }
                        }, function(error) {
                        	AdminToastService.error(i18n['js_dir_image_filter_error']);
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
                
                // file replace logic

                $scope.folderCountMessage = function(folder) {
                	return i18nParam('js_filemanager_count_files_overlay', {count: folder.filesCount});
                }
                
                $scope.errorMsg = null;
                
                $scope.replaceFile = function(file, errorFiles) {
                	$scope.replaceFiled = file;
                	
                	if (!file) {
                		return;
                	}
                	
                	LuyaLoading.start();
                	
                	Upload.upload({
                		url: 'admin/api-admin-storage/file-replace',
                        data: {file: file, fileId: $scope.fileDetail.id}
                    }).then(function (response) {
                    	LuyaLoading.stop();
                    	if (response.status == 200) {
                            $scope.filesDataReload().then(function() {
                            	var fileref = $filter('findidfilter')($scope.filesData, $scope.fileDetail.id, true);
                            	var random = (new Date()).toString();
                            	if (fileref.isImage) {
	                            	fileref.thumbnail.source = fileref.thumbnail.source + "?cb=" + random;
	                            	fileref.thumbnailMedium.source = fileref.thumbnailMedium.source + "?cb=" + random;
	                            }
                            	$scope.fileDetail = fileref;
                            	AdminToastService.success('the file has been replaced successfull.');
                            });
                    	}
                    }, function() {
                    	LuyaLoading.stop();
                    });
                };

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
                        if (n == $scope.uploadingfiles.length && $scope.errorMsg == null) {
                            $scope.filesDataReload().then(function() {
                            	AdminToastService.success(i18n['js_dir_manager_upload_image_ok']);
                                LuyaLoading.stop();
                            });
                        }
                    }
                })

                $scope.pasteUpload = function(e) {
                	
                    for (var i = 0 ; i < e.originalEvent.clipboardData.items.length ; i++) {
                        var item = e.originalEvent.clipboardData.items[i];
                        
                        if (item.kind == 'file') {
                        	LuyaLoading.start(i18n['js_dir_upload_wait']);
	                        Upload.upload({
	                            url: 'admin/api-admin-storage/files-upload',
	                            fields: {'folderId': $scope.currentFolderId},
	                            file: item.getAsFile()
	                        }).then(function(response) {
                        		if (response.data.upload) {
		                        	$scope.filesDataReload().then(function() {
		                            	AdminToastService.success(i18n['js_dir_manager_upload_image_ok']);
		                            	LuyaLoading.stop();
		                            });
                        		} else {
                        			AdminToastService.error(response.data.message);
                        			LuyaLoading.stop();
                        		}
	                        	
	                        })
                        }
                    }
                }
                
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
                            if (!file.result.upload) {
                            	AdminToastService.error(file.result.message);
                            	LuyaLoading.stop();
                                $scope.errorMsg = true
                            }
                        });
                    }, function (response) {
                        if (response.status > 0) {
                            $scope.errorMsg = true;
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
                	if (!newFolderName) {
                		return;
                	}
                    $http.post('admin/api-admin-storage/folder-create', $.param({ folderName : newFolderName , parentFolderId : $scope.currentFolderId }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function() {
                        $scope.foldersDataReload().then(function() {
                            $scope.folderFormToggler();
                            $scope.newFolderName = null;
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
                };

                $scope.changeCurrentFolderId = function(folderId, noState) {
                    $scope.currentFolderId = folderId;
                    if (noState !== true) {
                    	ServiceFoldersDirecotryId.folderId = folderId;
                    	$http.post('admin/api-admin-common/save-filemanager-folder-state', {folderId : folderId}, {ignoreLoadingBar: true});
                    }
                };

                $scope.toggleFolderItem = function(data) {
                    if (data.toggle_open == undefined) {
                        data['toggle_open'] = 1;
                    } else {
                        data['toggle_open'] = !data.toggle_open;
                    }
                    $http.post('admin/api-admin-common/filemanager-foldertree-history', {data : data}, {ignoreLoadingBar: true});
                };

                $scope.folderUpdateForm = false;

                $scope.folderDeleteForm = false;

                $scope.folderDeleteConfirmForm = false;

                /*
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
                
                */

                $scope.updateFolder = function(folder) {
                    $http.post('admin/api-admin-storage/folder-update?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {});
                }

                /*
                $scope.checkEmptyFolder = function(folder) {
                    $http.post('admin/api-admin-storage/is-folder-empty?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {
                        if (transport.data == true) {
                            $scope.deleteFolder(folder);
                        } else {
                            $scope.toggleFolderMode('removeconfirm');
                        }
                    });
                };
				*/
                $scope.deleteFolder = function(folder) {

                    // check if folder is empty
                	$http.post('admin/api-admin-storage/is-folder-empty?folderId=' + folder.id, $.param({ name : folder.name }), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {
                        if (transport.data == true) {

                            $http.post('admin/api-admin-storage/folder-delete?folderId=' + folder.id, $.param({ name : folder.name }), {
                                headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                            }).then(function(transport) {
                                $scope.foldersDataReload().then(function() {
                                    $scope.filesDataReload().then(function() {
                                        $scope.currentFolderId = 0;
                                    });
                                });
                            });

                        } else {
                            AdminToastService.confirm(i18nParam('layout_filemanager_remove_dir_not_empty', {folderName: folder.name, count: folder.filesCount}), i18n['js_dir_manager_rm_folder_confirm_title'], function($timeout, $toast) {
                                $http.post('admin/api-admin-storage/folder-delete?folderId=' + folder.id, $.param({ name : folder.name }), {
                                    headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                                }).then(function() {
                                    $scope.foldersDataReload().then(function() {
                                        $scope.filesDataReload().then(function() {
                                            $scope.currentFolderId = 0;
                                            $toast.close();
                                        });
                                    });
                                });
                            });
                        }
                    });
                };

                $scope.fileDetail = false;

                $scope.showFoldersToMove = false;

                $scope.openFileDetail = function(file) {
                	if ($scope.fileDetail.id == file.id) {
                		$scope.closeFileDetail();
                	} else {
                		$scope.fileDetail = file;
                	}
                };

                $scope.closeFileDetail = function() {
                    $scope.fileDetail = false;
                };

                $scope.moveFilesTo = function(folderId) {
                    $http.post('admin/api-admin-storage/filemanager-move-files', $.param({'fileIds' : $scope.selectedFiles, 'toFolderId' : folderId}), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {
                        $scope.filesDataReload().then(function() {
                            $scope.selectedFiles = [];
                            $scope.showFoldersToMove = false;
                        });
                    });
                };

                $scope.removeFiles = function() {
                    AdminToastService.confirm(i18n['js_dir_manager_rm_file_confirm'], i18n['js_dir_manager_rm_file_confirm_title'], function($timeout, $toast) {
                        $http.post('admin/api-admin-storage/filemanager-remove-files', $.param({'ids' : $scope.selectedFiles}), {
                            headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                        }).then(function(transport) {
                            $scope.filesDataReload().then(function() {
                                $toast.close();
                                AdminToastService.success(i18n['js_dir_manager_rm_file_ok']);
                                $scope.selectedFiles = [];
                            });
                        });
                    });
                }

                // file detail view logic

                $scope.storeFileCaption = function(fileDetail) {
                	$http.post('admin/api-admin-storage/filemanager-update-caption', $.param({'id': fileDetail.id, 'captionsText' : fileDetail.captionArray}), {
                        headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                    }).then(function(transport) {
                    	AdminToastService.success('Captions has been updated');
                    });
                }
               
                $scope.selectedFileFromParent = null;
                
                $scope.init = function() {
                	if ($scope.$parent.fileinfo) {
                		$scope.selectedFileFromParent = $scope.$parent.fileinfo;
                		$scope.changeCurrentFolderId($scope.selectedFileFromParent.folderId, true);
                	}
                }
                
                $scope.init();

            },
            templateUrl : 'storageFileManager'
        }
    });

    zaa.directive("hasEnoughSpace", function($window, $document, $timeout) {
        return {
            restrict: "A",
            scope: {
                "loadingCondition": "=",
                "isFlexBox": "="
            },
            link: function (scope, element, attrs) {
                scope.elementWidth = 0;

                var getElementOriginalWidth = function() {
                    var elementClone = element.clone().insertAfter(element);

                    elementClone.css({
                        'position': 'fixed',
                        'top': 0,
                        'left': 0,
                        'visibility': 'hidden'
                    });

                    if(elementClone.css('display') === 'none') {
                        elementClone.css('display', scope.isFlexBox ? 'flex' : 'block');
                    }

                    var elementOriginalWidth = elementClone.outerWidth();

                    elementClone.remove();

                    return elementOriginalWidth;
                };


                function checkSize() {
                    $timeout(function() {
                        if(!scope.elementOriginalWidth) {
                            scope.elementOriginalWidth = getElementOriginalWidth();
                        }

                        if(element.hasClass('not-enough-space')) {
                            element.removeClass('not-enough-space');
                            element.addClass('has-enough-space');
                        }

                        var currentElementSpace = element.parent().outerWidth();

                        if(currentElementSpace < scope.elementOriginalWidth) {
                            element.removeClass('has-enough-space').addClass('not-enough-space');
                        } else {
                            element.removeClass('not-enough-space').addClass('has-enough-space');
                        }
                    });
                }

                angular.element($window).on('resize', function() {
                    checkSize();
                });

                scope.$watch('loadingCondition', function(n) {
                    if(n == true) {
                        checkSize();
                    }
                });

            }
        }
    });

    zaa.directive('activeClass', function () {
        return {
            restrict: 'A',
            scope: {
                activeClass: '@'
            },
            link: function (scope, element) {
                element.on('mouseenter', function() {
                    element.addClass(scope.activeClass);
                });
                element.on('mouseleave', function() {
                    element.removeClass(scope.activeClass);
                });
                element.on('click', function() {
                    element.toggleClass(scope.activeClass);
                });
            }
        };
    });


})();
