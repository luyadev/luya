var zaa = angular.module("zaa", ["ui.router", "ngDragDrop", "angular-loading-bar", "ngFileUpload", "ngWig", "slugifier", "flow", "angular.filter", "720kb.datepicker", "localytics.directives"]);


/**
 * guid creator
 * @returns {String}
 */
function guid() {
	function s4() {
		return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
	}
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
}

function i18nParam(varName, params) {
	var varValue = i18n[varName];

	angular.forEach(params, function(value, key) {
		varValue = varValue.replace("%"+key+"%", value);
	})

	return varValue;
}

/**
 * Type cast numeric values to integer
 *
 * @param value
 * @returns
 */
function typeCastValue(value) {
	return $.isNumeric(value) ? parseInt(value) : value;
}

/* zephir angular admin */
/* resolve controller: https://github.com/angular-ui/ui-router/wiki#resolve */
(function() {
	"use strict";

	zaa.config(function ($httpProvider, $stateProvider, $controllerProvider) {
		$httpProvider.interceptors.push("authInterceptor");

		zaa.bootstrap = $controllerProvider;

		$stateProvider
			.state("default", {
				url: "/default/:moduleId",
				templateUrl: function($stateParams) {
					return "admin/template/default";
				}
			})
			.state("default.route", {
				url: "/:moduleRouteId/:controllerId/:actionId",
				templateUrl: function ($stateParams) {
	                return $stateParams.moduleRouteId + "/" + $stateParams.controllerId  + "/" + $stateParams.actionId;
	            },
	            parent: 'default',
	            resolve : {
	            	adminServiceResolver: adminServiceResolver
				}
			})
			.state("custom", {
				url: "/template/:templateId",
				templateUrl: function($stateParams) {
					var res = $stateParams.templateId.split("-");
					return res[0] + "/" + res[1] + "/" + res[2];
				},
				resolve : {
					adminServiceResolver: adminServiceResolver,
					resolver : function(resolver) {
						return resolver.then;
					},
				}
			})
			.state("home", {
				url: "",
				templateUrl: "admin/default/dashboard"
			});
	});

	/**
	 * attach custom callback function to the custom state resolve. Use the resolverProvider in
	 * your configuration part:
	 *
	 * zaa.config(function(resolverProvider) {
	 *		resolverProvider.addCallback(function(ServiceMenuData, ServiceBlocksData) {
	 *			ServiceMenuData.load();
	 *			ServiceBlocksData.load();
	 *		});
	 * });
	 */
	zaa.provider("resolver", function() {
		var list = [];

		this.addCallback = function(callback) {
			list.push(callback);
		}

		this.$get = function($injector, $q, $state) {
			return $q(function(resolve, reject) {
				for(var i in list) {
					$injector.invoke(list[i]);
				}
			})
		}
	})

	zaa.filter('trustAsUnsafe', function($sce) {
	    return function(val, enabled) {
	        return $sce.trustAsHtml(val);
	    };
	});

	/**
	 * Controller: $scope.content = $sce.trustAsHtml(response.data);
	 * Template: <div compile-html ng-bind-html="content | trustAsUnsafe"></div>
	 */
	zaa.directive("compileHtml", function($compile, $parse) {
		return {
			restrict: "A",
			link: function(scope, element, attr) {
				var parsed = $parse(attr.ngBindHtml);
				scope.$watch(function() { return (parsed(scope) || "").toString(); }, function() {
			        $compile(element, null, -9999)(scope);  //The -9999 makes it skip directives so that we do not recompile ourselves
		        });
		    }
		};
	});

	/**
	 * Usage:
	 *
	 * <div zaa-esc="methodClosesThisDiv()" />
	 */
	zaa.directive("zaaEsc", function() {
		return function(scope, element, attrs) {
			$(document).on("keyup", function(e) {
				if (e.keyCode == 27) {
					scope.$apply(function() {
						scope.$eval(attrs.zaaEsc);
					});
				}
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
                if($shadow != null) {
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

	zaa.directive('resizer', function($document) {

		return {
			scope: {
				trigger : '@'
			},
			link: function($scope, $element, $attrs) {


				$scope.$watch('trigger', function(n, o) {
					if (n == 0) {
						$($attrs.resizerLeft).removeAttr('style');
						$($attrs.resizerRight).removeAttr('style');
					}
				})

				$element.on('mousedown', function(event) {
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

					if (x > (i-400)) {
						x = (i-400);
					}

					var wl = $($attrs.resizerLeft).width();
					var wr = $($attrs.resizerRight).width();

					$($attrs.resizerLeft).css({
						width: x + 'px'
					});
					$($attrs.resizerRight).css({
						width: (i-x) + 'px'
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
	zaa.directive("ngConfirmClick", function() {
 	     return {
 	         link: function (scope, element, attr) {
 	             var msg = attr.ngConfirmClick || "Are you sure?";
 	             var clickAction = attr.confirmedClick;
 	             element.bind("click",function (event) {
 	                 if ( window.confirm(msg) ) {
 	                     scope.$eval(clickAction)
 	                 }
 	             });
 	         }
 	     };
	 });

	zaa.directive("focusMe", function($timeout) {
		return {
			scope: { trigger: "=focusMe" },
			link: function(scope, element) {
				scope.$watch("trigger", function(value) {
					if (value === true) {
						element[0].focus();
						scope.trigger = false;
					}
				})
			}
		}
	});

	/**
	 * ```
	 * <a href="#" click-paste-pusher="foobar">Test</a>
	 * ```
	 */
	zaa.directive("clickPastePusher", ['$rootScope', '$compile', function($rootScope, $compile) {
		return {
			restrict: 'A',
			replace: false,
			link: function(scope, element, attrs) {
				element.bind('click', function() {
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
	zaa.directive('insertPasteListener', ['$rootScope', function($rootScope) {
		return {
			restrict: 'A',
		    link: function(scope, element, attrs) {
		    	element.bind("focus", function() {
		    		$rootScope.lastElement = element[0];
		    		var offCallFn = $rootScope.$on('insertPasteListener', function(e, val) {
		    			var domElement = $rootScope.lastElement;

				    	if (domElement != element[0] || !domElement) {
				    		return false;
				    	}

				    	$rootScope.$$listeners.insertPasteListener=[];

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

	zaa.factory('CacheReloadService', function($http, $window) {

		var service = [];

		service.reload = function() {
			$http.get("admin/api-admin-common/cache").success(function(response) {
				$window.location.reload();
			});
		}

		return service;

	});

	zaa.filter('srcbox', function() {
		return function(input, search) {
			if (!input) return input;
			if (!search) return input;
			var expected = ('' + search).toLowerCase();
			var result = {};
			angular.forEach(input, function(value, key) {
				angular.forEach(value, function(kv, kk) {
					var actual = ('' + kv).toLowerCase();
					if (actual.indexOf(expected) !== -1) {
						result[key] = value;
					}
				});
		    });
		    return result;
	    }
	});

	zaa.filter('trustAsResourceUrl', function($sce) {
	    return function(val, enabled) {
	    	if (!enabled) {
	    		return null;
	    	}
	        return $sce.trustAsResourceUrl(val);
	    };
	});

	zaa.factory("LuyaLoading", function($timeout) {

		var state = false;
		var stateMessage = null;
		var timeoutPromise = null;

		return {
			start : function(myMessage) {
				if (myMessage == undefined) {
					stateMessage = i18n['js_zaa_server_proccess'];
				} else {
					stateMessage = myMessage;
				}
				// rm previous timeouts
				$timeout.cancel(timeoutPromise);

				timeoutPromise = $timeout(function() {
					state = true;
				}, 2000);
			},
			stop : function() {
				$timeout.cancel(timeoutPromise);
				state = false;
			},
			getStateMessage : function() {
				return stateMessage;
			},
			getState : function() {
				return state;
			}
		}
	});

	zaa.factory("AdminClassService", function() {

		var service = [];

		service.vars = [];

		service.getClassSpace = function(spaceName) {
			if (service.vars.hasOwnProperty(spaceName)) {
				return service.vars[spaceName];
			}
		}

		service.setClassSpace = function(spaceName, className) {
			service.vars[spaceName] = className;
		}

		return service;
	});

	/**
	 * Example usage of luya admin modal:
	 *
	 * ```
	 * <button ng-click="modalState=!modalState">Toggle Modal</button>
     * <modal is-modal-hidden="modalState">
     * 	  <h1>Modal Container</h1>
     *    <p>Hello world!</p>
     * </modal>
     * ```
	 */
	zaa.directive("modal", function($timeout) {
		return {
			restrict: "E",
			scope: {
				isModalHidden: "="
			},
			replace: true,
			transclude: true,
			templateUrl: "modal",
		}
	});

	zaa.controller("DashboardController", function($scope) {

		$scope.date = null;

	});

	// factory.js
	zaa.factory("authInterceptor", function($rootScope, $q, AdminToastService) {
		return {
			request: function (config) {
				config.headers = config.headers || {};
				config.headers.Authorization = "Bearer " + authToken;
				config.headers['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
				return config;
			},
			responseError: function(data) {
				if (data.status == 401) {
					window.location = "admin/default/logout";
				}
				if (data.status != 422){
					AdminToastService.error("Response Error: " + data.status + " " + data.statusText, 5000);
				}
				return $q.reject(data);
			}
		};
	});


})();

// jquery helpers

/* non angular activeWindow send - testing purpose */
var activeWindowRegisterForm = function(form, callback, cb) {
	$(form).submit(function(event) {
	  event.preventDefault();
      var activeWindowHash = $("[ng-controller=\""+ngrestConfigHash+"\"]").scope().data.aw.id;
	  $.ajax({
		  url: activeWindowCallbackUrl + "?activeWindowCallback=" + callback + "&ngrestConfigHash=" + ngrestConfigHash + "&activeWindowHash=" + activeWindowHash,
		  data: $(form).serialize(),
		  type: "POST",
		  dataType: "json",
		  success: function(transport) {
			  cb.call(this, transport);
		  },
		  error: function(transport) {
			  alert("we have an async error");
		  }
		});
	});
}

var activeWindowAsyncGet = function(callback, params, cb) {
	var activeWindowHash = $("[ng-controller=\""+ngrestConfigHash+"\"]").scope().data.activeWindow.id;
	$.ajax({
		url: activeWindowCallbackUrl + "?activeWindowCallback=" + callback + "&ngrestConfigHash=" + ngrestConfigHash + "&activeWindowHash=" + activeWindowHash,
		data: params,
		type: "GET",
		dataType: "json",
		success: function(transport) {
			  cb.call(this, transport);
		  },
		  error: function(transport) {
			  alert("we have an async error");
		  }
	});
};
