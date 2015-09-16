<?php

namespace luya\base;

use Yii;

/**
 * create basic bootstraping which is allowed for console and web components.
 *
 * @author nadar
 */
abstract class Bootstrap implements \yii\base\BootstrapInterface
{
    public $_modules = null;

    public $app = null;

    public function bootstrap($app)
    {
        $this->setModules($app);
        $this->beforeRun($app);
        $this->registerComponents($app);
        $this->run($app);
    }

    public function hasModule($module)
    {
        return array_key_exists($module, $this->_modules);
    }

    public function setModules($app)
    {
        if ($this->_modules === null) {
            foreach ($app->getModules() as $id => $obj) {
                // create module object
                $moduleObject = Yii::$app->getModule($id);
                // see if the module is a luya base module, otherwise ignore
                if ($moduleObject instanceof \luya\base\Module) {
                    $this->_modules[$id] = $moduleObject;
                }
            }
        }
    }

    public function getModules()
    {
        return $this->_modules;
    }

    private function registerComponents($app)
    {
        foreach ($this->getModules() as $id => $module) {
            Yii::setAlias('@'.$id, $module->getBasePath());

            if (method_exists($module, 'registerComponents')) {
                foreach ($module->registerComponents() as $componentId => $definition) {
                    $app->set($componentId, $definition);
                }
            }
        }
    }

    abstract public function beforeRun($app);

    abstract public function run($app);
}
