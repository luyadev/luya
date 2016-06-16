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
<div ng-controller="FlowController" flow-init="{target: '/upload'}" flow-files-submitted="$flow.upload()" flow-complete="loadList()" flow-file-success="$file.upload = true" class="flow">

    <div class="row">

        <div class="col s10">
            <div class="flow__dropzone" flow-drop flow-drag-enter="style={background:'#dcedc8'}" flow-drag-leave="style={}" ng-style="style">
                Drag and Drop your images here
            </div>
        </div>

        <div class="col s2">
            <span class="btn" flow-btn>Upload images</span>
        </div>

    </div>


    <div class="row flow__lower">

        <div class="col s4">
            <table class="striped">
                <tr>
                    <th colspan="3">Upload list</th>
                </tr>
                <tr ng-repeat="file in $flow.files">
                    <!--<td>{{$index+1}}</td>-->
                    <td>
                        <div ng-if="file.upload"><button tyle="button" class="btn btn-floating"><i class="material-icons">done</i></button></div>
                        <div ng-if="!file.upload"><i class="material-icons spin">cached</i></div>
                    </td>
                    <td>{{file.name}}</td>
                </tr>
            </table>
            <button ng-if="$flow.files.length > 0" type="button" class="flow__clear right btn btn--small blue lighten-2" ng-click="clearFlowList()">Clear List</button>
        </div>

        <div class="col s8">
            <div class="row flow__images">
                <div class="col s4 m3 l2" ng-repeat="(imageId, file) in list">
                    <div class="flow__image-wrap">
                        <img class="flow__image" ng-src="{{file.source}}" />
                        <div class="flow__delete" ng-click="removeItem(imageId)"><i class="material-icons">delete</i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>