(function(){"use strict";// directive.js
zaa.directive("menuDropdown",function(ServiceMenuData){return{restrict:"E",scope:{navId:"="},controller:function($scope){$scope.changeModel=function(data){$scope.navId=data.id};$scope.menuData=ServiceMenuData.data;$scope.$on("service:MenuData",function(event,data){$scope.menuData=data});function init(){if($scope.menuData.length==0){ServiceMenuData.load()}}for(var container in $scope.menuData.containers){$scope.menuData.containers[container].isHidden=false}$scope.toggler=true;init()},template:function(){return"<div class=\"menu-dropdown-category\">"+"<b class=\"menu-dropdown-toggle-all\" ng-click=\"toggler=!toggler\"><i class=\"material-icons\" ng-if=\"!toggler\">keyboard_arrow_down</i><i class=\"material-icons\" ng-if=\"toggler\">keyboard_arrow_right</i> <span>Toggle all</span></b><br />"+"<div class=\"menu-dropdown-container\" ng-show=\"toggler\">"+"<ul class=\"treeview treeview-chooser\" ng-show=\"toggler\">"+"<li class=\"treeview-container\" ng-repeat=\"container in menuData.containers\" >"+"<div class=\"treeview-label treeview-label-container\" ng-click=\"container.isHidden=!container.isHidden\">"+"<span class=\"treeview-icon treeview-icon-collapse\">"+"<i class=\"material-icons\" ng-show=\"container.isHidden\">keyboard_arrow_down</i>"+"<i class=\"material-icons\" ng-show=\"!container.isHidden\">keyboard_arrow_right</i>"+"</span>"+"<span class=\"treeview-link\">"+"<span class=\"google-chrome-font-offset-fix\">{{container.name}}</span>"+"</span>"+"</div>"+"<ul class=\"treeview-items treeview-items-lvl1\" ng-hide=\"container.isHidden\">"+"<li class=\"treeview-item treeview-item-lvl1\" ng-class=\"{'treeview-item-has-children' : (menuData.items | menuparentfilter:container.id:0).length}\" ng-repeat=\"data in menuData.items | menuparentfilter:container.id:0\" ng-include=\"'menuDropdownReverse'\"></li>"+"</ul>"+"</li>"+"</ul>"+"</div>"+"<div>"}}});zaa.directive("zaaCmsPage",function($compile){return{restrict:"E",scope:{"model":"=","options":"=","label":"@label","i18n":"@i18n","id":"@fieldid","name":"@fieldname"},template:function(){return"<div class=\"input input--image-upload\" ng-class=\"{'input--hide-label': i18n}\">"+"<label class=\"input__label\">{{label}}</label>"+"<div class=\"input__field-wrapper\">"+"<menu-dropdown class=\"menu-dropdown\" nav-id=\"model\" />"+"</div>"+"</div>"}}});zaa.directive("showInternalRedirection",function(){return{restrict:"E",scope:{navId:"="},controller:function($scope,$http,$state){$scope.$watch("navId",function(n){if(n){$http.get("admin/api-cms-navitem/get-nav-item-path",{params:{navId:$scope.navId}}).then(function(response){$scope.path=response.data});$http.get("admin/api-cms-navitem/get-nav-container-name",{params:{navId:$scope.navId}}).then(function(response){$scope.container=response.data})}});$scope.goTo=function(navId){$state.go("custom.cmsedit",{navId:navId})}},template:function(){return"<a ng-click=\"goTo(navId)\" style=\"cursor:pointer\">{{path}}</a> in {{container}}"}}});zaa.directive("updateFormPage",function(){return{restrict:"EA",scope:{data:"="},templateUrl:"updateformpage.html",controller:function($scope){$scope.parent=$scope.$parent.$parent;$scope.isEditAvailable=function(){return $scope.parent.item.nav_item_type==1}}}});zaa.directive("updateFormModule",function(){return{restrict:"EA",scope:{data:"="},templateUrl:"updateformmodule.html",controller:function($scope,$http){$scope.modules=[];$http.get("admin/api-admin-common/data-modules").then(function(response){$scope.modules=response.data})}}});zaa.directive("updateFormRedirect",function(){return{restrict:"EA",scope:{data:"="},templateUrl:"updateformredirect.html",controller:function($scope){$scope.$watch(function(){return $scope.data},function(n,o){if(angular.isArray(n)){$scope.data={}}})}}});zaa.directive("createForm",function(){return{restrict:"EA",scope:{data:"="},templateUrl:"createform.html",controller:function($scope,$http,$filter,ServiceMenuData,Slug,ServiceLanguagesData,AdminToastService){$scope.error=[];$scope.success=false;$scope.controller=$scope.$parent;$scope.menuData=ServiceMenuData.data;$scope.$on("service:MenuData",function(event,data){$scope.menuData=data});$scope.menuDataReload=function(){return ServiceMenuData.load(true)};function initializer(){$scope.menu=$scope.menuData.items;$scope.navcontainers=$scope.menuData.containers}initializer();$scope.data.nav_item_type=1;$scope.data.parent_nav_id=0;$scope.data.is_draft=0;$scope.data.nav_container_id=1;$scope.languagesData=ServiceLanguagesData.data;$scope.$on("service:LanguagesData",function(event,data){$scope.languagesData=data});$scope.data.lang_id=parseInt($filter("filter")($scope.languagesData,{"is_default":"1"},true)[0].id);$scope.navitems=[];$scope.$watch(function(){return $scope.data.nav_container_id},function(n,o){if(n!==undefined&&n!==o){$scope.data.parent_nav_id=0;$scope.navitems=$scope.menu[n]["__items"]}});$scope.aliasSuggestion=function(){$scope.data.alias=Slug.slugify($scope.data.title)};$scope.$watch("data.alias",function(n,o){if(n!=o&&n!=null){$scope.data.alias=Slug.slugify(n)}});$scope.exec=function(){$scope.controller.save().then(function(response){$scope.menuDataReload();$scope.success=true;$scope.error=[];$scope.data.title=null;$scope.data.alias=null;if($scope.data.isInline){$scope.$parent.$parent.getItem($scope.data.lang_id,$scope.data.nav_id)}AdminToastService.success(i18n["view_index_page_success"],4000)},function(reason){angular.forEach(reason,function(value,key){AdminToastService.error(value[0],2000)});$scope.error=reason})}}}});zaa.directive("createFormPage",function(ServiceLayoutsData,ServiceMenuData){return{restrict:"EA",scope:{data:"="},templateUrl:"createformpage.html",controller:function($scope){$scope.data.use_draft=0;$scope.data.layout_id=0;$scope.data.from_draft_id=0;// layoutsData
$scope.layoutsData=ServiceLayoutsData.data;$scope.$on("service:BlocksData",function(event,data){$scope.layoutsData=data});// menuData
$scope.menuData=ServiceMenuData.data;$scope.$on("service:MenuData",function(event,data){$scope.menuData=data});function init(){$scope.drafts=$scope.menuData.drafts;$scope.layouts=$scope.layoutsData}init();$scope.save=function(){$scope.$parent.exec()}}}});zaa.directive("createFormModule",function($http){return{restrict:"EA",scope:{data:"="},templateUrl:"createformmodule.html",controller:function($scope){$scope.modules=[];$http.get("admin/api-admin-common/data-modules").then(function(response){$scope.modules=response.data});$scope.save=function(){$scope.$parent.exec()}}}});zaa.directive("createFormRedirect",function(){return{restrict:"EA",scope:{data:"="},templateUrl:"createformredirect.html",controller:function($scope){$scope.save=function(){$scope.$parent.exec()}}}});// factory.js
zaa.factory("PlaceholderService",function(){var service=[];service.status=1;/* 1 = showplaceholders; 0 = hide placeholders */service.delegate=function(status){service.status=status};return service});// layout.js
zaa.config(function($stateProvider,resolverProvider){$stateProvider.state("custom.cmsedit",{url:"/update/:navId",templateUrl:"cmsadmin/page/update"}).state("custom.cmsadd",{url:"/create",templateUrl:"cmsadmin/page/create"}).state("custom.cmsdraft",{url:"/drafts",templateUrl:"cmsadmin/page/drafts"})});zaa.controller("DraftsController",function($scope,$state,ServiceMenuData){$scope.menuData=ServiceMenuData.data;$scope.$on("service:MenuData",function(event,data){$scope.menuData=data});$scope.go=function(navId){$state.go("custom.cmsedit",{navId:navId})}});/* controllers */zaa.controller("ConfigController",function($scope,$http,AdminToastService){$scope.data={};$http.get("admin/api-cms-admin/config").then(function(response){$scope.data=response.data});$scope.save=function(){$http.post("admin/api-cms-admin/config",$scope.data).then(function(response){AdminToastService.success(i18n["js_config_update_success"],4000)})}});zaa.controller("PageVersionsController",function($scope,$http,ServiceLayoutsData,AdminToastService){/**
		 * @var object $typeData From parent scope controller NavItemController
		 * @var object $item From parent scope controller NavItemController
		 * @var string $versionName From ng-model
		 * @var integer $fromVersionPageId From ng-model the version copy from or 0 = new empty/blank version
		 * @var integer $versionLayoutId From ng-model, only if fromVersionPageId is 0
 		 */var headers={"headers":{"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}};// layoutsData
$scope.layoutsData=ServiceLayoutsData.data;$scope.$on("service:LayoutsData",function(event,data){$scope.layoutsData=data});$scope.closeCreateModal=function(){$scope.createVersionModalState=true};$scope.editVersionModalState=true;$scope.closeEditModal=function(){$scope.editVersionModalState=true};$scope.openEditModal=function(){$scope.editVersionModalState=false};$scope.toggleVersionEdit=function(versionId){$scope.$parent.switchVersion(versionId);$scope.openEditModal()};$scope.toggleRemoveVersion=function(versionid){$scope.$parent.switchVersion(versionid);$scope.$parent.removeCurrentVersion()};// controller logic
$scope.changeVersionLayout=function(versionItem){$http.post("admin/api-cms-navitem/change-page-version-layout",$.param({"pageItemId":versionItem.id,"layoutId":versionItem.layout_id,"alias":versionItem.version_alias}),headers).then(function(response){$scope.refreshForce();$scope.closeEditModal();AdminToastService.success(i18n["js_version_update_success"],4000)})};$scope.createNewVersionSubmit=function(data){if(data==undefined){AdminToastService.error(i18n["js_version_error_empty_fields"],4000);return null}if(data.copyExistingVersion){data.versionLayoutId=0}$http.post("admin/api-cms-navitem/create-page-version",$.param({"layoutId":data.versionLayoutId,"navItemId":$scope.item.id,"name":data.versionName,"fromPageId":data.fromVersionPageId}),headers).then(function(response){if(response.data.error){AdminToastService.error(i18n["js_version_error_empty_fields"],4000);return null}$scope.refreshForce();$scope.closeCreateModal();AdminToastService.success(i18n["js_version_create_success"],4000)})}});zaa.controller("CopyPageController",function($scope,$http,AdminToastService,Slug){var headers={"headers":{"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}};$scope.$on("deletedNavItem",function(){$scope.isOpen=false;$scope.itemSelection=false;$scope.selection=0});$scope.NavItemController=$scope.$parent;$scope.navId=0;$scope.items=null;$scope.isOpen=false;$scope.itemSelection=false;$scope.selection=0;$scope.select=function(item){$scope.selection=item.id;$scope.itemSelection=angular.copy(item)};$scope.aliasSuggestion=function(){$scope.itemSelection.alias=Slug.slugify($scope.itemSelection.title)};$scope.loadItems=function(){$scope.navId=$scope.NavItemController.NavController.navData.id;$http.get("admin/api-cms-nav/find-nav-items",{params:{navId:$scope.navId}}).then(function(response){$scope.items=response.data;$scope.isOpen=true})};$scope.save=function(){$scope.itemSelection["toLangId"]=$scope.NavItemController.lang.id;$http.post("admin/api-cms-nav/create-from-page",$.param($scope.itemSelection),headers).then(function(response){if(response.data){AdminToastService.success(i18n["js_added_translation_ok"],3000);$scope.NavItemController.refresh()}else{AdminToastService.error(i18n["js_added_translation_error"],5000)}})}});zaa.controller("DropNavController",function($scope,$http,ServiceMenuData,AdminToastService){$scope.droppedNavItem=null;$scope.showVersionList=false;$scope.errorMessageOnDuplicateAlias=function(response){AdminToastService.error(i18nParam("js_page_add_exists",{title:response.success.title,id:response.success.nav_id}),5000)};$scope.onBeforeDrop=function($event,$ui){var itemid=$($event.target).data("itemid");$http.get("admin/api-cms-navitem/move-before",{params:{moveItemId:$scope.droppedNavItem.id,droppedBeforeItemId:itemid}}).then(function(r){ServiceMenuData.load(true)},function(r){$scope.errorMessageOnDuplicateAlias(r.data);ServiceMenuData.load(true)})};$scope.onAfterDrop=function($event,$ui){var itemid=$($event.target).data("itemid");$http.get("admin/api-cms-navitem/move-after",{params:{moveItemId:$scope.droppedNavItem.id,droppedAfterItemId:itemid}}).then(function(r){ServiceMenuData.load(true)},function(r){$scope.errorMessageOnDuplicateAlias(r.data);ServiceMenuData.load(true)})};$scope.onChildDrop=function($event,$ui){var itemid=$($event.target).data("itemid");$http.get("admin/api-cms-navitem/move-to-child",{params:{moveItemId:$scope.droppedNavItem.id,droppedOnItemId:itemid}}).then(function(r){ServiceMenuData.load(true)},function(r){$scope.errorMessageOnDuplicateAlias(r.data);ServiceMenuData.load(true)})};$scope.onEmptyDrop=function($event,$ui){var itemid=$($event.target).data("itemid");$http.get("admin/api-cms-navitem/move-to-container",{params:{moveItemId:$scope.droppedNavItem.id,droppedOnCatId:itemid}}).then(function(r){ServiceMenuData.load(true)},function(r){$scope.errorMessageOnDuplicateAlias(r.data);ServiceMenuData.load(true)})}});zaa.filter("menuparentfilter",function(){return function(input,containerId,parentNavId){var result=[];angular.forEach(input,function(value,key){if(value.parent_nav_id==parentNavId&&value.nav_container_id==containerId){result.push(value)}});return result}});zaa.filter("menuchildfilter",function(){return function(input,containerId,parentNavId){var returnValue=false;angular.forEach(input,function(value,key){if(!returnValue){if(value.id==parentNavId&&value.nav_container_id==containerId){returnValue=value}}});return returnValue}});/*
	zaa.controller("CmsLiveEdit", function($scope, ServiceLiveEditMode) {

		$scope.display = 0;

		$scope.url = homeUrl;

		$scope.$watch(function() { return ServiceLiveEditMode.state }, function(n, o) {
			$scope.display = n;
		});

		$scope.$on('service:LiveEditModeUrlChange', function(event, url) {
			var d = new Date();
			var n = d.getTime();
			$scope.url = url + '&' + n;
		});

	});
	*/zaa.controller("CmsMenuTreeController",function($scope,$state,$http,$filter,ServiceMenuData,ServiceLiveEditMode){// live edit service
$scope.liveEditState=0;$scope.$watch("liveEditStateToggler",function(n){ServiceLiveEditMode.state=n});// menu Data
$scope.menuData=ServiceMenuData.data;$scope.$on("service:MenuData",function(event,data){$scope.menuData=data});$scope.menuDataReload=function(){return ServiceMenuData.load(true)};// controller logic
$scope.dropItem=function(drag,drop,pos){if(pos=="bottom"){var api="admin/api-cms-navitem/move-after";var params={moveItemId:drag.id,droppedAfterItemId:drop.id}}else if(pos=="top"){var api="admin/api-cms-navitem/move-before";var params={moveItemId:drag.id,droppedBeforeItemId:drop.id}}else if(pos=="middle"){var api="admin/api-cms-navitem/move-to-child";var params={moveItemId:drag.id,droppedOnItemId:drop.id}}$http.get(api,{params:params}).then(function(success){ServiceMenuData.load(true)},function(error){console.log(error);console.log("throw error message errorMessageOnDuplicateAlias");ServiceMenuData.load(true)});/*
			$http.get(api, { params : { moveItemId : $scope.droppedNavItem.id, droppedBeforeItemId : itemid }}).then(function(r) {
				ServiceMenuData.load(true);
			}, function(r) {
				$scope.errorMessageOnDuplicateAlias(r.data);
				ServiceMenuData.load(true);
			});
			*//*
			$http.get('admin/api-cms-navitem/move-before', { params : { moveItemId : $scope.droppedNavItem.id, droppedBeforeItemId : itemid }}).then(function(r) {
				ServiceMenuData.load(true);
			}, function(r) {
				$scope.errorMessageOnDuplicateAlias(r.data);
				ServiceMenuData.load(true);
			});
			 $scope.onBeforeDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			$http.get('admin/api-cms-navitem/move-to-child', { params : { moveItemId : $scope.droppedNavItem.id, droppedBeforeItemId : itemid }}).then(function(r) {
				ServiceMenuData.load(true);
			}, function(r) {
				$scope.errorMessageOnDuplicateAlias(r.data);
				ServiceMenuData.load(true);
			});
	    }

	    $scope.onAfterDrop = function($event, $ui) {
	    	var itemid = $($event.target).data('itemid');
			$http.get('admin/api-cms-navitem/move-after', { params : { moveItemId : $scope.droppedNavItem.id, droppedAfterItemId : itemid }}).then(function(r) {
				ServiceMenuData.load(true);
			}, function(r) {
				$scope.errorMessageOnDuplicateAlias(r.data);
				ServiceMenuData.load(true);
			});
	    }

			*/};$scope.validItem=function(hover,draged){if(hover.id==draged.id){return false}$scope.rritems=[];$scope.recursivItemValidity(draged.nav_container_id,draged.id);if($scope.rritems.indexOf(hover.id)==-1){return true}return false};$scope.rritems=[];$scope.recursivItemValidity=function(containerId,parentNavId){var items=$filter("menuparentfilter")($scope.menuData.items,containerId,parentNavId);angular.forEach(items,function(item){$scope.rritems.push(item.id);$scope.recursivItemValidity(containerId,item.id)})};$scope.toggleItem=function(data){if(data.toggle_open==undefined){data["toggle_open"]=1}else{data["toggle_open"]=!data.toggle_open}$http.post("admin/api-cms-nav/tree-history",{data:data},{ignoreLoadingBar:true})};$scope.go=function(data){ServiceLiveEditMode.changeUrl(data.nav_item_id,0);$state.go("custom.cmsedit",{navId:data.id})};$scope.showDrag=0;$scope.isCurrentElement=function(data){if(data!==null&&$state.params.navId==data.id){return true}return false};$scope.hiddenCats=[];$scope.$watch("menuData",function(n,o){$scope.hiddenCats=n.hiddenCats});$scope.toggleCat=function(catId){if(catId in $scope.hiddenCats){$scope.hiddenCats[catId]=!$scope.hiddenCats[catId]}else{$scope.hiddenCats[catId]=1}$http.post("admin/api-cms-nav/save-cat-toggle",{catId:catId,state:$scope.hiddenCats[catId]},{ignoreLoadingBar:true})};$scope.toggleIsHidden=function(catId){if($scope.hiddenCats==undefined){return false}if(catId in $scope.hiddenCats){if($scope.hiddenCats[catId]==1){return true}}return false}});// create.js
zaa.controller("CmsadminCreateController",function($scope,$q,$http){$scope.data={};$scope.data.isInline=false;$scope.save=function(){var headers={"headers":{"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}};return $q(function(resolve,reject){if($scope.data.nav_item_type==1){$http.post("admin/api-cms-nav/create-page",$.param($scope.data),headers).then(function(response){resolve(response.data)},function(response){reject(response.data)})}if($scope.data.nav_item_type==2){$http.post("admin/api-cms-nav/create-module",$.param($scope.data),headers).then(function(response){resolve(response.data)},function(response){reject(response.data)})}if($scope.data.nav_item_type==3){$http.post("admin/api-cms-nav/create-redirect",$.param($scope.data),headers).then(function(response){resolve(response.data)},function(response){reject(response.data)})}})}});zaa.controller("CmsadminCreateInlineController",function($scope,$q,$http){$scope.data={nav_id:$scope.$parent.NavController.id};$scope.data.isInline=true;$scope.save=function(){$scope.data.lang_id=$scope.lang.id;var headers={"headers":{"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}};return $q(function(resolve,reject){if($scope.data.nav_item_type==1){$http.post("admin/api-cms-nav/create-page-item",$.param($scope.data),headers).then(function(response){resolve(response.data)},function(response){reject(response.data)})}if($scope.data.nav_item_type==2){$http.post("admin/api-cms-nav/create-module-item",$.param($scope.data),headers).then(function(response){resolve(response.data)},function(response){reject(response.data)})}if($scope.data.nav_item_type==3){$http.post("admin/api-cms-nav/create-redirect-item",$.param($scope.data),headers).then(function(response){resolve(response.data)},function(response){reject(response.data)})}})}});// update.js
zaa.controller("NavController",function($scope,$filter,$stateParams,$http,LuyaLoading,PlaceholderService,ServicePropertiesData,ServiceMenuData,ServiceLanguagesData,ServiceLiveEditMode,AdminToastService,AdminClassService,AdminLangService){$scope.displayLiveContainer=false;$scope.liveUrl=homeUrl;$scope.$watch(function(){return ServiceLiveEditMode.state},function(n,o){$scope.displayLiveContainer=n});$scope.$on("service:LiveEditModeUrlChange",function(event,url){var d=new Date;var n=d.getTime();$scope.liveUrl=url+"&"+n});$scope.AdminLangService=AdminLangService;/* service AdminPropertyService inheritance */$scope.propertiesData=ServicePropertiesData.data;$scope.$on("service:PropertiesData",function(event,data){$scope.propertiesData=data});/* service ServiceMenuData inheritance */$scope.menuData=ServiceMenuData.data;$scope.$on("service:MenuData",function(event,data){$scope.menuData=data});$scope.menuDataReload=function(){return ServiceMenuData.load(true)};/* service ServiceLangaugesData inheritance */$scope.languagesData=ServiceLanguagesData.data;$scope.$on("service:LanguagesData",function(event,data){$scope.languagesData=data});/* placeholders toggler service */$scope.PlaceholderService=PlaceholderService;$scope.placeholderState=$scope.PlaceholderService.status;$scope.$watch("placeholderState",function(n,o){if(n!==o&&n!==undefined){$scope.PlaceholderService.delegate(n)}});/* sidebar logic */$scope.sidebar=false;$scope.enableSidebar=function(){$scope.sidebar=true};$scope.toggleSidebar=function(){$scope.sidebar=!$scope.sidebar};/* app logic */$scope.showActions=1;$scope.id=parseInt($stateParams.navId);$scope.isDeleted=false;$scope.AdminClassService=AdminClassService;$scope.propValues={};$scope.hasValues=false;$scope.bubbleParents=function(parentNavId,containerId){var item=$filter("menuchildfilter")($scope.menuData.items,containerId,parentNavId);if(item){item.toggle_open=1;$scope.bubbleParents(item.parent_nav_id,item.nav_container_id)}};$scope.createDeepPageCopy=function(){$http.post("admin/api-cms-nav/deep-page-copy",{navId:$scope.id}).then(function(response){$scope.menuDataReload();AdminToastService.success(i18n["js_page_create_copy_success"],4000);$scope.showActions=1})};$scope.loadNavProperties=function(){$http.get("admin/api-cms-nav/get-properties",{params:{navId:$scope.id}}).then(function(response){for(var i in response.data){var d=response.data[i];$scope.propValues[d.admin_prop_id]=d.value;$scope.hasValues=true}})};$scope.togglePropMask=function(){$scope.showPropForm=!$scope.showPropForm};$scope.showPropForm=false;$scope.storePropValues=function(){var headers={"headers":{"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}};$http.post("admin/api-cms-nav/save-properties?navId="+$scope.id,$.param($scope.propValues),headers).then(function(response){AdminToastService.success(i18n["js_page_property_refresh"],4000);$scope.loadNavProperties();$scope.showPropForm=false})};$scope.trash=function(){AdminToastService.confirm(i18n["js_page_confirm_delete"],function($timeout,$toast){$http.get("admin/api-cms-nav/delete",{params:{navId:$scope.id}}).then(function(response){$scope.isDeleted=true;$scope.menuDataReload().then(function(){$toast.close()})},function(response){AdminToastService.error(i18n["js_page_delete_error_cause_redirects"],5000)})})};$scope.isDraft=false;$scope.submitNavForm=function(){$http.post("admin/api-cms-nav/update?id="+$scope.navData.id,{layout_file:$scope.navData.layout_file}).then(function(response){AdminToastService.success(i18nParam("js_page_update_layout_save_success"),3000)},function(response){angular.forEach(response.data,function(value){AdminToastService.error(value.message,4000)})})};function initializer(){$scope.navData=$filter("filter")($scope.menuData.items,{id:$scope.id},true)[0];if($scope.navData==undefined){$scope.isDraft=true}else{$scope.loadNavProperties();/* properties --> */$scope.$watch(function(){return $scope.navData.is_offline},function(n,o){if(n!==o&&n!==undefined){$http.get("admin/api-cms-nav/toggle-offline",{params:{navId:$scope.navData.id,offlineStatus:n}}).then(function(response){if($scope.navData.is_offline==1){AdminToastService.info(i18nParam("js_state_offline",{title:$scope.navData.title}),2000)}else{AdminToastService.info(i18nParam("js_state_online",{title:$scope.navData.title}),2000)}})}});$scope.$watch(function(){return $scope.navData.is_hidden},function(n,o){if(n!==o&&n!==undefined){$http.get("admin/api-cms-nav/toggle-hidden",{params:{navId:$scope.navData.id,hiddenStatus:n}}).then(function(response){if($scope.navData.is_hidden==1){AdminToastService.info(i18nParam("js_state_hidden",{title:$scope.navData.title}),2000)}else{AdminToastService.info(i18nParam("js_state_visible",{title:$scope.navData.title}),2000)}})}});$scope.$watch(function(){return $scope.navData.is_home},function(n,o){if(n!==o&&n!==undefined){$http.get("admin/api-cms-nav/toggle-home",{params:{navId:$scope.navData.id,homeState:n}}).then(function(response){$scope.menuDataReload().then(function(){if($scope.navData.is_home==1){AdminToastService.info(i18nParam("js_state_is_home",{title:$scope.navData.title}),2000)}else{AdminToastService.info(i18nParam("js_state_is_not_home",{title:$scope.navData.title}),2000)}})})}})}}initializer()});/**
	 * @param $scope.lang from ng-repeat
	 */zaa.controller("NavItemController",function($scope,$http,$timeout,Slug,ServiceMenuData,AdminLangService,AdminToastService,ServiceLiveEditMode){$scope.loaded=false;$scope.itemSettingsOverlay=true;$scope.NavController=$scope.$parent;$scope.liveEditState=false;$scope.$watch(function(){return ServiceLiveEditMode.state},function(n,o){$scope.liveEditState=n});$scope.openLiveUrl=function(id,versionId){ServiceLiveEditMode.changeUrl(id,versionId)};$scope.loadLiveUrl=function(){ServiceLiveEditMode.changeUrl($scope.item.id,$scope.currentPageVersion)};// serviceMenuData inheritance
$scope.menuDataReload=function(){return ServiceMenuData.load(true)};$scope.$on("service:LoadLanguage",function(event,data){if(!$scope.loaded){$scope.refresh()}});// properties:
$scope.isTranslated=false;$scope.item=[];$scope.itemCopy=[];$scope.settings=false;$scope.typeDataCopy=[];$scope.typeData=[];$scope.container=[];$scope.currentVersionInformation=null;$scope.errors=[];$scope.homeUrl=homeUrl;$scope.currentPageVersion=0;$scope.trashItem=function(){if($scope.lang.is_default==0){AdminToastService.confirm(i18n["js_page_confirm_delete"],function($timeout,$toast){$http.get("admin/api-cms-navitem/delete",{params:{navItemId:$scope.item.id}}).then(function(response){$scope.menuDataReload().then(function(){$scope.isTranslated=false;$scope.item=[];$scope.itemCopy=[];$scope.settings=false;$scope.typeDataCopy=[];$scope.typeData=[];$scope.container=[];$scope.currentVersionInformation=null;$scope.errors=[];$scope.currentPageVersion=0;$scope.$broadcast("deletedNavItem");$toast.close()})},function(response){AdminToastService.error(i18n["js_page_delete_error_cause_redirects"],5000)})})}};$scope.reset=function(){$scope.itemCopy=angular.copy($scope.item);if($scope.item.nav_item_type==1){$scope.typeDataCopy=angular.copy({"nav_item_type_id":$scope.item.nav_item_type_id})}else{$scope.typeDataCopy=angular.copy($scope.typeData)}};$scope.updateNavItemData=function(itemCopy,typeDataCopy){$scope.errors=[];var headers={"headers":{"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}};var navItemId=itemCopy.id;typeDataCopy.title=itemCopy.title;typeDataCopy.alias=itemCopy.alias;typeDataCopy.title_tag=itemCopy.title_tag;typeDataCopy.description=itemCopy.description;typeDataCopy.keywords=itemCopy.keywords;$http.post("admin/api-cms-navitem/update-page-item?navItemId="+navItemId+"&navItemType="+itemCopy.nav_item_type,$.param(typeDataCopy),headers).then(function successCallback(response){if(itemCopy.nav_item_type!==1){$scope.currentPageVersion=0}$scope.loaded=false;AdminToastService.success(i18nParam("js_page_item_update_ok",{"title":itemCopy.title}),2000);$scope.menuDataReload();$scope.refresh();$scope.toggleSettings()},function errorCallback(response){$scope.errors=response.data})};$scope.toggleSettings=function(){$scope.reset();$scope.settings=!$scope.settings};$scope.$watch("itemCopy.alias",function(n,o){if(n!=o&&n!=null){$scope.itemCopy.alias=Slug.slugify(n)}});$scope.removeCurrentVersion=function(){// {alias: $scope.currentVersionInformation.version_alias}
AdminToastService.confirm(i18nParam("js_version_delete_confirm",{alias:$scope.currentVersionInformation.version_alias}),function($toast,$http){$http.post("admin/api-cms-navitem/remove-page-version",{pageId:$scope.currentVersionInformation.id}).then(function(response){var aliasName=$scope.currentVersionInformation.version_alias;$scope.refreshForce();$toast.close();AdminToastService.success(i18nParam("js_version_delete_confirm_success",{alias:aliasName}),5000)})})};$scope.getItem=function(langId,navId){$http({url:"admin/api-cms-navitem/nav-lang-item",method:"GET",params:{langId:langId,navId:navId}}).then(function(response){if(response.data){if(!response.data.error){$scope.item=response.data["item"];$scope.typeData=response.data["typeData"];$scope.isTranslated=true;$scope.reset();if(!response.data["nav"].is_draft){$scope.NavController.bubbleParents($scope.NavController.navData.parent_nav_id,$scope.NavController.navData.nav_container_id);if($scope.item.nav_item_type==1){if($scope.currentPageVersion==0){$scope.currentPageVersion=response.data.item.nav_item_type_id}if(response.data.item.nav_item_type_id in response.data.typeData){$scope.currentVersionInformation=response.data.typeData[$scope.currentPageVersion];$scope.container=response.data.typeData[$scope.currentPageVersion]["contentAsArray"]}}}}}$scope.loaded=true})};$scope.switchVersion=function(pageVersionid){$scope.container=$scope.typeData[pageVersionid]["contentAsArray"];$scope.currentVersionInformation=$scope.typeData[pageVersionid];$scope.currentPageVersion=pageVersionid;$scope.loadLiveUrl()};$scope.refreshForce=function(){$scope.getItem($scope.lang.id,$scope.NavController.id)};$scope.refresh=function(){if(AdminLangService.isInSelection($scope.lang.short_code)){$scope.getItem($scope.lang.id,$scope.NavController.id)}};/**
		 * Refresh the current layout container blocks.
		 * 
		 * After successfull api response all cms layout are foreach and the values are passed to revPlaceholders() method.
		 */$scope.refreshNested=function(prevId,placeholderVar){$http({url:"admin/api-cms-navitem/reload-placeholder",method:"GET",params:{navItemPageId:$scope.currentPageVersion,prevId:prevId,placeholderVar:placeholderVar}}).then(function(response){ServiceLiveEditMode.changeUrl($scope.item.id,$scope.currentPageVersion);angular.forEach($scope.container.__placeholders,function(placeholder){$scope.revPlaceholders(placeholder,prevId,placeholderVar,response.data)})})};/**
		 * The revPlaceholders method goes trourgh the new row/col (grid) system container json layout where:
		 * 
		 * rows[][1] = col left
		 * rows[][2] = col right
		 * 
		 * Where a layout have at least on row which can have cols inside. So there revPlaceholders method goes trough the cols
		 * and check if the col is equal the given col to replace the content with  (from refreshNested method).
		 */$scope.revPlaceholders=function(placeholders,prevId,placeholderVar,replaceContent){angular.forEach(placeholders,function(placeholderRow,placeholderKey){if(parseInt(prevId)==parseInt(placeholderRow.prev_id)&&placeholderVar==placeholderRow["var"]){placeholders[placeholderKey]["__nav_item_page_block_items"]=replaceContent}else{$scope.revFind(placeholderRow,prevId,placeholderVar,replaceContent)}})};/**
		 * The revFind method does the recursiv job within a block an passes the value back to revPlaceholders().
		 */$scope.revFind=function(placeholder,prevId,placeholderVar,replaceContent){for(var i in placeholder["__nav_item_page_block_items"]){for(var holderKey in placeholder["__nav_item_page_block_items"][i]["__placeholders"]){for(var holder in placeholder["__nav_item_page_block_items"][i]["__placeholders"][holderKey]){$scope.revPlaceholders(placeholder["__nav_item_page_block_items"][i]["__placeholders"][holderKey],prevId,placeholderVar,replaceContent)}}}};/**
		 * drops items in an empty page placeholder from a cms layout
		 */$scope.dropItemPlaceholder=function(dragged,dropped,position){$http.post("admin/api-cms-navitempageblockitem/create",{prev_id:dropped.prev_id,sort_index:0,block_id:dragged.id,placeholder_var:dropped.var,nav_item_page_id:dropped.nav_item_page_id}).then(function(response){$scope.refreshNested(dropped.prev_id,dropped.var)})};$scope.refresh()});/**
	 * @param $scope.placeholder From ng-repeat
	 *//*
	zaa.controller("PagePlaceholderController", function($scope, $http, AdminClassService, PlaceholderService) {

		$scope.NavItemTypePageController = $scope.$parent;

		$scope.PlaceholderService = PlaceholderService;

		$scope.$watch(function() { return $scope.PlaceholderService.status }, function(n,o) {
			if (n) {
				$scope.isOpen = true;
			} else {
				$scope.isOpen = false;
			}
		});

		$scope.isOpen = false;

		$scope.toggleOpen = function() {
			$scope.isOpen = !$scope.isOpen;
		}

		$scope.mouseEnter = function() {
			var status = AdminClassService.getClassSpace('onDragStart');
			if (status !== undefined && !$scope.isOpen) {
				$scope.isOpen = true;
			}
		};
		
		$scope.dropItemPlaceholder = function(dragged,dropped,position) {
			$http.post('admin/api-cms-navitempageblockitem/create', { prev_id : dropped.prev_id, sort_index:0, block_id : dragged.id , placeholder_var : dropped.var, nav_item_page_id : dropped.nav_item_page_id }).then(function(response) {
				$scope.NavItemTypePageController.refreshNested(dropped.prev_id, dropped.var);
			});
		};
	});
	*//**
	 * @param $scope.block From ng-repeat scope assignment
	 */zaa.controller("PageBlockEditController",function($scope,$sce,$http,AdminClassService,AdminToastService,ServiceBlockCopyStack,ServiceLiveEditMode){$scope.NavItemTypePageController=$scope.$parent;/* drops items in block container */$scope.dropItemPlaceholder=function(dragged,dropped,position){$http.post("admin/api-cms-navitempageblockitem/create",{prev_id:dropped.prev_id,sort_index:0,block_id:dragged.id,placeholder_var:dropped.var,nav_item_page_id:dropped.nav_item_page_id}).then(function(response){$scope.NavItemTypePageController.refreshNested(dropped.prev_id,dropped.var)})};$scope.dropItem=function(dragged,dropped,position){var sortIndex=$scope.$index;if(position=="bottom"){sortIndex=sortIndex+1}if(dragged.hasOwnProperty("favorized")){// its a new block
$http.post("admin/api-cms-navitempageblockitem/create",{prev_id:$scope.placeholder.prev_id,sort_index:sortIndex,block_id:dragged.id,placeholder_var:$scope.placeholder.var,nav_item_page_id:$scope.placeholder.nav_item_page_id}).then(function(response){$scope.NavItemTypePageController.refreshNested($scope.placeholder.prev_id,$scope.placeholder.var)})}else{// moving an existing block
$http.put("admin/api-cms-navitempageblockitem/update?id="+dragged.id,{prev_id:$scope.placeholder.prev_id,placeholder_var:$scope.placeholder["var"],sort_index:sortIndex}).then(function(response){$scope.NavItemTypePageController.refreshNested($scope.placeholder.prev_id,$scope.placeholder.var)})}};$scope.copyBlock=function(){ServiceBlockCopyStack.push($scope.block.id,$scope.block.name)};$scope.toggleHidden=function(){if($scope.block.is_hidden==0){$scope.block.is_hidden=1}else{$scope.block.is_hidden=0}$http({url:"admin/api-cms-navitem/toggle-block-hidden",method:"GET",params:{blockId:$scope.block.id,hiddenState:$scope.block.is_hidden}}).then(function(response){/* load live url on hidden trigger */$scope.NavItemTypePageController.$parent.$parent.loadLiveUrl();// successfull toggle hidden state of block
AdminToastService.info(i18nParam("js_page_block_visbility_change",{name:$scope.block.name}),2000)})};/*
		$scope.hasInfo = function(varFieldName) {
			if (varFieldName in $scope.block.field_help) {
				return true;
			}

			return false;
		}

		$scope.getInfo = function(varFieldName) {
			return $scope.block.field_help[varFieldName];
		}
		*/$scope.isEditable=function(){return typeof $scope.block.vars!="undefined"&&$scope.block.vars.length>0};$scope.isConfigurable=function(){return typeof $scope.block.cfgs!="undefined"&&$scope.block.cfgs.length>0};/*
		$scope.safe = function(html) {
			return $sce.trustAsHtml(html);
		};
		*//*
		$scope.onStop = function() {
			$scope.$apply(function() {
				AdminClassService.setClassSpace('onDragStart', undefined);
			});
		};
		*/$scope.$watch(function(){return $scope.block.values},function(n,o){$scope.data=n});$scope.$watch(function(){return $scope.block.variation},function(n,o){$scope.evalVariationVisbility(n)});$scope.evalVariationVisbility=function(variatenName){if($scope.block.variations.hasOwnProperty(variatenName)){var variation=$scope.block.variations[$scope.block.variation];angular.forEach(variation,function(value,key){if(angular.isObject(value)){angular.forEach(value,function(v,k){angular.forEach($scope.block[key],function(object){if(k==object.var){object.invisible=true}})})}})}else{angular.forEach($scope.block.cfgs,function(object){object.invisible=false});angular.forEach($scope.block.vars,function(object){object.invisible=false})}};$scope.cfgdata=$scope.block.cfgvalues||{};$scope.edit=false;$scope.modalHidden=true;$scope.toggleEdit=function(){if(!$scope.isEditable()){return}$scope.modalHidden=!$scope.modalHidden;$scope.edit=!$scope.edit};$scope.renderTemplate=function(template,dataVars,cfgVars,block,extras){if(template==undefined){return""}var template=twig({data:template});var content=template.render({vars:dataVars,cfgs:cfgVars,block:block,extras:extras});return $sce.trustAsHtml(content)};$scope.removeBlock=function(){AdminToastService.confirm(i18nParam("js_page_block_delete_confirm",{name:$scope.block.name}),function($timeout,$toast){$http.delete("admin/api-cms-navitempageblockitem/delete?id="+$scope.block.id).then(function(response){$scope.NavItemTypePageController.refresh();$scope.NavItemTypePageController.loadLiveUrl();$toast.close();AdminToastService.success(i18nParam("js_page_block_remove_ok",{name:$scope.block.name}),2000)})})};$scope.save=function(){$http.put("admin/api-cms-navitempageblockitem/update?id="+$scope.block.id,{json_config_values:$scope.data,json_config_cfg_values:$scope.cfgdata,variation:$scope.block.variation}).then(function(response){AdminToastService.success(i18nParam("js_page_block_update_ok",{name:$scope.block.name}),2000);$scope.toggleEdit();$scope.block.is_dirty=1;$scope.block=angular.copy(response.data.objectdetail);$scope.NavItemTypePageController.loadLiveUrl();$scope.evalVariationVisbility($scope.block.variation)})}});/**
	 * @TODO HANDLING SORT INDEX OF EACH BLOCK
	 *//*
	zaa.controller("DropBlockController", function($scope, $http, AdminClassService) {

		$scope.PagePlaceholderController = $scope.$parent;

		$scope.droppedBlock = {};

		$scope.onDrop = function($event, $ui) {

			var headers = {"headers" : { "Content-Type" : "application/x-www-form-urlencoded; charset=UTF-8" }};

			var sortIndex = $($event.target).data('sortindex');
			var moveBlock = $scope.droppedBlock['vars'] || false;
			var event = $scope.droppedBlock['event'] || false;

			if (event === 'isServiceBlockCopyInstance') {
				$http.post('admin/api-cms-navitemblock/copy-block-from-stack', $.param({
					copyBlockId: $scope.droppedBlock.blockId,
					sortIndex: sortIndex,
					prevId:  $scope.placeholder.prev_id,
					placeholder_var : $scope.placeholder.var, nav_item_page_id : $scope.placeholder.nav_item_page_id
				}), headers).then(function(response) {
					$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
					$scope.droppedBlock = {};
				});
			} else {
				if (moveBlock === false) {
					$http.post('admin/api-cms-navitempageblockitem/create', { prev_id : $scope.placeholder.prev_id, sort_index : sortIndex, block_id : $scope.droppedBlock.id , placeholder_var : $scope.placeholder.var, nav_item_page_id : $scope.placeholder.nav_item_page_id }).then(function(response) {
						$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
						$scope.droppedBlock = {};
					});
				} else {
					$http.put('admin/api-cms-navitempageblockitem/update?id=' + $scope.droppedBlock.id, {
						prev_id : $scope.placeholder.prev_id,
						placeholder_var : $scope.placeholder['var'],
						sort_index : sortIndex
					}).then(function(response) {
						$scope.PagePlaceholderController.NavItemTypePageController.refreshNested($scope.placeholder.prev_id, $scope.placeholder.var);
						$scope.droppedBlock = {};
						$($ui.helper).remove(); //destroy clone
			            $($ui.draggable).remove(); //remove from list
					});
				}
			}
			AdminClassService.setClassSpace('onDragStart', undefined);
		}
	});
	*/zaa.controller("DroppableBlocksController",function($scope,$http,AdminClassService,ServiceBlocksData,ServiceBlockCopyStack,$sce){// service ServiceBlocksData inheritance
$scope.blocksData=ServiceBlocksData.data;$scope.blocksDataRestore=angular.copy($scope.blocksData);$scope.$on("service:BlocksData",function(event,data){$scope.blocksData=data});$scope.blocksDataReload=function(){return ServiceBlocksData.load(true)};$scope.addToFav=function(item){$http.post("admin/api-cms-block/to-fav",{block:item}).then(function(response){$scope.blocksDataReload()})};$scope.removeFromFav=function(item){$http.post("admin/api-cms-block/remove-fav",{block:item}).then(function(response){$scope.blocksDataReload()})};$scope.toggleGroup=function(group){if(group.toggle_open==undefined){group.toggle_open=1}else{group.toggle_open=!group.toggle_open}$http.post("admin/api-cms-block/toggle-group",{group:group},{ignoreLoadingBar:true})};// controller logic
$scope.copyStack=ServiceBlockCopyStack.stack;$scope.$on("service:CopyStack",function(event,stack){$scope.copyStack=stack});$scope.clearStack=function(){ServiceBlockCopyStack.clear()};$scope.searchQuery="";$scope.searchIsDirty=false;$scope.$watch("searchQuery",function(n,o){if(n!==""){$scope.searchIsDirty=true;angular.forEach($scope.blocksData,function(value,key){value.group.toggle_open=1})}else if($scope.searchIsDirty){$scope.blocksData=angular.copy($scope.blocksDataRestore)}});/*
		$scope.onStart = function() {
			$scope.$apply(function() {
				AdminClassService.setClassSpace('onDragStart', 'page--drag-active');
			});
		}
		*//*
		$scope.safe = function(html) {
			return $sce.trustAsHtml(html);
		}
		*//*
		$scope.onStop = function() {
			$scope.$apply(function() {
				AdminClassService.setClassSpace('onDragStart', undefined);
			});
		}
		*/})})();