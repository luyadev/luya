<?php
namespace luya\base;

/**
 *
 * @author nadar
 */
class Controller extends \yii\web\Controller
{
    /**
     * Use the default behaviour of Yii. This will result in loading the templates inside the Modules
     *
     * @var boolean
     */
    public $useModuleViewPath = false;

    /**
     * Yii initializer
     *
     * @return void
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
        // use default yii behaviour
        if ($this->useModuleViewPath) {
            return parent::getViewPath();
        }
        // use client repository specific path
        return '@app/views/'.$this->module->id.'/'.$this->id;
    }
}
