<?php
/**
 * @param $angularCrudControllerName;
 * @param $callbackName
 * @param $callbackArgumentsJson
 * @param $closeOnSuccess
 * @param $reloadListOnSuccess;
 * @param $buttonNameValue
 */
?>
<script>
zaa.bootstrap.register('<?php echo $angularCrudControllerName; ?>', function($scope, $controller) {
    $scope.crud = $scope.$parent;
    $scope.params = <?php echo $callbackArgumentsJson; ?>;
    $scope.sendButton = function(callback) {
        $scope.crud.sendActiveWindowCallback(callback, $scope.params).then(function(success) {
            var data = success.data;
            var errorType = null;
            var message = false;
        
            if ("error" in data) {
                errorType = data.error;
            }
        
            if ("message" in data) {
                message = data.message;
            }
        
            if (errorType !== null) {
                if (errorType == true) {
                    $scope.crud.toast.error(message, 8000);
                } else {
                    $scope.crud.toast.success(message, 8000);
                    <?php echo $closeOnSuccess.$reloadListOnSuccess.$reloadWindowOnSuccess; ?>
                }
            }
        
		}, function(error) {
			$scope.crud.toast.error(error.data.message, 8000);
		});
    };
});
</script>
<div ng-controller="<?php echo $angularCrudControllerName; ?>">
    <button ng-click="sendButton('<?php echo $callbackName; ?>')" class="<?= $buttonClass; ?>" type="button"><?php echo $buttonNameValue; ?></button>
</div>