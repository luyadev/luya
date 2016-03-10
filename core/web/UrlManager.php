<?php

namespace luya\web;

use Yii;
use luya\helpers\Url;
use yii\web\BadRequestHttpException;

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

    public $contextNavItemId = null;

    private $_contextNavItemId = false;

    private $_menu = null;

    private $_composition = null;

    public function parseRequest($request)
    {
        // extra data from request to composition, which changes the pathInfo of the Request-Object.
        $resolver = $this->getComposition()->getResolvedPathInfo($request);
        
        $request->setPathInfo($resolver['route']);
        
        $parsedRequest = parent::parseRequest($request);

        if ($this->getComposition()->hidden) {
            return $parsedRequest;
        }
        // temp write variables
        $composition = $this->getComposition()->full;
        $length = strlen($composition);
        $route = $parsedRequest[0];
        // route matches composition exactly, so we have to remove the composition informations
        if ($route === $composition) {
            $parsedRequest[0] = false;
        // now see if the composition (+1 as we add add trailing slash at the end) matches the cutted route request part, if so its composition prefix, remove it.
        } elseif (substr($route, 0, $length+1) == $composition.'/') {
            $parsedRequest[0] = substr($parsedRequest[0], $length);
        }
        // fix broken request urls
        if ($parsedRequest[0] === false || $parsedRequest[0] == '/') {
            $parsedRequest[0] = '';
        }
        // ltrim all request to fix request routes
        $parsedRequest[0] = ltrim($parsedRequest[0], '/');
        // return new parsted request route
        return $parsedRequest;
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

    public function prependBaseUrl($route)
    {
        return rtrim($this->baseUrl, '/').'/'.ltrim($route, '/');
    }

    public function removeBaseUrl($route)
    {
        return preg_replace('#'.preg_quote($this->baseUrl).'#', '', $route, 1);
    }

    public function createUrl($params)
    {
        $response = $this->internalCreateUrl($params);

        if ($this->contextNavItemId) {
            return $this->urlReplaceModule($response, $this->contextNavItemId, $this->getComposition());
        }

        return $response;
    }

    public function createMenuItemUrl($params, $navItemId, $composition = null)
    {
        $composition = (empty($composition)) ? $this->getComposition() : $composition;
        $url = $this->internalCreateUrl($params, $composition);

        if (!$this->menu) {
            return $url;
        }

        return $this->urlReplaceModule($url, $navItemId, $composition);
    }

    private function findModuleInRoute($route)
    {
        $parts = array_values(array_filter(explode('/', $route)));

        if (isset($parts[0])) {
            if (array_key_exists($parts[0], Yii::$app->getApplicationModules())) {
                return $parts[0];
            }
        }

        return false;
    }

    private function urlReplaceModule($url, $navItemId, \luya\web\Composition $composition)
    {
        $route = $this->removeBaseUrl($url);
        $route = $composition->removeFrom($route);
        $module = $this->findModuleInRoute($route);

        if (!$module) {
            return $url;
        }
        
        
        $item = $this->menu->find()->where(['id' => $navItemId])->with('hidden')->lang($composition['langShortCode'])->one();
        
        if (!$item) {
            throw new BadRequestHttpException("Unable to find nav_item_id '$navItemId' to generate the module link for url '$url'.");
        }
        
        // if the item type is (2) module and the current context module is not equals we don't have to remove to replace the module name
        // as this is an url rule not related to the current module.
        if ($item->type == 2) {
            if ($module !== $item->moduleName) {
                return $url;
            }
        }
        
        $replaceRoute = preg_replace("/$module/", rtrim($item->link, '/'), ltrim($route, '/'), 1);

        return $replaceRoute;
    }

    /**
     * 
     * @param string|array $params An array with params or not (e.g. `['module/controller/action', 'param1' => 'value1']`)
     * @param null|object $composition Composition instance to change the route behavior
     * @return string
     */
    public function internalCreateUrl($params, $composition = null)
    {
        $params = (array) $params;
        
        $composition = (empty($composition)) ? $this->getComposition() : $composition;
        
        $originalParams = $params;
        // creata parameter where route contains a composition
        $params[0] = $composition->prependTo($params[0]);

        $response = parent::createUrl($params);

        // check if the parsed route is the same as before, if
        if (strpos($response, $params[0]) !== false) {
            // we got back the same url from the createUrl, no match against composition route.
            $response = parent::createUrl($originalParams);
        }

        $response = $this->removeBaseUrl($response);
        $response = $composition->prependTo($response);

        return $this->prependBaseUrl($response);
    }
    
    public function internalCreateAbsoluteUrl($params, $scheme = null)
    {
        $params = (array) $params;
        $url = $this->internalCreateUrl($params);
        if (strpos($url, '://') === false) {
            $url = $this->getHostInfo() . $url;
        }
        if (is_string($scheme) && ($pos = strpos($url, '://')) !== false) {
            $url = $scheme . substr($url, $pos);
        }
        return $url;
    }
}
