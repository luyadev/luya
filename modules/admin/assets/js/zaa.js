/* zephir angular admin */

var zaa = angular.module("zaa", ['ui.router', 'ngResource', 'ui.ace', 'ngDragDrop', 'angular-loading-bar', 'flow', 'ui.bootstrap', 'ui.materialize']);

zaa.config(function ($httpProvider, $stateProvider, $controllerProvider) {
	$httpProvider.interceptors.push('authInterceptor');
	
	zaa.bootstrap = $controllerProvider;
	
	$stateProvider
		.state("default", {
			url : "/default/:moduleId",
			templateUrl : function($stateParams) {
				return "admin/template/default";
			}
		})
		.state("default.route", {
			url : '/:moduleRouteId/:controllerId/:actionId',
			templateUrl: function ($stateParams) {
                return $stateParams.moduleRouteId + '/' + $stateParams.controllerId  + '/' + $stateParams.actionId;
            }
		})
		.state("custom", {
			url : "/template/:templateId",
			templateUrl : function($stateParams) {
				var res = $stateParams.templateId.split("-");
				return res[0] + '/' + res[1] + '/' + res[2];
			}
		})
		.state("home", {
			url : '',
			templateUrl : 'admin/default/dashboard'
		})
});

zaa.directive('compileHtml', function($compile, $parse) {
	return {
		restrict: 'A',
		link: function(scope, element, attr) {
			var parsed = $parse(attr.ngBindHtml);
  
			scope.$watch(function() { return (parsed(scope) || '').toString(); }, function() {
		        $compile(element, null, -9999)(scope);  //The -9999 makes it skip directives so that we do not recompile ourselves
	        });
	    }
	};
});

zaa.directive('zaaEsc', function() {
	return function(scope, element, attrs) {
		$(document).on('keyup', function(e) {
			if (e.keyCode == 27) {
				scope.$apply(function() {
					scope.$eval(attrs.zaaEsc);
				});
			}
		})
	};
});

zaa.directive('focusMe', function($timeout) {
	return {
		scope : { trigger : '=focusMe' },
		link : function(scope, element) {
			scope.$watch('trigger', function(value) {
				if (value === true) {
					element[0].focus();
					scope.trigger = false;
				}
			})
		}
	}
});

zaa.factory('AdminService', function() {
	var service = [];
	
	service.bodyClass = '';
	
	service.addBodyClass = function(className) {
		service.bodyClass = className;
	}
	
	return service;
});

zaa.factory('AdminClassService', function() {
	
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

zaa.directive('modal', function() {
	return {
		restrict : 'E',
		scope : false,
		replace : false,
		transclude : true,
		template : function() {
			return '<div style="position:absolute; z-index:10000; background-color:#F0F0F0; left:10px; top:0px; width:80%; border:1px solid red; padding:20px; margin:40px;"><button ng-click="close()" type="button">close</button><div ng-transclude></div></div>';
		}
	}
});

/*
zaa.factory('AdminModalService', function() {
	
	var service = [];
	
	service.modalsActive = {};
	
	service.modalsHidden =  {};
	
	service.add = function(name, title, content) {
		service.modalsHidden[name] = {name : name, title : title, content : content};
	}
	
	service.show = function(name) {
		if (!service.exists(name)) {
			alert('the modal' + name + ' does not exists!');
			return;
		}
		
		if (service.isHidden(name) && !service.isActive(name)) {
			var data = service.modalsHidden[name];
			delete service.modalsHidden[name];
			service.modalsActive[name] = data;
		}
	}
	
	service.hide = function(name) {
		if (!service.exists(name)) {
			alert('the modal' + name + ' does not exists!');
			return;
		}
		
		if (!service.isHidden(name) && service.isActive(name)) {
			var data = service.modalsActive[name];
			delete service.modalsActive[name];
			service.modalsHidden[name] = data;
		}
	}
	
	service.exists = function(name) {
		if (service.isHidden(name) || service.isActive(name)) {
			return true;
		}
		
		return false;
	}
	
	service.isHidden = function(name) {
		return service.modalsHidden.hasOwnProperty(name);
	}
	
	service.isActive = function(name) {
		return service.modalsActive.hasOwnProperty(name);
	}
	
	service.get = function() {
		return service.modalsActive;
	}
	
	return service;
	
});
*/

zaa.controller("DashboardController", function($scope) {
	
	$scope.date = null;
	
})

zaa.controller("HtmlController", function($scope, AdminService) {
	
	$scope.AdminService = AdminService;
	
});

zaa.directive('onFinish', function ($timeout) {
	return {
	    restrict: 'A',
	    link: function (scope, element, attr) {
	        if (scope.$last === true) {
	            $timeout(function () {
	            	dispatchEvent(attr.onFinish);
	            });
	        }
	    }
	}
});

/**
 * event dispatcher
 */
var dispatchEvent = function(eventName) {
	var event = new Event(eventName);
	document.dispatchEvent(event);
};

/**
 * names:
 * onMenuFinish
 * onSubMenuFinish
 */
var registerEvent = function(name, cb) {
	/* verify available events */
	document.addEventListener(name, cb, false);
}

/* non angular strap send - testing purpose */
var strapRegisterForm = function(form, callback, cb) {
	$(form).submit(function(event) {
	  event.preventDefault();
	  var strapHash = $('[ng-controller="'+ngrestConfigHash+'"]').scope().data.strap.id;
	  $.ajax({
		  url: strapCallbackUrl + '?strapCallback=' + callback + '&ngrestConfigHash=' + ngrestConfigHash + '&strapHash=' + strapHash, 
		  data: $(form).serialize(),
		  type : 'POST',
		  dataType : 'json',
		  success: function(transport) {
			  cb.call(this, transport);
		  },
		  error : function(transport) {
			  alert('we have an async error');
		  }
		});
	});
}

var strapAsyncGet = function(callback, params, cb) {
	var strapHash = $('[ng-controller="'+ngrestConfigHash+'"]').scope().data.strap.id;
	
	$.ajax({
		url: strapCallbackUrl + '?strapCallback=' + callback + '&ngrestConfigHash=' + ngrestConfigHash + '&strapHash=' + strapHash,
		data : params,
		type : 'GET',
		dataType : 'json',
		success: function(transport) {
			  cb.call(this, transport);
		  },
		  error : function(transport) {
			  alert('we have an async error');
		  }
	});
};