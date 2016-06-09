<script>
zaa.bootstrap.register('FlowController', function($scope, $controller) {
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
        

    $scope.loadList();
});
</script>
<div ng-controller="FlowController" flow-init="{target: '/upload'}" flow-files-submitted="$flow.upload()" flow-complete="loadList()" flow-file-success="$file.upload = true">
    <div class="row">
    
        <div class="col s2">
          <span class="btn" flow-btn>Upload File</span>
        
            <div class="alert" flow-drop>
                Drag And Drop your file here
            </div>
        
          <table class="striped">
            <tr ng-repeat="file in $flow.files">
                <td>{{$index+1}}</td>
                <td>
                    <div ng-if="file.upload"><button tyle="button" class="btn btn-floating"><i class="material-icons">done</i></button></div>
                    <div ng-if="!file.upload"><i class="material-icons spin">cached</i></div>    
                </td>
                <td>{{file.name}}</td>
            </tr>
          </table>
          <button ng-if="$flow.files.length > 0" type="button" class="btn" ng-click="clearFlowList()">Clear List</button>
        </div>
        <div class="col s10">
           <div class="row">
           	 <div class="col s2" ng-repeat="(imageId, file) in list"><img ng-src="{{file.source}}" /><i ng-click="removeItem(imageId)" class="material-icons">remove</i></div>
           </div>
        </div>
    </div>
</div>