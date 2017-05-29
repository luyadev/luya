<?php

namespace luya\base;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Base class for luya bootsrapping proccess.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class BaseBootstrap implements BootstrapInterface
{
    /**
     * @var array Readonly variable contains all module Objects.
     */
    private $_modules;

    /**
     * Boostrap method will be invoken by Yii Application bootrapping proccess containing
     * the Application ($app) Object to get/set data.
     *
     * @param object $app Luya Application `luya\base\Application`.
     */
    public function bootstrap($app)
    {
        // add trace
        Yii::beginProfile('LUYA Boostrap process profiling', __METHOD__);
        
        $this->extractModules($app);
        $this->beforeRun($app);
        $this->registerComponents($app);
        $this->run($app);
        
        // end trace
        Yii::trace('End of the LUYA bootstraping process', __METHOD__);
        Yii::endProfile('LUYA Boostrap process profiling');
    }

    /**
     * Extract and load all modules from the Application-Object.
     *
     * @param object $app Luya Application `luya\base\Application`.
     */
    public function extractModules($app)
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
            // when no luya modules are registered an empty array will be returned.
            if ($this->_modules === null) {
                $this->_modules = [];
            }
        }
    }

    /**
     * Check if a Module exists in the module list `getModules()`.
     *
     * @param string $module The name of the Module
     * @return bool
     */
    public function hasModule($module)
    {
        return array_key_exists($module, $this->_modules);
    }

    /**
     * Return all modules prepared by `extractModules()` method.
     *
     * @return array An array containg all modules where the key is the module name and the value is the Module Object `luya\base\Module`.
     */
    public function getModules()
    {
        return $this->_modules;
    }

    /**
     * Register all components from the modules `registerComponents()` method to the
     * Applcation.
     *
     * @param object $app Luya Appliation `\luya\base\Application`.
     */
    private function registerComponents($app)
    {
        foreach ($this->getModules() as $id => $module) {
            // set an alias for all user modules
            Yii::setAlias('@'.$id, $module->getBasePath());
            // see if the module has a registerComponents method
            foreach ($module->registerComponents() as $componentId => $definition) {
                if (!$app->has($componentId)) {
                    Yii::trace('Register component ' . $componentId, __METHOD__);
                    $app->set($componentId, $definition);
                }
            }
        }
    }

    /**
     * This method will be invoke before the `run()` method.
     *
     * @param object $app Luya Application `luya\base\Application`
     */
    abstract public function beforeRun($app);

    /**
     * This method will be invoke after the `beforeRun()` method.
     *
     * @param object $app Luya Application `luya\base\Application`
     */
    abstract public function run($app);
}
