<?php

namespace admin\ngrest\aw;

use Yii;
use luya\Exception;
use yii\helpers\Json;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;

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
 * <?= $form->field('firstname'); ?>
 * // equals
 * <?= $this->field('firstname')->textInput(); ?>
 * 
 * // labels
 * <?= $form->field('firstname', 'Firstname Label')->textInput(); ?>
 * // equals
 * <?= $form->field('firstname')->textInput()->label('Firstname Label'); ?>
 * 
 * // textarea
 * <?= $form->field('text')->textarea(); ?>
 * 
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

    public $fieldClass = '\admin\ngrest\aw\ActiveField';
    
    public $fieldConfig = [];
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Object::init()
     */
    public function init()
    {
        parent::init();
        
        if ($this->callback === null || $this->buttonValue === null) {
            throw new Exception("callback and/or buttonValue can not be empty");
        }
        
        ob_start();
    }
    
    /**
     * Generate a field based on attribute name and optional label.
     * 
     * @param string $attribute The name of the field (which also will sent to the callback as this name)
     * @param string $label Optional Label
     * @param array $options
     * @return \admin\ngrest\aw\ActiveField
     */
    public function field($attribute, $label = null, $options = [])
    {
    	$config = $this->fieldConfig;
    	
    	if (!isset($config['class'])) {
    		$config['class'] = $this->fieldClass;
    	}
    	
    	return Yii::createObject(ArrayHelper::merge($config, $options, [
    		'attribute' => $attribute,
    		'form' => $this,
    		'label' => $label,
    	]));
    }
    
    /**
     * Convert the callback to a camlized name.
     * 
     * @param unknown $callbackName
     * @return string
     */
    private function callbackConvert($callbackName)
    {
        return Inflector::camel2id($callbackName);
    }
    
    /**
     * Get the id for a field based on the attribute name
     * 
     * @param string $name
     * @return string
     */
    public function getFieldId($name)
    {
        return Inflector::camel2id($this->id . $name);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
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
