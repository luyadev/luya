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
zaa.bootstrap.register('<?= $angularCrudControllerName; ?>', function($scope, $controller, $injector) {
    $scope.crud = $scope.$parent;
    $scope.linkHref = null;
    $scope.linkHrefHidden = true;
    $scope.buttonHidden = false;
    $scope.callbackFunction = <?= $angularCallbackFunction; ?>
    $scope.sendButton = function(callback, params) {
        $scope.crud.sendActiveWindowCallback(callback, params).then(function(success) {
            var data = success.data;
            var errorType = null;
            var message = false;
            var response = $injector.invoke($scope.callbackFunction, this, { $scope : $scope, $response : data.responseData});
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
                    <?= $closeOnSuccess.$reloadListOnSuccess.$reloadWindowOnSuccess; ?>
                }
            }
        }, function(error) {
        	$scope.crud.toast.error(error.data.message, 8000);
        });
    };
});
</script>
<div ng-controller="<?= $angularCrudControllerName; ?>">
    <button ng-show="!buttonHidden" ng-click='sendButton("<?= $callbackName; ?>", <?= $callbackArgumentsJson; ?>)' class="<?= $buttonClass; ?>" type="button"><?= $buttonNameValue; ?></button>
    <a ng-href="{{linkHref}}" ng-show="!linkHrefHidden" class="<?= $linkClass; ?>"><?= $linkLabel; ?></a>
</div>