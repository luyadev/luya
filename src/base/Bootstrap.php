<?php

namespace luya\base;

use yii;

/**
 * create basic bootstraping which is allowed for console and web components.
 *
 * @author nadar
 */
abstract class Bootstrap implements \yii\base\BootstrapInterface
{
    private $_modules = [];

    public function bootstrap($app)
    {
        $this->expand($app->getModules());
        $this->beforeRun();
        $this->configLuyaComponents();
        $this->run($app);
    }

    private function configLuyaComponents()
    {
        foreach ($this->getModules() as $item) {
            $module = yii::$app->getModule($item['id']);

            // set the yii alias for each module
            $id = $item['id'];
            $path = $module->getBasePath();
            \yii::setAlias("@$id", $path);

            if (method_exists($module, 'getLuyaComponents')) {
                foreach ($module->getLuyaComponents() as $key => $value) {
                    \yii::$app->luya->$key = $value;
                }
            }
        }
    }

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

    public function beforeRun()
    {
    }

    abstract public function run($app);
}
