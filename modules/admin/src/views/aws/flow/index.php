<script>
zaa.bootstrap.register('FlowController', function($scope, $rootScope, $controller) {
    $scope.$watch(function() { return $scope.$flow }, function(n, o) {
        $scope.$flow.opts.target = $scope.$parent.getActiveWindowCallbackUrl('upload');
    });

    // reset files list
    $scope.$on('awloaded', function(e, data) {
        $scope.$flow.files = [];
        $scope.loadList();
    });

	$scope.clearFlowList = function() {
		$scope.$flow.files = [];
	};
    
    $scope.list = [];
    
    $scope.loadList = function() {
        $scope.$parent.sendActiveWindowCallback('list').then(function(response) {
            $scope.list = response.data.responseData.images;
        });
    };

    $scope.removeItem = function(imageId) {
    	$scope.$parent.sendActiveWindowCallback('remove', {imageId: imageId}).then(function(response) {
    		delete $scope.list[imageId];
        });
    };

    $scope.flowOptions = {
        headers : {Authorization : 'Bearer ' + $rootScope.luyacfg.authToken}
    };
    
    $scope.loadList();
});
</script>
<div ng-controller="FlowController" flow-init="flowOptions" flow-files-submitted="$flow.upload()" flow-complete="loadList()" flow-file-success="$file.upload = true">
    <div class="row">
        <div class="col md-4">
            <button type="button" class="btn btn-primary" flow-btn><i class="material-icons">file_upload</i> Image Upload</button>
            <div ng-show="$flow.files.length > 0">
                <h3 style="margin-top:40px;">Upload list</h3>
	            <table class="table table-sm">
	                <tr ng-repeat="file in $flow.files" ng-class="{'table-success' : file.upload, 'table-active' : !file.upload}">
	                    <td>
                            <i class="material-icons" ng-if="file.upload">done</i>
	                        <i class="material-icons spin" ng-if="!file.upload">cached</i>
	                    </td>
	                    <td>{{file.name}}</td>
	                </tr>
	            </table>
	            <button type="button" class="btn btn-secondary" ng-click="clearFlowList()">Clear List</button>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-1" ng-repeat="(imageId, file) in list">
                    <button type="button" class="btn btn-outline-danger btn-sm" ng-click="removeItem(imageId)" style="position:absolute;"><i class="material-icons">delete</i></button>
                    <img class="img-fluid img-thumbnail" ng-src="{{file.source}}" alt="{{file.source}}" />
                </div>
            </div>
       </div>
    </div>
</div>