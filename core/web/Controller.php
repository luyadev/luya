<?php

namespace luya\web;

use luya\base\Module;

/**
 * Base class for all controllers in luya application Modules.
 * 
 * @author nadar
 */
abstract class Controller extends \yii\web\Controller
{
    /**
     * @var array skips defined assets from the module base, you can not skip assets which are registered in the local asset variable. To Skip
     *            all the assets from the module ($this->module->assets) you can use skipAssets = ["*"];.
     */
    public $skipModuleAssets = [];

    /**
     * @var array Defined assets where should be assigned into the view for this controller. The class name of the Asset (e.g. "\admin\asset\BowerAsset")
     */
    public $assets = [];

    /**
     * Yii initializer. Find assets to register, and add them into the view if they are not ignore by $skipModuleAssets.
     */
    public function init()
    {
        // call parent
        parent::init();
        
        if ($this->module instanceof Module) {
	        // get asset bundles which are defined in the module and register them into the view
	        foreach ($this->module->assets as $class) {
	            if (!in_array($class, $this->skipModuleAssets) && !in_array('*', $this->skipModuleAssets)) {
	                // autoload $class and register with current view
	                $this->registerAsset($class);
	            }
	        }
	        // get controller based assets
	        foreach ($this->assets as $class) {
	            $this->registerAsset($class);
	        }
        }
    }

    /**
     * Helper method for registring an asset into the view.
     *
     * @param string $className The asset class to register, example `app\asset\MyTestAsset`.
     */
    public function registerAsset($className)
    {
        $className::register($this->view);
    }

    /**
     * Override the default Yii controller getViewPath method. To define the template folders in where
     * the templates are located. Why? Basically some modules needs to put theyr templates inside of the client
     * repository.
     *
     * @return string
     */
    public function getViewPath()
    {
        if ($this->module instanceof Module && $this->module->useAppViewPath) {
            return '@app/views/'.$this->module->id.'/'.$this->id;
        }
        
        return parent::getViewPath();
    }

    /**
     * If we are acting in the module context and the layout is empty we only should renderPartial the content.
     *
     * @param string $view   The name of the view file (e.g. index)
     * @param array  $params The params to assign into the value for key is the variable and value the content.
     *
     * @return string
     */
    public function render($view, $params = [])
    {
        if (!empty($this->module->context) && empty($this->layout)) {
            return $this->renderPartial($view, $params);
        }

        return parent::render($view, $params);
    }

    /**
     * Returns the path for layout files when using `renderLayout()` method. Those module layouts are located in @app/views.
     * 
     * @return string The path to the layout for the current Module.
     */
    public function getModuleLayoutViewPath()
    {
        if ($this->module->useAppViewPath) {
            return '@app/views/'.$this->module->id.'/';
        }
        
        return '@'.$this->module->id.'/views/';
    }

    /**
     * Luya implementation of layouts for controllers. The method will return a view file wrapped by a custom module layout. 
     * For example you have a e-store module with a header which returns the basket you can use the module layout in all the actions
     * to retrieve the same header. Example e-store controller class:.
     * 
     * ```php
     * class EstoreController extends \luya\base\Controller
     * {
     *     public function actionIndex()
     *     {
     *         return $this->renderLayout('index', ['content' => 'This is my index content in variabel $content.']);
     *     }
     *     
     *     public function actionBasket()
     *     {
     *          return $this->renderLayout('basket', ['otherVariable' => 'This is a variable for the basket view file in variable $otherVariable.']);
     *     }
     * }
     * ```
     * 
     * The example layout file which is located in `@app/views/module/layout` could look something like this:
     * 
     * ```php
     * <ul>
     *  <li>E-Store Frontpage</li>
     *  <li>Basket</li>
     * </ul>
     * <div id="estore-wrapper">
     *      <?php echo $content; ?>
     * </div>
     * ```
     * 
     * @param string $view   The name of the view file
     * @param array  $params The params to assign into the view file.
     *
     * @return string Rendered template wrapped by the module layout file.
     */
    public function renderLayout($view, $params = [])
    {
        $content = $this->view->renderFile($this->getViewPath().'/'.$view.'.php', $params, $this);

        return $this->render($this->getModuleLayoutViewPath().$this->module->moduleLayout, ['content' => $content]);
    }
}
