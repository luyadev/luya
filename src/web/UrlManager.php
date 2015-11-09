<?php

namespace luya\web;

use Yii;
use luya\helpers\Url;

/**
 * @todo see http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#adding-rules-dynamically
 * @todo change to public $ruleConfig = ['class' => 'yii\web\UrlRule'];
 *
 * @author nadar
 */
class UrlManager extends \yii\web\UrlManager
{
    public $enablePrettyUrl = true;

    public $showScriptName = false;

    public $ruleConfig = ['class' => '\luya\web\UrlRule'];

    private $_contextNavItemId = false;

    private $_menu = null;

    private $_composition = null;
    
    public function parseRequest($request)
    {
        $route = parent::parseRequest($request);

        if (Yii::$app->composition->hidden) {
            return $route;
        }

        $composition = Yii::$app->composition->getFull();

        $length = strlen($composition);
        if (substr($route[0], 0, $length) == $composition) {
            $route[0] = substr($route[0], $length);
        }

        return $route;
    }

    public function addRules($rules, $append = true)
    {
        foreach ($rules as $key => $rule) {
            if (isset($rule['composition'])) {
                foreach ($rule['composition'] as $composition => $pattern) {
                    $rules[] = [
                        'pattern' => $pattern,
                        'route' => $composition.'/'.$rule['route'],
                    ];
                }
            }
        }

        return parent::addRules($rules, $append);
    }

    public function setContextNavItemId($navItemId)
    {
        $this->_contextNavItemId = $navItemId;
    }

    public function getContextNavItemId()
    {
        return $this->_contextNavItemId;
    }

    public function resetContext()
    {
        $this->_contextNavItemId = false;
    }

    public function getMenu()
    {
        if ($this->_menu === null) {
            $menu = Yii::$app->get('menu', false);
            if ($menu) {
                $this->_menu = $menu;
            } else {
                $this->_menu = false;
            }
        }
        
        return $this->_menu;
    }
    
    public function getComposition()
    {
        if ($this->_composition === null) {
            $this->_composition = Yii::$app->get('composition');
        }
        
        return $this->_composition;
    }
    
    private function removeBaseUrl($route)
    {
        $baseUrl = preg_quote($this->baseUrl);
        
        return preg_replace("#$baseUrl#", "", $route, 1);
    }
    
    public function prependBaseUrl($route)
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($route, '/');
    }
    
    private function findModuleInRoute($route)
    {
        $parts = array_values(array_filter(explode("/", $route)));
        
        if (isset($parts[0])) {
            if (array_key_exists($parts[0], Yii::$app->getApplicationModules())) {
                return $parts[0];
            }
        }
        
        return false;
    }
    
    public function createMenuItemUrl($params, $navItemId)
    {
        $url = $this->createUrl($params);
        
        if (!$this->menu) {
            return $url;
        }
        
        return $this->urlReplaceModule($url, $navItemId);
    }
    
    private function urlReplaceModule($url, $navItemId)
    {
        $route = $this->removeBaseUrl($url);
        $route = $this->composition->removeFrom($route);
        $module = $this->findModuleInRoute($route);
        
        if (!$module) {
            return $url;
        }
        
        $item = $this->menu->find()->where(['id' => $navItemId])->with('hidden')->one();
        
        
        $replaceRoute = preg_replace("/$module/", $item->link, ltrim($route, "/"), 1);
        
        return $replaceRoute;
    }
    
    public function createUrl($params)
    {
        $originalParams = $params;
        // creata parameter where route contains a composition
        $params[0] = $this->composition->prependTo($params[0]);
        
        $response = parent::createUrl($params);

        // check if the parsed route is the same as before, if
        if (strpos($response, $params[0]) !== false) {
            // we got back the same url from the createUrl, no match against composition route.
            $response = parent::createUrl($originalParams);
        }
        
        $response = $this->removeBaseUrl($response);
        $response = $this->composition->prependTo($response);
        $response = $this->prependBaseUrl($response);
        
        if ($this->contextNavItemId) {
            return $this->urlReplaceModule($response, $this->contextNavItemId);
        }
        
        return $response;
    }
    
    /*
     * old createUrl function
    public function createUrl($params)
    {
        $menu = Yii::$app->get('menu', false);

        $composition = Yii::$app->composition->getFull();

        $originalParams = $params;

        $params[0] = $composition.$params[0];

        $response = parent::createUrl($params);

        // we have not found the composition rule matching against rules, so use the original params and try again!
        if (strpos($response, $params[0]) !== false) {
            $params = $originalParams;
            $response = parent::createUrl($params);
        } else {
            // now we have to remove the composition informations from the links to make a valid link parsing (read module)
            $params[0] = str_replace($composition, '', $params[0]);
        }

        $params = (array) $params;
        $moduleName = \luya\helpers\Url::fromRoute($params[0], 'module');

        if ($this->getContextNavItemId() && $menu) {
            $menuItem = $menu->find()->where(['id' => $this->getContextNavItemId()])->with('hidden')->one();
            $this->resetContext();

            return Url::startTrailing(preg_replace("/$moduleName/", $menuItem->link, $response, 1));
        }

        if ($moduleName !== false) {
            $moduleObject = Yii::$app->getModule($moduleName);
            if (method_exists($moduleObject, 'setContext') && !empty($moduleObject->context) && $menu) {
                $options = $moduleObject->getContextOptions();
                $menuItem = $menu->find()->where(['id' => $options['navItemId']])->with('hidden')->one();

                return Url::startTrailing(preg_replace("/$moduleName/", $menuItem->link, $response, 1));
            }
        }

        // because the urlCreation of yii returns a realtive url we have to manualy add the composition getFull() path.
        $baseUrl = Yii::$app->request->baseUrl;

        if (empty($baseUrl)) {
            return Url::startTrailing(Url::removeTrailing($composition).$response);
        }

        return str_replace($baseUrl, Url::trailing($baseUrl).Url::removeTrailing($composition), $response);
    }
    */
}
