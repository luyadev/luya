<?php

namespace luya\base;

/**
 * @author nadar
 */
class Controller extends \yii\web\Controller
{
    /**
     * Use the default behaviour of Yii. This will result in loading the templates inside the Modules.
     *
     * @var bool
     */
    public $useModuleViewPath = false;

    /**
     * Yii initializer.
     */
    public function init()
    {
        // call parent
        parent::init();
        // get asset bundles which are defined in the module and register them into the view
        foreach ($this->module->assets as $class) {
            // autoload $class and register with current view
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
        if (!empty($this->module->getContext()) && empty($this->layout)) {
            return $this->renderPartial($view, $params);
        }

        return parent::render($view, $params);
    }

    public function getModuleLayoutViewPath()
    {
        return '@app/views/'.$this->module->id.'/';
    }

    public function renderLayout($params = [])
    {
        return $this->render($this->getModuleLayoutViewPath().$this->module->moduleLayout, $params);
    }
}
