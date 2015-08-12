<?php

namespace luya\base;

/**
 * @author nadar
 */
abstract class Controller extends \yii\web\Controller
{
    /**
     * Use the default behaviour of Yii. This will result in loading the templates inside the Modules.
     *
     * @var bool
     */
    public $useModuleViewPath = false;

    /**
     * skips defined assets from the module base, you can not skip assets which are registered in the local asset variable. To Skip
     * all the assets from the module ($this->module->assets) you can use skipAssets = ["*"];
     * 
     * @var array
     */
    public $skipModuleAssets = [];

    /**
     * controller specific asset class to register in the view
     * 
     * @var array The class name of the Asset (e.g. "\admin\asset\BowerAsset")
     */
    public $assets = [];
    
    /**
     * Yii initializer.
     */
    public function init()
    {
        // call parent
        parent::init();
        // get asset bundles which are defined in the module and register them into the view
        foreach ($this->module->assets as $class) {
            if (!in_array($class, $this->skipModuleAssets) && !in_array("*", $this->skipModuleAssets)) {
                // autoload $class and register with current view
                $class::register($this->view);
            }
        }
        foreach ($this->assets as $class) {
            $class::register($this->view);
        }
    }

    /**
     * Override the default yii controller getViewPath method. To define the template folders in where
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
     * if we are acting in the module context and the layout is empty we only should renderPartial the content.
     *
     * @param unknown_type $view
     * @param unknown_type $params
     */
    public function render($view, $params = [])
    {
        if (!empty($this->module->context) && empty($this->layout)) {
            return $this->renderPartial($view, $params);
        }

        return parent::render($view, $params);
    }

    public function getModuleLayoutViewPath()
    {
        return '@app/views/'.$this->module->id.'/';
    }

    public function renderLayout($view, $params = [])
    {
        $content = $this->view->renderFile($this->getViewPath() . '/' .$view . '.php' , $params, $this);
        return $this->render($this->getModuleLayoutViewPath().$this->module->moduleLayout, ['content' => $content]);
    }
}
