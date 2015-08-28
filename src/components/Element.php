<?php

namespace luya\components;

use Yii;
use Exception;

/**
 * Ability to register small html elements via closure function and run those
 * parts an every part of the page.
 * 
 * ```php
 * Yii::$app->element->addElement('foo', function($param) {
 *     return '<button>' . $param . '</button>';
 * });
 * ```
 * 
 * The above example can be execute like this:
 * 
 * ```php
 * echo Yii::$app->element->foo('Hello World');
 * ```
 * 
 * or in Twig
 * 
 * ```twig
 * {{ element('foo', 'Hello World') }}
 * ```
 * 
 * By default the Element-Component will lookup for an `elements.php` file returning an array
 * where the key is the element name and value the closure to be execute.
 * 
 * Example elements.php
 * 
 * ```php
 * <?php
 * return [
 *    'button' => function($value, $link) {
 *        return '<a class="btn btn-primary" href="'.$link.'">'.$value.'</a>';  
 *    },
 *    'teaserbox' => function($title, $text, $buttonValue, $buttonLink) {
 *        return '<div class="teaser-box" style="padding:10px; border:1px solid red;"><h1>'.$title.'</h1><p>'.$text.'</p>'.$this->button($buttonValue, $buttonLink).'</div>';
 *    },
 * ];
 * ```
 * 
 * @author nadar
 */
class Element extends \yii\base\Component
{
    public $configFile = '@app/elements.php';
    
    private $_elements = [];
    
    private $_folder = null;
    
    public function init()
    {
        $path = Yii::getAlias($this->configFile);
        if (file_exists($path)) {
            $config = (include($path));
            foreach($config as $name => $closure) {
                $this->addElement($name, $closure);
            }
        }
    }
    
    public function addElement($name, $closure)
    {
        $this->_elements[$name] = $closure;
    }
    
    public function __call($name, $params)
    {
        return $this->run($name, $params);
    }
    
    public function run($name, array $params = [])
    {
        if (!array_key_exists($name, $this->_elements)) {
            throw new Exception("The requested element '$name' does not exists in the element list. You may register the element first with `addElement(name, closure)`.");
        }
        
        $func = $this->_elements[$name];
        return call_user_func_array($func, $params);
    }
    
    public function getFolder()
    {
        if ($this->_folder === null) {
            $this->_folder = Yii::getAlias('@app/views/elements/');
        }
        
        return $this->_folder;
    }
    
    private function appendFileExtension($file)
    {
        $info = pathinfo($file);
        if (!isset($info['extension'])) {
            $file = $info['filename'] . '.twig';
        }
        return $file;
    }
    
    public function render($file, array $args = [])
    {
        $twig = Yii::$app->twig->env(new \Twig_Loader_Filesystem($this->getFolder()));
        return $twig->render($this->appendFileExtension($file), $args);
    }
}