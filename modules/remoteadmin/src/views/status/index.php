<?php
use luya\remoteadmin\Module;
?>
<script>
zaa.bootstrap.register('SitesStatusController', function($scope, $http) {

    $scope.sites = [];

    $scope.hasError = false;
    
    $scope.loadSites = function() {
        $http.get('admin/api-remote-site').then(function(response) {
            $scope.sites = response.data;
            angular.forEach($scope.sites, function(value, key) {
                $scope.sites[key]['status'] = {loading:true, error:false, time:null, debug:null, app_debug_style:null, exceptions:null, exceptionsstyle:null, online:null, env:null, luya:null, luyastyle:null, yii:null};
                
                $http.get('admin/api-remote-site/' + value.id +'?expand=remote&fields=remote').then(function(response2) {
                    data = response2.data.remote;
                    $scope.sites[key]['status'] = {
                       loading:false, 
                       error:data.error,
                       time:data.app_elapsed_time, 
                       debug: data.app_debug, 
                       debugstyle: data.app_debug_style,
                       exceptions:data.app_transfer_exceptions, 
                       exceptionsstyle: data.app_transfer_exceptions_style,
                       online:data.admin_online_count, 
                       env:data.app_env, 
                       luya:data.luya_version, 
                       luyastyle: data.luya_version_style,
                       yii:data.yii_version
                    };
                    
                    if (data.error) {
                        $scope.hasError = true;
                    }
                });
            });
        });
    };

    $scope.loadSites();
});
</script>
<div  ng-controller="SitesStatusController">
	<div class="card-panel">
		<h3><i class="material-icons">update</i> <?= Module::t('status_index_heading'); ?></h3>
        <p><?= Module::t('status_index_intro', ['version' => $currentVersion['version'], 'date' => Yii::$app->formatter->asDate(strtotime($currentVersion['time']))]); ?></p>
		<table class="bordered hoverable centered">
			<thead>
			<tr>
			    <th style="text-align:left;"><?= Module::t('model_site_url'); ?></th>
			    <th><?= Module::t('status_index_column_time'); ?> *</th>
			    <th>YII_DEBUG</th>
			    <th><?= Module::t('status_index_column_transferexception'); ?></th>
			    <th><?= Module::t('status_index_column_onlineadmin'); ?></th>
			    <th>YII_ENV</th>
			    <th>LUYA Version</th>
			    <th>Yii Version</th>
			    <th></th>
			</tr>
			</thead>
	        <tr ng-repeat="site in sites">
	            <td style="text-align:left;"><a ng-href="{{site.url}}" target="_blank">{{site.url}}</a></td>
	            <td ng-if="!site.status.error && !site.status.loading">{{site.status.time}}</td>
	            <td ng-if="!site.status.error && !site.status.loading" style="{{site.status.debugstyle}}">{{site.status.debug}}</td>
	            <td ng-if="!site.status.error && !site.status.loading" style="{{site.status.exceptionsstyle}}">{{site.status.exceptions}}</td>
	            <td ng-if="!site.status.error && !site.status.loading">{{site.status.online}}</td>
	            <td ng-if="!site.status.error && !site.status.loading">{{site.status.env}}</td>
	            <td ng-if="!site.status.error && !site.status.loading" style="{{site.status.luyastyle}}">{{site.status.luya}}</td>
	            <td ng-if="!site.status.error && !site.status.loading">{{site.status.yii}}</td>
	            <td ng-if="site.status.error" colspan="7"><div style="background-color:#FF8A80; padding:4px; color:white;"><?= Module::t('status_index_table_error'); ?></div></td>
                <td ng-if="site.status.loading" colspan="7"><div class="progress"><div class="indeterminate"></div></div></td>
                <td><a ng-href="{{site.url}}/admin" target="_blank"> <button class="btn-flat  btn--bordered"><i class="material-icons">exit_to_app</i></button></a></td>
	        </tr>
		</table>
		<p><small><?= Module::t('status_index_caching_info'); ?></small></p>
		<p><small><?= Module::t('status_index_time_info'); ?></small></p>
	</div>
	<div class="card-panel red accent-1" ng-if="hasError">
		<p><?= Module::t('stauts_index_error_text'); ?></p>
		<ul>
		    <li><?= Module::t('status_index_error_1'); ?></li>
		    <li><?= Module::t('status_index_error_2'); ?></li>
		    <li><?= Module::t('status_index_error_3'); ?></li>
		</ul>
	</div>
</div>