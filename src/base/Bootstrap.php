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
        //$this->setModules($app->getModules());
        //$this->expand($app->getModules());
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
            foreach($app->getModules() as $id => $obj) {
                $this->_modules[$id] = Yii::$app->getModule($id);
            }
        }
    }
    
    public function getModules()
    {
        return $this->_modules;
    }

    /*
    private function setModules(array $modules)
    {
        foreach($modules as $id => $obj) {
            $this->_modules[$id] = Yii::$app->getModule($id);
        }
    }
    */
    private function registerComponents($app)
    {
        foreach ($this->getModules() as $id => $module) {
            
            Yii::setAlias("@".$id, $module->getBasePath());

            if (method_exists($module, 'registerComponents')) {
                foreach($module->registerComponents() as $componentId => $definition) {
                    $app->set($componentId, $definition);
                }
            }
        }
    }

    /*
    protected function getModule($key)
    {
        return (array_key_exists($key, $this->_modules)) ? $this->_modules[$key] : false;
    }

    protected function getModules()
    {
        return $this->_modules;
    }

    private function expand($modules)
    {
        foreach ($modules as $id => $class) {
            // avoid exception if the module defintions looks like this ['cms' => ['class' => 'path/to/class']]
            if (is_array($class)) {
                $class = $class['class'];
            }

            $this->_modules[] = [
                'id' => $id,
                'class' => $class,
                'reflection' => new \ReflectionClass($class),
            ];
        }
    }

    protected function getReflectionPropertyValue($reflection, $property)
    {
        if ($reflection->hasProperty($property)) {
            return $reflection->getProperty($property)->getValue();
        }

        return false;
    }
    */

    abstract public function beforeRun($app);

    abstract public function run($app);
}
