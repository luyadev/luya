<?php

namespace luya\admin\ngrest\aw;

use luya\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use luya\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * Generate a button connected to a callback action.
 *
 * Generates a button with a label which triggers an angular request for the active window callback:
 *
 * ```php
 * CallbackButtonWidget::widget(['label' => 'Button Label', 'callback' => 'callback-function', 'params' => ['foo' => 'bar']]);
 * ```
 *
 * The above example would call the `callbackCallbackFunction($foo)` callback from the Active Window.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class CallbackButtonWidget extends Widget
{
    /**
     * @var string The id of the callback if the callback method s name is `callbackSayHello` the callback id would be `say-hello`.
     */
    public $callback;
    
    /**
     * @var string The label of the button to display for the user.
     */
    public $label;
    
    /**
     * @var array $options Define behavior of the button, options are name-value pairs. The following options are available:
     * - closeOnSuccess: boolean, if enabled, the active window will close after successfully sendSuccess() response from callback.
     * - reloadListOnSuccess: boolean, if enabled, the active window will reload the ngrest crud list after success response from callback via sendSuccess().
     * - reloadWindowOnSuccess: boolean, if enabled the active window will reload itself after success (when successResponse is returnd).
     * - class: string, html class fur the button
     * - linkLabel: This label is for the second triggerable download link.
     */
    public $options = [];
    
    /**
     * @var string Optional string with javascript callback function which is going to be triggered after angular response.
     */
    public $angularCallbackFunction = 'function() {};';
    
    /**
     * @var array Add additional parameters which will be sent to the callback. ['foo' => 'bar']
     */
    public $params = [];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if ($this->callback === null || $this->label === null) {
            throw new InvalidConfigException("The callbackButton widget callback and label properties can not be empty.");
        }
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $controller = 'Controller'.Inflector::camelize($this->label) . Inflector::camelize($this->callback);
        // render and return the view with the specific params
        return $this->render('@admin/views/aws/base/_callbackButton', [
            'angularCrudControllerName' => $controller,
            'callbackName' => $this->callbackConvert($this->callback),
            'callbackArgumentsJson' => Json::htmlEncode($this->params),
            'buttonNameValue' => $this->label,
            'closeOnSuccess' => (isset($this->options['closeOnSuccess'])) ? '$scope.crud.closeActiveWindow();' : null,
            'reloadListOnSuccess' => (isset($this->options['reloadListOnSuccess'])) ? '$scope.crud.loadList();' : null,
            'reloadWindowOnSuccess' => (isset($this->options['reloadWindowOnSuccess'])) ? '$scope.$parent.reloadActiveWindow();' : null,
            'buttonClass' => ArrayHelper::getValue($this->options, 'class', 'btn btn-save'),
            'linkLabel' => ArrayHelper::getValue($this->options, 'linkLabel', 'Download'),
            'linkClass' => ArrayHelper::getValue($this->options, 'linkClass', 'btn btn-info'),
            'angularCallbackFunction' => $this->angularCallbackFunction,
        ]);
    }
    
    private function callbackConvert($callbackName)
    {
        return Inflector::camel2id($callbackName);
    }
}
