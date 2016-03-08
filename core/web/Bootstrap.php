<?php

namespace luya\web;

use yii\helpers\ArrayHelper;

/**
 * @author nadar
 */
class Bootstrap extends \luya\base\Bootstrap
{
    private $_apis = [];

    private $_urlRules = [];

    private $_adminAssets = [];

    private $_adminMenus = [];
    
    private $_jsTranslations = [];
    
    /**
     * @todo see if the api already exstis, api urls must be unique (otherwise the auth process will not work anymore)
     */
    public function beforeRun($app)
    {
        foreach ($this->getModules() as $id => $module) {
            foreach ($module->urlRules as $k => $v) {
                if (isset($v['position'])) {
                    $pos = $v['position'];
                } else {
                    $pos = \luya\web\UrlRule::POSITION_AFTER_LUYA;
                }
                
                $this->_urlRules[$pos][] = $v;
            }

            foreach ($module->apis as $alias => $class) {
                $this->_apis[$alias] = $class;
            }
        }
    }

    public function run($app)
    {
        // start the module now
        foreach ($this->getModules() as $id => $module) {
            if ($module->isAdmin) {
                $this->_adminAssets = ArrayHelper::merge($module->assets, $this->_adminAssets);
                $this->_adminMenus = ArrayHelper::merge($module->getMenu(), $this->_adminMenus);
                $this->_jsTranslations[$id] = $module->registerJsTranslation;
            }
        }

        if (!$app->request->getIsConsoleRequest()) {
            if ($this->hasModule('admin') && $app->request->isAdmin()) {
                //$app->getModule('admin')->controllerMap = $this->_apis;
                $app->getModule('admin')->assets = ArrayHelper::merge($this->_adminAssets, $app->getModule('admin')->assets);
                $app->getModule('admin')->controllerMap = $this->_apis;
                $app->getModule('admin')->moduleMenus = $this->_adminMenus;
                $app->getModule('admin')->setJsTranslations($this->_jsTranslations);
            }
        }
        
        ksort($this->_urlRules);
        
        foreach ($this->_urlRules as $position => $rules) {
            $app->getUrlManager()->addRules($rules);
        }
    }
}
