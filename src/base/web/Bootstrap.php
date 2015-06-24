<?php

namespace luya\base\web;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * @todo rename to WebBootstrap and inherite the base Bootstrap class and add the web specific bootstrap stuff (like url manager)
 *
 * @author nadar
 */
class Bootstrap extends \luya\base\Bootstrap
{
    private $_apis = [];

    private $_urlRules = [];

    private $_adminAssets = [];

    private $_adminMenus = [];

    /**
     * @todo see if the api already exstis, api urls must be unique (otherwise the auth process will not work anymore)
     */
    public function beforeRun($app)
    {
        foreach($this->getModules() as $id => $module) {
            
            foreach ($module->urlRules as $k => $v) {
                $this->_urlRules[] = $v;
            }
            
            foreach($module->apis as $alias => $class) {
                $this->_apis[$alias] = $class;
                /*
                    'moduleId' => $id,
                    'class' => $class,
                    'alias' => $alias,
                ];
                */
            }
        }
        /*
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
        */
    }

    public function run($app)
    {
        // start the module now
        foreach ($this->getModules() as $id => $module) {
            if ($module->isAdmin) {
                $this->_adminAssets = ArrayHelper::merge($module->assets, $this->_adminAssets);
                $this->_adminMenus = ArrayHelper::merge($module->getMenu(), $this->_adminMenus);
            }
        }
        
        if ($this->hasModule('admin')) {
            $app->getModule('admin')->controllerMap = $this->_apis;
            $app->getModule('admin')->assets = ArrayHelper::merge($this->_adminAssets, $app->getModule('admin')->assets);
            $app->getModule('admin')->controllerMap = $this->_apis;
            $app->getModule('admin')->moduleMenus = $this->_adminMenus;
        }
        
        $app->getUrlManager()->addRules($this->_urlRules, false);
        // set params
        //Param::set('adminAssets', $this->_adminAssets);
        //Param::set('adminMenus', $this->_adminMenus);
    }
}
