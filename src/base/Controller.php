<?php

namespace luya\base;

/**
 * Base class for all controllers in luya application Modules.
 * 
 * @author nadar
 */
abstract class Controller extends \yii\web\Controller
{
    /**
     * @var bool Use the default behaviour of Yii. This will result in loading the templates inside the Modules.
     */
    public $useModuleViewPath = false;

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
    
    /**
     * Helper method for registring an asset into the view
     *
     * @param string $className The asset class to register, example `app\asset\MyTestAsset`.
     * @return void
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
        // if the module settings is turn to use the module view path we use them always first!
        if ($this->module->controllerUseModuleViewPath !== null) {
            $this->useModuleViewPath = $this->module->controllerUseModuleViewPath;
        }

        // use default yii behaviour
        if ($this->useModuleViewPath) {
            return parent::getViewPath();
        }
        // use client repository specific path
        return '@app/views/'.$this->module->id.'/'.$this->id;
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
        return '@app/views/'.$this->module->id.'/';
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
     *      <?= $content; ?>
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
