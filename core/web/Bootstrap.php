<?php

namespace luya\web;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use luya\base\AdminModuleInterface;
use luya\TagParser;
use luya\base\BaseBootstrap;

/**
 * LUYA base bootstrap class which will be called during the bootstraping process.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Bootstrap extends BaseBootstrap
{
    private $_apis = [];

    private $_urlRules = [];
    
    private $_apiRules = [];

    private $_adminAssets = [];

    private $_adminMenus = [];
    
    private $_jsTranslations = [];
    
    /**
     * Before bootstrap run process.
     *
     * @param Application $app
     * @see \luya\base\BaseBootstrap::beforeRun()
     */
    public function beforeRun($app)
    {
        foreach ($app->tags as $name => $config) {
            TagParser::inject($name, $config);
        }
        
        foreach ($this->getModules() as $id => $module) {
            foreach ($module->urlRules as $key => $rule) {
                if (is_string($key)) {
                    $this->_urlRules[$key] = $rule;
                } else {
                    $this->_urlRules[] = $rule;
                }
            }
            
            // get all api rules (since 1.0.10)
            foreach ($module->apiRules as $endpoint => $rule) {
                $this->_apiRules[$endpoint] = $rule;
            }
            
            /**
             * 'api-admin-user' => 'admin\apis\UserController',
             * 'api-cms-navcontainer' => 'admin\apis\NavContainerController'
             */
            foreach ($module->apis as $alias => $class) {
                $this->_apis[$alias] = ['class' => $class, 'module' => $module];
            }
            
            foreach ($module->tags as $name => $config) {
                TagParser::inject($name, $config);
            }
        }
    }

    /**
     * Generate the rest rule defintions for {{luya\admin\Module::$apiDefintions}}.
     *
     * @param array $apis The array of apis where key is the api name `['api-admin-user' => 'admin\apis\UserController', ...]`.
     * @param array $rules The new {{luya\base\Module::$apiRules}} defintion `['api-admin-user' => [...], 'api-admin-group' => []]`.
     * @return array
     */
    protected function generateApiRuleDefintions(array $apis, array $rules)
    {
        // generate the url rules which are collected as ONE with an array of controllers:
        $collection = [];
        foreach ($apis as $alias => $array) {
            if (!isset($rules[$alias])) {
                $collection[] = 'admin/'.$alias;
            }
        }
        
        $result = [];
        $result[] = ['controller' => $collection];
        
        // generate the rules from apiRules defintions as they are own entries:
        foreach ($rules as $api => $rule) {
            $rule['controller'] = 'admin/' . $api;
            $result[] = $rule;
        }
        
        return $result;
    }

    /**
     * Invokes the bootstraping process.
     *
     * @param Application $app
     * @see \luya\base\BaseBootstrap::run()
     */
    public function run($app)
    {
        if (!$app->request->getIsConsoleRequest()) {
            if ($this->hasModule('admin') && $app->request->isAdmin) {
                // When admin context, change csrf token, this will not terminate the frontend csrf token:
                // @see https://github.com/luyadev/luya/issues/1778
                $app->request->csrfParam = '_csrf_admin';
                
                foreach ($this->getModules() as $id => $module) {
                    if ($module instanceof AdminModuleInterface) {
                        $this->_adminAssets = ArrayHelper::merge($module->getAdminAssets(), $this->_adminAssets);
                        if ($module->getMenu()) {
                            $this->_adminMenus[$module->id] = $module->getMenu();
                        }
                        $this->_jsTranslations[$id] = $module->getJsTranslationMessages();
                    }
                }
                
                $app->getModule('admin')->assets = $this->_adminAssets;
                $app->getModule('admin')->controllerMap = $this->_apis;
                $app->getModule('admin')->moduleMenus = $this->_adminMenus;
                $app->getModule('admin')->setJsTranslations($this->_jsTranslations);
                
                // calculate api defintions
                if ($app->getModule('admin')->hasProperty('apiDefintions')) { // ensure backwards compatibility
                    $app->getModule('admin')->apiDefintions = $this->generateApiRuleDefintions($this->_apis, $this->_apiRules);
                }
                // as the admin module needs to listen for $apiDefintions we have to get the urlRules from the admin and merge with the existing rules:
                // in admin context, admin url rules have always precedence over frontend rules.
                $this->_urlRules = array_merge($app->getModule('admin')->urlRules, $this->_urlRules);
            } else {
                // Frontend context
                $app->themeManager->setup();
            }
        }
        
        $app->getUrlManager()->addRules($this->_urlRules);
    }
}
