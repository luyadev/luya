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
		<h3><i class="material-icons">update</i> Remote Sites</h3>
		<p>Current LUYA Version is <a href="https://packagist.org/packages/luyadev/luya-core" target="_blank"><strong><?= $currentVersion['version']; ?></strong></a>, released at <?= Yii::$app->formatter->asDate(strtotime($currentVersion['time']))?></p>
		<table class="bordered hoverable">
			<thead>
			<tr>
			    <th>Id</th>
			    <th>Url</th>
			    <th>Time *</th>
			    <th>YII_DEBUG</th>
			    <th>Transfer Exceptions</th>
			    <th>Admins Online</th>
			    <th>YII_ENV</th>
			    <th>LUYA Version</th>
			    <th>Yii Version</th>
			    <th></th>
			</tr>
			</thead>
	        <tr ng-repeat="site in sites">
	            <td>{{site.id}}</td>
	            <td><a ng-href="{{site.url}}" target="_blank">{{site.url}}</a></td>
	            <td ng-if="!site.status.error">{{site.status.time}}</td>
	            <td ng-if="!site.status.error" style="{{site.status.debugstyle}}">{{site.status.debug}}</td>
	            <td ng-if="!site.status.error" style="{{site.status.exceptionsstyle}}">{{site.status.exceptions}}</td>
	            <td ng-if="!site.status.error">{{site.status.online}}</td>
	            <td ng-if="!site.status.error">{{site.status.env}}</td>
	            <td ng-if="!site.status.error" style="{{site.status.luyastyle}}">{{site.status.luya}}</td>
	            <td ng-if="!site.status.error">{{site.status.yii}}</td>
	            <td ng-if="site.status.error" colspan="7"><div style="background-color:#FF8A80; padding:4px; color:white;">Unable to retrieve data from the Remote Page.</div></td>
                <td><a ng-href="{{site.url}}/admin" target="_blank"> <button class="btn-flat  btn--bordered"><i class="material-icons">exit_to_app</i></button></a></td>
	        </tr>
		</table>
		<p><small>The Remote Data will be cached for <strong>2 minutes</strong>. You can us the cache-reload button to flush the whole page cache.</small></p>
		<p><small>* Time: Returns the total elapsed time since the start of the request on the Remote application. Its the speed of the application, not the time elapsed to make the remote request.</small></p>
	</div>
	<div class="card-panel red accent-1" ng-if="hasError">
		<p>If the request to a remote page returns an error, the following issues could have caused your request:</p>
		<ul>
		    <li>The requested website is secured by a httpauth authorization, you can add the httpauth credentials in the page configuration section.</li>
		    <li>The requested website url is wrong or not valid anymire. Make sure the url is correctly added with its protocol.</li>
		    <li>The requested website remote token is not defined in the config of the website itself or your enter secure token is wrong.</li>
		</ul>
	</div>
</div>