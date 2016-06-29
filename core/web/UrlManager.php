<?php

namespace luya\web;

use Yii;
use luya\helpers\Url;
use yii\web\BadRequestHttpException;

/**
 * Extended LUYA UrlManager
 * 
 * UrlManger extends the Yii2 Url Manager by resolving composition informations while parseRequest and provides other helper methods.
 * 
 * @todo see http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#adding-rules-dynamically
 * @todo change to public $ruleConfig = ['class' => 'yii\web\UrlRule'];
 *
 * @author Basil Suter <basil@nadar.io>
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

    /**
     * Extend functionality of parent::parseRequest() by verify and resolve the composition informations.
     * 
     * {@inheritDoc}
     * @see \yii\web\UrlManager::parseRequest()
     */
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

    /**
     * Extend functionality of parent::addRules by the ability to add composition routes.
     * 
     * {@inheritDoc}
     * @see \yii\web\UrlManager::addRules()
     */
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

    /**
     * Get the menu component if its registered in the current applications.
     * 
     * @return boolean|\cms\menu\Container
     */
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

    /**
     * Get the composition component
     * 
     * @return \luya\web\Composition
     */
    public function getComposition()
    {
        if ($this->_composition === null) {
            $this->_composition = Yii::$app->get('composition');
        }

        return $this->_composition;
    }

    /**
     * Prepand the base url to an existing route
     * 
     * @param string $route The route where the base url should be prepend to.
     * @return string
     */
    public function prependBaseUrl($route)
    {
        return rtrim($this->baseUrl, '/').'/'.ltrim($route, '/');
    }

    /**
     * Remove the base url from a route
     * 
     * @param string $route The route where the baseUrl should be removed from.
     * @return mixed
     */
    public function removeBaseUrl($route)
    {
        return preg_replace('#'.preg_quote($this->baseUrl).'#', '', $route, 1);
    }

    /**
     * Extend createUrl method by verify its context implementation to add cms urls prepand to the requested createurl params.
     * 
     * {@inheritDoc}
     * @see \yii\web\UrlManager::createUrl()
     */
    public function createUrl($params)
    {
        $response = $this->internalCreateUrl($params);

        if ($this->contextNavItemId) {
            return $this->urlReplaceModule($response, $this->contextNavItemId, $this->getComposition());
        }

        return $response;
    }

    /**
     * Create an url for a menu item.
     * 
     * @param string|array $params Use a string to represent a route (e.g. `site/index`), or an array to represent a route with query parameters (e.g. `['site/index', 'param1' => 'value1']`).
     * @param integer $navItemId The nav item Id
     * @param null|\luya\web\Composition $composition Optional other composition config instead of using the default composition
     * @return string
     */
    public function createMenuItemUrl($params, $navItemId, $composition = null)
    {
        $composition = (empty($composition)) ? $this->getComposition() : $composition;
        $url = $this->internalCreateUrl($params, $composition);

        if (!$this->menu) {
            return $url;
        }

        return $this->urlReplaceModule($url, $navItemId, $composition);
    }

    /**
     * Yii2 createUrl base implementation extends the prepand of the comosition
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
    
    /**
     * Create absolute urls
     * 
     * @param string|array $params
     * @param bool $scheme
     * @return string
     */
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
}
