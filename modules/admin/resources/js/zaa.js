var zaa = angular.module("zaa", ["ui.router", "ngResource", "ngDragDrop", "angular-loading-bar", "ngFileUpload", "ngWig", "slugifier"]);

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
	
	zaa.directive("zaaEsc", function() {
		return function(scope, element, attrs) {
			$(document).on("keyup", function(e) {
				if (e.keyCode == 27) {
					scope.$apply(function() {
						scope.$eval(attrs.zaaEsc);
					});
				}
			})
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
	
	zaa.factory("LuyaLoading", function($timeout) {
	
		var state = false;
		var stateMessage = null;
		var timeoutPromise = null;
		
		return {
			start : function(myMessage) {
				if (myMessage == undefined) {
					stateMessage = 'Der Server verarbeitet Ihre Daten. Bitte warten Sie einen Augenblick.';
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
	
	zaa.directive("modal", function($timeout) {
		return {
			restrict: "E",
			scope: {
				isModalHidden: "="
			},
			replace: true,
			transclude: true,
			templateUrl: "modal"
		}
	});
	
	zaa.controller("DashboardController", function($scope) {
		
		$scope.date = null;
		
	});
	
	// factory.js
	zaa.factory("authInterceptor", function($rootScope, $q) {
		return {
			request: function (config) {
				config.headers = config.headers || {};
				config.headers.Authorization = "Bearer " + authToken;
				return config;
			},
			responseError: function(data) {
				if (data.status == 401) {
					window.location = "admin/default/logout";
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