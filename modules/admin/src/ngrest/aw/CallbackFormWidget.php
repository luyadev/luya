<?php

namespace admin\ngrest\aw;

use luya\Exception;
use yii\helpers\Json;
use yii\helpers\Inflector;

/**
 * Example usage:
 * 
 * ```php
 * <? $form = CallbackFormWidget::begin(['callback' => 'get-coordinates', 'buttonValue' => 'Verify', 'angularCallbackFunction' => 'function($response) {
 *     
 * console.log($response) 
 * 
 * };']); ?>
 * 
 * <?= $form->field('address', 'Adresse:'); ?>
 * <? $form::end(); ?>
 * ```
 * @author nadar
 */
class CallbackFormWidget extends \yii\base\Widget
{
    public $options = [];
    
    public $buttonValue = null;
    
    public $callback = null;

    public $angularCallbackFunction = 'function() {};';
    
    public function init()
    {
        parent::init();
        
        if ($this->callback === null || $this->buttonValue === null) {
            throw new Exception("callback and/or buttonValue can not be empty");
        }
        
        ob_start();
    }
    
    public function field($name, $label, array $options = [])
    {
        return '
        <div class="input input--text input--vertical">
            <label class="input__label" for="'.$this->getFieldId($name).'">'.$label.'</label>
            <div class="input__field-wrapper">
                <input class="input__field" id="'.$this->getFieldId($name).'" ng-model="params.'.$name.'" />
            </div>
        </div>';
    }
    
    private function callbackConvert($callbackName)
    {
        return Inflector::camel2id($callbackName);
    }
    
    private function getFieldId($name)
    {
        return Inflector::camel2id($this->id . $name);
    }
    
    public function run()
    {
        $content = ob_get_clean();
        // do we have option params for the button
        $params = (array_key_exists('params', $this->options)) ? $this->options['params'] : [];
        // create the angular controller name
        $controller = 'Controller'.Inflector::camelize($this->id) . Inflector::camelize($this->callback) . time();
        // render and return the view with the specific params
        return $this->render('@admin/views/aws/base/_callbackForm', [
            'angularCrudControllerName' => $controller,
            'callbackName' => $this->callbackConvert($this->callback),
            'callbackArgumentsJson' => Json::encode($params),
            'buttonNameValue' => $this->buttonValue,
            'closeOnSuccess' => (isset($this->options['closeOnSuccess'])) ? '$scope.crud.closeActiveWindow();' : null,
            'reloadListOnSuccess' => (isset($this->options['reloadListOnSuccess'])) ? '$scope.crud.loadList();' : null,
            'form' => $content,
            'angularCallbackFunction' => $this->angularCallbackFunction,
        ]);
    }
}