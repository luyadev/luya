<script>
zaa.bootstrap.register('FlowController', function($scope, $controller) {
    $scope.$watch(function() { return $scope.$flow }, function(n, o) {
        $scope.$flow.opts.target = '/salamliupload.php';
        console.log($scope.$flow.opts);
    });
});
</script>
<h1>Flow Image Upload</h1>
<div ng-controller="FlowController" flow-init="{target: '/upload'}"
     flow-files-submitted="$flow.upload()"
     flow-file-success="$file.msg = $message">

  <input type="file" flow-btn/>
  Input OR Other element as upload button
  <span class="btn" flow-btn>Upload File</span>

    <div class="alert" flow-drop>
        Drag And Drop your file here
    </div>

  <table>
    <tr ng-repeat="file in $flow.files">
        <td>{{$index+1}}</td>
        <td>{{file.name}}</td>
        <td>{{file.msg}}</td>
    </tr>
  </table>
</div>