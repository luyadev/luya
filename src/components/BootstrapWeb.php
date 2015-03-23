<?php
namespace luya\components;

use yii\helpers\ArrayHelper;
use luya\helpers\Param;

/**
 * @todo rename to WebBootstrap and inherite the base Bootstrap class and add the web specific bootstrap stuff (like url manager)
 *
 * @author nadar
 */
class BootstrapWeb extends \luya\base\Bootstrap
{
    private $_apis = [];

    private $_urlRules = [];

    private $_adminAssets = [];

    private $_adminMenus = [];

    public function beforeRun()
    {
        foreach ($this->getModules() as $item) {
            // get static urlRules array
            if (($urlRules = $this->getReflectionPropertyValue($item['reflection'], 'urlRules')) !== false) {
                foreach ($urlRules as $k => $v) {
                    $this->_urlRules[] = $v;
                }
            }
            // get static apis array
            if (($apis = $this->getReflectionPropertyValue($item['reflection'], 'apis')) !== false) {
                foreach ($apis as $alias => $class) {
                    $this->_apis[] = [
                    'moduleId' => $item['id'],
                    'class' => $class,
                    'alias' => $alias,
                    ];
                }
            }
        }
        // set this params into the application, cause $app->getUrlManager->addRules() in the run method will use those params.
        Param::set('urlRules', $this->_urlRules);
        Param::set('apis', $this->_apis);
    }

    public function run($app)
    {
        // start the module now
        foreach ($this->getModules() as $item) {
            $module = \yii::$app->getModule($item['id']);

            // get static urlRules property


            $id = $item['id'];
            $path = $module->getBasePath();
            \yii::setAlias("@$id", $path);

            if ($item['reflection']->hasProperty('isAdmin')) {
                $this->_adminAssets = ArrayHelper::merge($module->assets, $this->_adminAssets);
                $this->_adminMenus = ArrayHelper::merge($module->getMenu(), $this->_adminMenus);
            }
        }

        $app->getUrlManager()->addRules($this->_urlRules, false);
        // set params
        Param::set('adminAssets', $this->_adminAssets);
        Param::set('adminMenus', $this->_adminMenus);
    }
}
