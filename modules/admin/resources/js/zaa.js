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
			})
			.state("custom", {
				url: "/template/:templateId",
				templateUrl: function($stateParams) {
					var res = $stateParams.templateId.split("-");
					return res[0] + "/" + res[1] + "/" + res[2];
				}
			})
			.state("home", {
				url: "",
				templateUrl: "admin/default/dashboard"
			});
	});
	
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
			$http.get("admin/api-admin-defaults/cache").success(function(response) {
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
	
	zaa.factory("ApiAdminLang", function($resource) {
		return $resource("admin/api-admin-lang/:id", { id: "@_id" }, {
			save: {
				method: "POST",
				isArray: false,
				headers: {"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"}
			}
		});
	});
	
	zaa.factory("AdminLangService", function(ApiAdminLang, $http) {
		var service = [];
		
		service.data = [];
		
		service.selection = [];
		
		service.toggleSelection = function(lang) {
			var exists = service.selection.indexOf(lang.short_code);
			
			if (exists == -1) {
				service.selection.push(lang.short_code);
			} else {
				/* #531: unable to deselect language, as at least 1 langauge must be activated. */
				if (service.selection.length > 1) {
					service.selection.splice(exists, 1);
				}
			}
		};
		
		service.isInSelection = function(langShortCode) {
			var exists = service.selection.indexOf(langShortCode);
			if (exists == -1) {
				return false;
			}
			return true;
		};
		
		service.load = function(forceReload) {
			if (service.data.length == 0 || forceReload !== undefined) {
				service.data = ApiAdminLang.query();
				$http.get("admin/api-admin-defaults/lang").success(function(response) {
					if (!service.isInSelection(response.short_code)) {
						service.toggleSelection(response);
					}
				});
			}
		};
		
		return service;
	});
	
	zaa.factory("ApiAdminFilter", function($resource) {
		return $resource("admin/api-admin-filter/:id", { id: "@_id" }, {
			save: {
				method: "POST",
				isArray: false,
				headers: {"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"}
			}
		});
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