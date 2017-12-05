var zaa = angular.module("zaa", ["ui.router", "dnd", "angular-loading-bar", "ngFileUpload", "ngWig", "flow", "angular.filter", "720kb.datepicker", "directive.ngColorwheel"]);

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

/**
 * i18n localisation with params.
 *
 * ```js
 * i18nParam('js_i18n_translation_name', {variable: value});
 * ```
 *
 * Translations File:
 *
 * ```php
 * 'js_i18n_translation_name' => 'Hello %variable%',
 * ```
 * @param varName
 * @param params
 * @returns
 */
function i18nParam(varName, params) {
    var varValue = i18n[varName];

    angular.forEach(params, function (value, key) {
        varValue = varValue.replace("%" + key + "%", value);
    });

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

(function () {
    "use strict";

    /* CONFIG */
    
    zaa.config(function ($httpProvider, $stateProvider, $controllerProvider, $urlMatcherFactoryProvider) {
    	
        $httpProvider.interceptors.push("authInterceptor");

        zaa.bootstrap = $controllerProvider;

        $urlMatcherFactoryProvider.strictMode(false)

        $stateProvider
            .state("default", {
                url: "/default/:moduleId",
                templateUrl: function ($stateParams) {
                    return "admin/template/default";
                }
            })
            .state("default.route", {
                url: "/:moduleRouteId/:controllerId/:actionId",
                templateUrl: function ($stateParams) {
                    return $stateParams.moduleRouteId + "/" + $stateParams.controllerId + "/" + $stateParams.actionId;
                },
                parent: 'default',
                resolve: {
                    adminServiceResolver: adminServiceResolver
                }
            })
            .state("custom", {
                url: "/template/:templateId",
                templateUrl: function ($stateParams) {
                    return $stateParams.templateId;
                },
                resolve: {
                    adminServiceResolver: adminServiceResolver,
                    resolver: function (resolver) {
                        return resolver.then;
                    },
                }
            })
            .state("home", {
                url: "",
                templateUrl: "admin/default/dashboard"
            });
    });

    /* PROVIDERS */
    
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
    zaa.provider("resolver", function () {
        var list = [];

        this.addCallback = function (callback) {
            list.push(callback);
        }

        this.$get = function ($injector, $q, $state) {
            return $q(function (resolve, reject) {
                for (var i in list) {
                    $injector.invoke(list[i]);
                }
            })
        }
    });

    /* FACTORIES */
    
    /**
     * LUYA LOADING
     */
    zaa.factory("LuyaLoading", function ($timeout) {

        var state = false;
        var stateMessage = null;
        var timeoutPromise = null;

        return {
            start: function (myMessage) {
                if (myMessage == undefined) {
                    stateMessage = i18n['js_zaa_server_proccess'];
                } else {
                    stateMessage = myMessage;
                }
                // rm previous timeouts
                $timeout.cancel(timeoutPromise);

                timeoutPromise = $timeout(function () {
                    state = true;
                }, 2000);
            },
            stop: function () {
                $timeout.cancel(timeoutPromise);
                state = false;
            },
            getStateMessage: function () {
                return stateMessage;
            },
            getState: function () {
                return state;
            }
        }
    });
    
    /**
     * Inside your Directive or Controller:
     * 
     * ```js
     * AdminClassService.setClassSpace('modalBody', 'modal-open')
     * ```
     * 
     * Inside your HTML layout file:
     * 
     * ```html
     * <div class="{{AdminClassService.getClassSpace('modalBody')}}" />
     * ```
     * 
     * In order to clear the class space afterwards:
     * 
     * ```js
     * AdminClassService.clearSpace('modalBody');
     * ```
     */
    zaa.factory("AdminClassService", function () {

        var service = [];

        service.vars = {};

        service.getClassSpace = function (spaceName) {
            if (service.vars.hasOwnProperty(spaceName)) {
                return service.vars[spaceName];
            }
        };

        service.hasClassSpace = function(spaceName) {
        	 if (service.vars.hasOwnProperty(spaceName)) {
        		 return true;
        	 }
        	 
        	 return false;
        };
        
        service.setClassSpace = function (spaceName, className) {
            service.vars[spaceName] = className;
        };
        
        service.clearSpace = function(spaceName) {
        	if (service.vars.hasOwnProperty(spaceName)) {
        		service.vars[spaceName] = null;
        	}
        };
        
        service.removeSpace = function(spaceName) {
        	if (service.hasClassSpace(spaceName)) {
        		delete service.vars[spaceName];
        	}
        };

        service.stack = 0;
        
        service.modalStackPush = function() {
        	service.stack += 1;
        };
        
        service.modalStackRemove = function() {
        	service.stack -= 1;
        };
        
        service.modalStackRemoveAll = function() {
        	service.stack = 0;
        };
        
        service.modalStackIsEmpty = function() {
        	if (service.stack == 0) {
        		return true;
        	}
        	
        	return false;
        };
        
        return service;
    });
    
    zaa.factory('CacheReloadService', function ($http, $window) {

        var service = [];

        service.reload = function () {
            $http.get("admin/api-admin-common/cache").then(function (response) {
                $window.location.reload();
            });
        }

        return service;
    });
    
    zaa.factory("authInterceptor", function ($rootScope, $q, AdminToastService, AdminDebugBar) {
        return {
            request: function (config) {
            	if (!config.hasOwnProperty('ignoreLoadingBar')) {
            		config.debugId = AdminDebugBar.pushRequest(config);
            	}
                config.headers = config.headers || {};
                config.headers.Authorization = "Bearer " + $rootScope.luyacfg.authToken;
                config.headers['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
                
                return config || $q.when(config);
            },
            response: function(config) {
            	if (!config.hasOwnProperty('ignoreLoadingBar')) {
            		AdminDebugBar.pushResponse(config);
            	}
            	
            	return config || $q.when(config);
            },
            responseError: function (data) {
                if (data.status == 401 || data.status == 403 || data.status == 405) {
                    window.location = "admin/default/logout";
                } else if (data.status != 422) {
                	var message = data.data.hasOwnProperty('message');
                	if (message) {
                		AdminToastService.error(data.data.message, 10000);
                	} else {
                		AdminToastService.error("Response Error: " + data.status + " " + data.statusText, 10000);
                	}
                    
                }
                
                return $q.reject(data);
            }
        };
    });

})();