<?php

namespace luya\web;

use Yii;
use Exception;
use luya\helpers\FileHelper;
use Twig_Loader_Filesystem;

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
    /**
     * @var string The path to the default element file. Alias names will be parsed by Yii::getAlias.
     */
    public $configFile = '@app/elements.php';

    /**
     * @var string The path to the folder where the view files to render can be found.
     */
    public $viewsFolder = '@app/views/elements/';

    /**
     * @var array Contains all registered elements.
     */
    private $_elements = [];

    /**
     * @var string Parsed path of the folder where the view files are stored.
     */
    private $_folder = null;

    /**
     * Yii intializer, is loading the default elements.php if existing.
     */
    public function init()
    {
        $path = Yii::getAlias($this->configFile);
        if (file_exists($path)) {
            $config = (include($path));
            foreach ($config as $name => $closure) {
                $this->addElement($name, $closure);
            }
        }
    }

    /**
     * Magic method to run an closre directly from the Element-Object, for convincience. Example use.
     * 
     * ```php
     * $element = new Element();
     * $element->name($param1);
     * ```
     * 
     * @param string $name   access method name
     * @param array  $params access method params
     */
    public function __call($name, $params)
    {
        return $this->run($name, $params);
    }

    /**
     * Add an element with a closure to the elements array.
     * 
     * @param string   $name    The identifier of the element where the close is binde to.
     * @param callable $closure The closure function to registered, for instance:
     * 
     * ```php
     * function() {
     *     return 'foobar';
     * }
     * ```
     */
    public function addElement($name, $closure)
    {
        $this->_elements[$name] = $closure;
    }

    /**
     * Checks whether an elemnt exists in the elements list or not
     * 
     * @param string $name The name of the element
     * @return boolean 
     */
    public function hasElement($name)
    {
        return array_key_exists($name, $this->_elements);
    }
    
    /**
     * Returns an array with all registered Element-Names.
     *
     * @return array Value is the name of the element
     */
    public function getNames()
    {
        return array_keys($this->_elements);
    }

    /**
     * Return all elements as an array where the key is the name and the value the closure.
     * 
     * @return array Key is the Name of the Element, value the Closure.
     */
    public function getElements()
    {
        return $this->_elements;
    }

    /**
     * Run an element and return the closures return value.
     * 
     * @param string $name   The name of the elemente to execute.
     * @param array  $params The params to pass to the closure methode.
     *
     * @return mixed The return value of the executed closure function.
     *
     * @throws Exception
     */
    public function run($name, array $params = [])
    {
        if (!array_key_exists($name, $this->_elements)) {
            throw new Exception("The requested element '$name' does not exist in the list. You may register the element first with `addElement(name, closure)`.");
        }

        return call_user_func_array($this->_elements[$name], $params);
    }

    /**
     * Returns the path to the view files used for the render() method. Singleton method the return 
     * the evaluated viewFolder path once.
     * 
     * @return string Evaluated view foler path
     */
    public function getFolder()
    {
        if ($this->_folder === null) {
            $this->_folder = Yii::getAlias($this->viewsFolder);
        }

        return $this->_folder;
    }

    /**
     * Method to render twig files with theyr specific arguments, can be used inside the element closure depending
     * on where the closure was registered. Otherwhise the use of the element variable must be provided.
     * 
     * @param string $file The name of the file to render.
     * @param array  $args The parameters to pass in the render file.
     *
     * @return string The render value of the view file.
     */
    public function render($file, array $args = [])
    {
        $twig = Yii::$app->twig->env(new Twig_Loader_Filesystem($this->getFolder()));

        return $twig->render(FileHelper::appendExtensionToString($file, 'twig'), $args);
    }
}
