<?php
namespace luya\components;

use yii;
use yii\helpers\ArrayHelper;
use luya\Luya;

class Bootstrap implements \yii\base\BootstrapInterface
{
    private $_modules = [];

    private $_apis = [];

    public function bootstrap($app)
    {
        $this->expand($app->getModules());
        $this->beforeRun();
        $this->run();
    }

    private function expand($modules)
    {
        foreach ($modules as $id => $class) {
            // avoid exception if the module defintions looks like this ['cms' => ['class' => 'path/to/class']]
            if (is_array($class)) {
                $class = $class['class'];
            }

            $this->_modules[$id] = [
                'id' => $id,
                'class' => $class,
                'reflection' => new \ReflectionClass($class),
            ];
        }
    }

    private function beforeRun()
    {
        foreach ($this->_modules as $item) {
            // collect static apis property
            if ($item['reflection']->hasProperty('apis')) {
                $prop = $item['reflection']->getProperty('apis')->getValue();
                foreach ($prop as $alias => $class) {
                    $this->_apis[] = [
                        'moduleId' => $item['id'],
                        'class' => $class,
                        'alias' => $alias,
                    ];
                }
            }
            // set admin property
            $this->_modules[$item['id']]['isAdmin'] = ($item['reflection']->hasProperty('isAdmin')) ? true : false;
        }
        // set params before boot
        luya::setParams('apis', $this->_apis);
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
        // set the parameters to yii via luya::setParams
        luya::setParams('adminAssets', $adminAssets);
        luya::setParams('adminMenus', $adminMenus);
    }
}
