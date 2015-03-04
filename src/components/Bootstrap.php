<?php
namespace luya\components;

use yii;
use yii\helpers\ArrayHelper;
use luya\Luya;

class Bootstrap implements \yii\base\BootstrapInterface
{
    private $_modules = [];

    private $_apis = [];

    private $_urlRules = [];

    public function bootstrap($app)
    {
        $this->expand($app->getModules());
        $this->beforeRun();
        $this->run($app);
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

    private function getReflectionPropertyValue($reflection, $property)
    {
        if ($reflection->hasProperty($property)) {
            return $reflection->getProperty($property)->getValue();
        }

        return false;
    }

    /**
     * @todo change urlRules bootstraping, see: https://github.com/yiisoft/yii2/blob/master/extensions/gii/Module.php#L85
     */
    private function beforeRun()
    {
        foreach ($this->_modules as $key => $item) {
            // get static urlRules property
            if (($urlRules = $this->getReflectionPropertyValue($item['reflection'], 'urlRules')) !== false) {
                foreach ($urlRules as $k => $v) {
                    $this->_urlRules[] = $v;
                }
            }

            // get static apis property
            if (($apis = $this->getReflectionPropertyValue($item['reflection'], 'apis')) !== false) {
                foreach ($apis as $alias => $class) {
                    $this->_apis[] = [
                        'moduleId' => $item['id'],
                        'class' => $class,
                        'alias' => $alias,
                    ];
                }
            }

            // get and set admin property
            $this->_modules[$key]['isAdmin'] = ($item['reflection']->hasProperty('isAdmin')) ? true : false;
        }
        // set urlRoultes param
        luya::setParams('urlRules', $this->_urlRules);
        // set params before boot
        luya::setParams('apis', $this->_apis);
    }

    private function run($app)
    {
        $adminAssets = [];
        $adminMenus = [];
        // start the module now
        foreach ($this->_modules as $item) {
            $module = yii::$app->getModule($item['id']);
            
            foreach ($module->getLuyaConfig() as $key => $value) {
                \yii::$app->luya->$key = $value;
            }
            
            $id = $item['id'];
            $path = $module->getBasePath();
            Yii::setAlias("@$id", $path);
            if ($item['isAdmin']) {
                $adminAssets = ArrayHelper::merge($module->assets, $adminAssets);
                $adminMenus = ArrayHelper::merge($module->getMenu(), $adminMenus);
            }
        }

        $app->getUrlManager()->addRules($this->_urlRules, false);

        // set the parameters to yii via luya::setParams
        luya::setParams('adminAssets', $adminAssets);
        luya::setParams('adminMenus', $adminMenus);
    }
}
