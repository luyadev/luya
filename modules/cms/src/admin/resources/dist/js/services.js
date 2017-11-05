/**
 * all global admin services
 * 
 * controller resolve: https://github.com/johnpapa/angular-styleguide#style-y080
 * 
 * Service Inheritance:
 * 
 * 1. Service must be prefix with Service
 * 2. Service must contain a forceReload state
 * 3. Service must broadcast an event 'service:FoldersData'
 * 4. Controller integration must look like
 * 
 * ```
 * $scope.foldersData = ServiceFoldersData.data;
 *				
 * $scope.$on('service:FoldersData', function(event, data) {
 *      $scope.foldersData = data;
 * });
 *				
 * $scope.foldersDataReload = function() {
 *     return ServiceFoldersData.load(true);
 * }
 * ```
 * 
 */(function(){"use strict";zaa.config(function(resolverProvider){resolverProvider.addCallback(function(ServiceMenuData,ServiceBlocksData,ServiceLayoutsData,LuyaLoading){LuyaLoading.start();ServiceBlocksData.load();ServiceLayoutsData.load();ServiceMenuData.load().then(function(r){LuyaLoading.stop()})})});/*
block data copy stack
*/zaa.factory("ServiceBlockCopyStack",function($rootScope){var service=[];service.stack=[];service.clear=function(){service.stack=[];$rootScope.$broadcast("service:CopyStack",service.stack)};service.push=function(blockId,name){if(service.stack.length>4){service.stack.shift()}service.stack.push({blockId:blockId,name:name,event:"isServiceBlockCopyInstance"});$rootScope.$broadcast("service:CopyStack",service.stack)};return service});/*

$scope.menuData = ServiceMenuData.data;
				
$scope.$on('service:MenuData', function(event, data) {
	$scope.menuData = data;
});

$scope.menuDataReload = function() {
	return ServiceMenuData.load(true);
}
				
*/zaa.factory("ServiceMenuData",function($http,$q,$rootScope){var service=[];service.data=[];service.load=function(forceReload){return $q(function(resolve,reject){if(service.data.length>0&&forceReload!==true){resolve(service.data)}else{$http.get("admin/api-cms-menu/data-menu").then(function(response){service.data=response.data;$rootScope.$broadcast("service:MenuData",service.data);resolve(service.data)})}})};return service});/*

$scope.blocksData = ServiceBlocksData.data;
				
$scope.$on('service:BlocksData', function(event, data) {
	$scope.blocksData = data;
});

$scope.blocksDataReload = function() {
	return ServiceBlocksData.load(true);
}
				
*/zaa.factory("ServiceBlocksData",function($http,$q,$rootScope){var service=[];service.data=[];service.load=function(forceReload){return $q(function(resolve,reject){if(service.data.length>0&&forceReload!==true){resolve(service.data)}else{$http.get("admin/api-cms-admin/data-blocks").then(function(response){service.data=response.data;$rootScope.$broadcast("service:BlocksData",service.data);resolve(service.data)})}})};return service});/*

$scope.layoutsData = ServiceLayoutsData.data;
				
$scope.$on('service:BlocksData', function(event, data) {
	$scope.layoutsData = data;
});

$scope.layoutsDataReload = function() {
	return ServiceLayoutsData.load(true);
}
				
*/zaa.factory("ServiceLayoutsData",function($http,$q,$rootScope){var service=[];service.data=[];service.load=function(forceReload){return $q(function(resolve,reject){if(service.data.length>0&&forceReload!==true){resolve(service.data)}else{$http.get("admin/api-cms-admin/data-layouts").then(function(response){service.data=response.data;$rootScope.$broadcast("service:LayoutsData",service.data);resolve(service.data)})}})};return service});/*
 * CMS LIVE EDIT SERIVCE
 * 
 * $scope.liveEditMode = ServiceLiveEditMode.state
 */zaa.factory("ServiceLiveEditMode",function($rootScope){var service=[];service.state=0;service.url=null;service.toggle=function(){service.state=!service.state};service.setUrl=function(itemId,versionId){service.url=homeUrl+"preview/"+itemId+"?version="+versionId};service.changeUrl=function(itemId,versionId){if(versionId==undefined){versionId=0}service.setUrl(itemId,versionId);$rootScope.$broadcast("service:LiveEditModeUrlChange",service.url)};return service});// end of use strict
})();