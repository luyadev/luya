<?php
namespace luya\components;

use yii;
use yii\base\Application;
use yii\helpers\ArrayHelper;

class Bootstrap implements \yii\base\BootstrapInterface
{
    private $_modules = [];
    
    private $_modulePropertys = [];
    
    private $_apis = [];
    
    public function bootstrap($app)
    {
        $this->expand($app->getModules());
        $this->beforeRun();
        $this->run();
    }
    
    private function expand($modules)
    {
        foreach($modules as $id => $class) {
            $this->_modules[$id] = [
                'id' => $id,
                'class' => $class,
                'reflection' => $this->getReflectionProperties($class)
            ];
        }
    }
    
    private function beforeRun()
    {
        foreach($this->_modules as $item) {
            // collect all static api properties
            if ($item['reflection']->hasProperty('apis')) {
                $prop = $item['reflection']->getProperty('apis')->getValue();
                foreach ($prop as $alias => $class) {
                    $this->_apis[] = [
                        'moduleId' => $item['id'],
                        'class' => $class,
                        'alias' => $alias
                    ];
                }
            }
            // set admin property
            $this->_modules[$item['id']]['isAdmin'] = ($item['reflection']->hasProperty('isAdmin')) ? true : false;
        }
        
        // set params
        $this->addParam('apis', $this->_apis);
    }
    
    private function run()
    {
        $adminAssets = [];
        $adminMenus = [];
        
        // start the module now
        foreach ($this->_modules as $id => $item) {
            $module = yii::$app->getModule($item['id']);
            $path = $module->getBasePath();
            Yii::setAlias("@$id", $path);
            if ($item['isAdmin']) {
                $adminAssets = ArrayHelper::merge($module->assets, $adminAssets);
                $adminMenus = ArrayHelper::merge($module->getMenu(), $adminMenus);
            }
        }
        
        // change thos names
        $this->addParam('adminAssets', $adminAssets);
        $this->addParam('modulesMenu', $adminMenus);
    }
    
    private function addParam($param, $value)
    {
        yii::$app->params[$param] = $value;
    }
    
    public function getReflectionProperties($class)
    {
        return new \ReflectionClass($class);
        //return $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
    }
    
}