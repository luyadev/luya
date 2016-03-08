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
     * @param array $options Define behavior of the button, options are name-value pairs. The following options are available:
     * 
     * - params: array, Add additional parameters which will be sent to the callback. ['foo' => 'bar']
     * - closeOnSuccess: boolean, if enabled, the active window will close after successfully sendSuccess() response from callback.
     * - reloadListOnSuccess: boolean, if enabled, the active window will reload the ngrest crud list after success response from callback via sendSuccess().
     * 
     * @return string
     */
    public function callbackButton($value, $callback, array $options = [])
    {
        // do we have option params for the button
        $params = (array_key_exists('params', $options)) ? $options['params'] : [];
        // create the angular controller name
        $controller = 'Controller'.Inflector::camelize($value) . Inflector::camelize($callback);
        // render and return the view with the specific params
        return $this->render('@admin/views/aws/base/_callbackButton', [
            'angularCrudControllerName' => $controller,
            'callbackName' => $this->callbackConvert($callback),
            'callbackArgumentsJson' => Json::encode($params),
            'buttonNameValue' => $value,
            'closeOnSuccess' => (isset($options['closeOnSuccess'])) ? '$scope.crud.closeActiveWindow();' : null,
            'reloadListOnSuccess' => (isset($options['reloadListOnSuccess'])) ? '$scope.crud.loadList();' : null,
        ]);
    }
    
    private function callbackConvert($callbackName)
    {
        return Inflector::camel2id($callbackName);
    }
}
