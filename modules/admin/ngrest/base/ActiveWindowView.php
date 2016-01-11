<?php

namespace admin\ngrest\base;

use yii\helpers\Json;
use yii\helpers\Inflector;

class ActiveWindowView extends \yii\base\View
{
    /**
     * 
     * @param string $value The name/value of the button to display for the user.
     * @param string $callback The id of the callback if the callback method s name is `callbackSayHello` the callback id would be `say-hello`.
     * @param array $params Additional json parameters to send to the callback.
     * @param array $options Define behavior of the button, optionas are name-value pairs. The following options are available:
     * 
     * - closeOnSuccess: boolean, if enabled, the active window will close after successfully sendSuccess() response from callback.
     * - reloadListOnSuccess: boolean, if enabled, the active window will reload the ngrest crud list after success response from callback via sendSuccess().
     * 
     * @return string
     */
    public function callbackButton($value, $callback, array $params = [], array $options = [])
    {
        $json = Json::encode($params);
        $controller = 'Controller'.Inflector::camelize($value) . Inflector::camelize($callback);
        $callback = $this->callbackConvert($callback);
        
        $closeOnSuccess = null;
        if (isset($options['closeOnSuccess'])) {
            $closeOnSuccess.= '$scope.crud.closeActiveWindow();';
        }
        
        $reloadListOnSuccess = null;
        if (isset($options['reloadListOnSuccess'])) {
            $reloadListOnSuccess = '$scope.crud.loadList();';
        }
        
        $return = '<script>
        zaa.bootstrap.register(\''.$controller.'\', function($scope, $controller) {
            $scope.crud = $scope.$parent;
            $scope.params = '.$json.';
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
                            '.$closeOnSuccess.$reloadListOnSuccess.'
                        }
                    }
                
    			}, function(error) {
    				$scope.crud.toast.error(error.data.message, 8000);
    			});
            };
        });
        </script>
        <div ng-controller="'.$controller.'">
            <button ng-click="sendButton(\'' .$callback.'\')" class="btn" type="button">'.$value.'</button>
        </div>';
        
        return $return;
    }
    
    private function callbackConvert($callbackName)
    {
        return Inflector::camel2id($callbackName);
    }
}
