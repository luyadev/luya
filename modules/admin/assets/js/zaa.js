/* zephir angular admin */

var zaa = angular.module("zaa", ['ui.router', 'ngResource', 'ui.ace', 'ngDragDrop', 'angular-loading-bar']);

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

zaa.directive('focusMe', function($timeout) {
  return {
    scope: { trigger: '=focusMe' },
    link: function(scope, element) {
      scope.$watch('trigger', function(value) {
        if(value === true) {
            element[0].focus();
            scope.trigger = false;
        }
      });
    }
  };
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