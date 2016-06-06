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

    $scope.list = [];
    
    $scope.loadList = function() {
        $scope.$parent.sendActiveWindowCallback('list').then(function(response) {
            $scope.list = response.data.responseData.data;
        });
    };

    $scope.loadList();
});
</script>
<div ng-controller="FlowController" flow-init="{target: '/upload'}" flow-files-submitted="$flow.upload()" flow-file-success="$file.msg = $message">
    <div class="row">
    
        <div class="col s6">
          <span class="btn" flow-btn>Upload File</span>
        
            <div class="alert" flow-drop>
                Drag And Drop your file here
            </div>
        
          <table class="striped">
            <tr ng-repeat="file in $flow.files">
                <td>{{$index+1}}</td>
                <td>{{file.name}}</td>
                <td>{{file.msg.systemFileName}}</td>
            </tr>
          </table>
        </div>
        <div class="col s6">
            <ul>
                <li ng-repeat="file in list">{{ file }}</li>
            </ul>
        </div>
    </div>
</div>