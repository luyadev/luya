<?php

namespace luya\web;

use yii\helpers\ArrayHelper;
use luya\base\AdminModuleInterface;
use luya\TagParser;

/**
 * LUYA base bootstrap class which will be called during the bootstraping process.
 *
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
        foreach ($app->tags as $name => $config) {
            TagParser::inject($name, $config);
        }
        
        foreach ($this->getModules() as $id => $module) {
            foreach ($module->urlRules as $rule) {
                $this->_urlRules[(isset($rule['position'])) ? $rule['position'] : UrlRule::POSITION_AFTER_LUYA][] = $rule;
            }
            
            foreach ($module->apis as $alias => $class) {
                $this->_apis[$alias] = $class;
            }
            
            foreach ($module->tags as $name => $config) {
                TagParser::inject($name, $config);
            }
        }
    }

    /**
     * Invokes the bootstraping process.
     * 
     * @see \luya\base\Bootstrap::run()
     */
    public function run($app)
    {
        if (!$app->request->getIsConsoleRequest()) {
            if ($this->hasModule('admin') && $app->request->isAdmin()) {
                foreach ($this->getModules() as $id => $module) {
                    if ($module instanceof AdminModuleInterface) {
                        $this->_adminAssets = ArrayHelper::merge($module->assets, $this->_adminAssets);
                        $this->_adminMenus[$module->id] = $module->getMenu();
                        $this->_jsTranslations[$id] = $module->registerJsTranslation;
                    }
                }
                
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
