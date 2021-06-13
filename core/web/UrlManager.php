<?php

namespace luya\web;

use Yii;

use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * Extended LUYA UrlManager.
 *
 * UrlManger extends the Yii2 Url Manager by resolving composition informations while parseRequest and provides other helper methods.
 *
 * @property boolean|\luya\cms\Menu $menu The menu componet if registered.
 * @property \luya\web\Composition $composition The composition component if registered.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class UrlManager extends \yii\web\UrlManager
{
    /**
     * Defines whether the {{luya\web\Composition}} should override the `Yii::$app->language` from its resolved value or not. If disabled
     * the Yii::$app->language won't be overriden but you can still access the resolved value with `Yii::$app->composition->langShortCode`.
     * 
     * Disabling this option can be usefull when working with a website which does not requires the LUYA CMS and you might enable multi lingual
     * content but on the same routes with a get param f.e. `?_lang=xyz` instead of `/xyz/<slug>`.
     * 
     * @since 2.0.0
     * @var boolean Whether the {{luya\web\Composition}} resolved value should override `Yii::$app->language` or not.
     */
    public $overrideLanguage = true;

    /**
     * @var boolean Pretty urls are enabled by default and can not be turned off in luya cms context.
     */
    public $enablePrettyUrl = true;

    /**
     * @var boolean As mod rewrite is required by a LUYA cms instance the script name must be turned off by default.
     */
    public $showScriptName = false;

    /**
     * @var array The default url rule configuration uses the {{\luya\web\UrlRule}} class.
     */
    public $ruleConfig = ['class' => 'luya\web\UrlRule'];

    /**
     * @var integer In order to build urls, the nav item id from cms module can be stored in the UrlManager as `$contextNavItemId`.
     *
     * This context setter is called in {{luya\cms\frontend\base\Controller::renderItem()}} method and is used when calling {{\luya\web\UrlManager::createUrl}} method.
     */
    public $contextNavItemId;

    private $_menu;

    private $_composition;

    /**
     * Ensure whether a route starts with a language short key or not.
     *
     * @param string $route The route to check `en/module/controller/action` or without `module/controller/action`
     * @param string $language The language to check whether it exists or not `en`.
     * @return boolean
     */
    public function routeHasLanguageCompositionPrefix($route, $language)
    {
        $parts = explode("/", $route);
        if (isset($parts[0]) && $parts[0] == $language) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Extend functionality of parent::parseRequest() by verify and resolve the composition informations.
     *
     * @inheritDoc
     *
     * @see \yii\web\UrlManager::parseRequest()
     * @param \luya\web\Request $request The request component.
     */
    public function parseRequest($request)
    {
        // extra data from request to composition, which changes the pathInfo of the Request-Object.
        $resolver = $this->getComposition()->getResolvedPathInfo($request);

        try {
            $request->setPathInfo($resolver->resolvedPath);
        } catch (NotFoundHttpException $error) {
            // the resolver has thrown an 404 excpetion, stop parsing request and return false (which is: page not found)
            return false;
        }
        
        $parsedRequest = parent::parseRequest($request);

        // if [[enablePrettyUrl]] is `false`. `false` is returned if the current request cannot be successfully parsed.
        if ($parsedRequest === false) {
            return false;
        }

        // ensure if the parsed route first match equals the composition pattern.
        // This can be the case when composition is hidden, but not default language is loaded and a
        // url composition route is loaded!
        // @see https://github.com/luyadev/luya/issues/1146
        $res = $this->routeHasLanguageCompositionPrefix($parsedRequest[0], $resolver->getResolvedKeyValue(Composition::VAR_LANG_SHORT_CODE));
        
        if ($this->overrideLanguage) {
            // set the application language based from the parsed composition request:
            Yii::$app->setLocale($this->composition->langShortCode);
            Yii::$app->language = $this->composition->langShortCode;
        }
        
        // if enableStrictParsing is enabled and the route is not found, $parsedRequest will return `false`.
        if ($res === false && ($this->composition->hidden || $parsedRequest === false)) {
            return $parsedRequest;
        }
        
        $composition = $this->composition->createRoute();
        $length = strlen($composition);
        $route = $parsedRequest[0];
        
        if (substr($route, 0, $length+1) == $composition.'/') {
            $parsedRequest[0] = substr($parsedRequest[0], $length);
        }
        
        // remove start trailing slashes from route.
        $parsedRequest[0] = ltrim($parsedRequest[0], '/');
        
        return $parsedRequest;
    }
    
    /**
     * Extend functionality of parent::addRules by the ability to add composition routes.
     *
     * @see \yii\web\UrlManager::addRules()
     * @param array $rules An array wil rules
     * @param boolean $append Append to the end of the rules or not.
     */
    public function addRules($rules, $append = true)
    {
        foreach ($rules as $key => $rule) {
            if (is_array($rule) && isset($rule['composition'])) {
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
     * The menu component is only registered when the cms module is registered.
     *
     * @return boolean|\luya\cms\Menu The menu component object or false if not available.
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
     * Setter method for the composition component.
     *
     * @param \luya\web\Composition $composition
     */
    public function setComposition(Composition $composition)
    {
        $this->_composition = $composition;
    }
    
    /**
     * Get the composition component
     *
     * @return \luya\web\Composition Get the composition component to resolve multi lingual handling.
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
     * @return string The route with prepanded baseUrl.
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
        return preg_replace('#'.preg_quote($this->baseUrl, '#').'#', '', $route, 1);
    }

    /**
     * Extend createUrl method by verify its context implementation to add cms urls prepand to the requested createurl params.
     *
     * From the original create url function of Yii:
     *
     * You may specify the route as a string, e.g., `site/index`. You may also use an array
     * if you want to specify additional query parameters for the URL being created. The
     * array format must be:
     *
     * ```php
     * // generates: /index.php?r=site%2Findex&param1=value1&param2=value2
     * ['site/index', 'param1' => 'value1', 'param2' => 'value2']
     * ```
     *
     * If you want to create a URL with an anchor, you can use the array format with a `#` parameter.
     * For example,
     *
     * ```php
     * // generates: /index.php?r=site%2Findex&param1=value1#name
     * ['site/index', 'param1' => 'value1', '#' => 'name']
     * ```
     *
     * The URL created is a relative one. Use [[createAbsoluteUrl()]] to create an absolute URL.
     *
     * Note that unlike {{luya\helpers\Url::toRoute()}}, this method always treats the given route
     * as an absolute route.
     *
     * @see \yii\web\UrlManager::createUrl()
     * @param string|array $params use a string to represent a route (e.g. `site/index`),
     * or an array to represent a route with query parameters (e.g. `['site/index', 'param1' => 'value1']`).
     * @return string the created URL.
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
        $composition = empty($composition) ? $this->getComposition() : $composition;
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
     * @param null|\luya\web\Composition $composition Composition instance to change the route behavior
     * @return string
     */
    public function internalCreateUrl($params, $composition = null)
    {
        $params = (array) $params;
        
        $composition = empty($composition) ? $this->getComposition() : $composition;
        
        $originalParams = $params;
        
        // prepand the original route, whether is hidden or not!
        // https://github.com/luyadev/luya/issues/1146
        $params[0] = $composition->prependTo($params[0], $composition->createRoute());
        
        $response = parent::createUrl($params);

        // Check if the parsed route with the prepand composition has been found or not.
        if (strpos($response, rtrim($params[0], '/')) !== false) {
            // we got back the same url from the createUrl, no match against composition route.
            $response = parent::createUrl($originalParams);
        }

        $response = $this->removeBaseUrl($response);
        $response = $composition->prependTo($response);

        return $this->prependBaseUrl($response);
    }
    
    /**
     * Create absolute url from the given route params.
     *
     * @param string|array $params The see createUrl
     * @param boolean $scheme Whether to use absolute scheme path or not.
     * @return string The created url
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
    
    /**
     * See if the module of a provided route exists in the luya application list.
     *
     * The module to test must be an instance of `luya\base\Module`.
     *
     * @param string $route
     * @return boolean|string
     */
    private function findModuleInRoute($route)
    {
        $route = parse_url($route, PHP_URL_PATH);
        
        $parts = array_values(array_filter(explode('/', $route)));
        
        if (isset($parts[0]) && array_key_exists($parts[0], Yii::$app->getApplicationModules())) {
            return $parts[0];
        }
    
        return false;
    }
    
    /**
     * Replace the url with the current module context.
     *
     * @param string $url The url to replace
     * @param integer $navItemId The navigation item where the context url to be found.
     * @param \luya\web\Composition $composition Composition component object to resolve language context.
     * @throws \yii\web\BadRequestHttpException
     * @return string The replaced string.
     */
    private function urlReplaceModule($url, $navItemId, Composition $composition)
    {
        $route = $composition->removeFrom($this->removeBaseUrl($url));
        $moduleName = $this->findModuleInRoute($route);
    
        if ($moduleName === false || $this->menu === false) {
            return $url;
        }
    
        $item = $this->menu->find()->where(['id' => $navItemId])->with('hidden')->lang($composition[Composition::VAR_LANG_SHORT_CODE])->one();
    
        if (!$item) {
            throw new BadRequestHttpException("Unable to find nav_item_id '$navItemId' to generate the module link for url '$url'.");
        }
    
        $isOutgoingModulePage = $item->type == 2 && $moduleName !== $item->moduleName;
        
        // 1. if the current page is a module and the requested url is not the same module, its an outgoing link to
        // another module which should not be modificated.
        // 2. If the current page (nav) context is the homepage, we have to keep the original link as it wont work because the homepage
        // does not have a route prefix.
        if ($isOutgoingModulePage || $item->isHome) {
            return $url;
        }
    
        // 1. if the current page is a module and the requested url is not the same module, its an outgoing link to
        // another module and ...
        // 2. if current controller context has an other module as the requested url, its an outgoing link to another module which should not be modificated.
        if ($isOutgoingModulePage && $moduleName !== Yii::$app->controller->module->id) {
            return $url;
        }

        return preg_replace("/$moduleName/", rtrim($item->link, '/'), ltrim($route, '/'), 1);
    }
}
