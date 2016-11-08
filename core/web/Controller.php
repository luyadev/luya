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
     * Returns the path for layout files when using {{\luya\web\Controller::renderLayout}} method. Those module layouts are located in @app/views folder.
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
