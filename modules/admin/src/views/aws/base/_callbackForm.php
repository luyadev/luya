<script>
zaa.bootstrap.register('<?php echo $angularCrudControllerName; ?>', function($scope, $controller, $injector) {
    $scope.crud = $scope.$parent;
    $scope.params = {};
    $scope.responseData = {};
    $scope.callbackFunction = <?php echo $angularCallbackFunction; ?>
    $scope.sendButton = function(callback) {
        $scope.crud.sendActiveWindowCallback(callback, $scope.params).then(function(success) {
            var data = success.data;
            var errorType = null;
            var message = false;
        	$scope.responseData = data.responseData;
            if ("error" in data) {
                errorType = data.error;
            }
        
            if ("message" in data) {
                message = data.message;
            }

            var response = $injector.invoke($scope.callbackFunction, this, { $scope : $scope, $response : data.responseData});
            
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

	<?= $form; ?>

    <button ng-click="sendButton('<?php echo $callbackName; ?>')" class="<?= $buttonClass; ?>" type="button"><?php echo $buttonNameValue; ?></button>
</div>