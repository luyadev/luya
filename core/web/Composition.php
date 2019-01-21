<?php

namespace luya\web;

use Yii;
use yii\base\Component;
use yii\web\ForbiddenHttpException;
use luya\Exception;
use luya\helpers\StringHelper;

/**
 * Composition parseRequest Handler.
 *
 * The composition is run for every {{luya\web\UrlManager::parseRequest()}} call in order to determine
 * the language of the application based on {{luya\web\Composition::$hostInfoMapping}} or from the given
 * {{luya\web\Request::$hostInfo}}.
 *
 * It also provides common functions in order to make complex regional language detection for urls
 * like `https://example.com/fr/ch`, its possible to set {{luya\web\Composition::$pattern}} and retrieve
 * the value later inside your application. The `langShortCode` must be provided as long as working with the
 * cms, as its bound to the administration language `admin_lang` database table.
 *
 * It also provides security check options:
 *
 * + {{luya\web\Composition::$allowedHosts}}
 *
 * The Composition component is registered by the {{luya\base\Boot}} object and is therefore accessible
 * trough `Yii::$app->composition` as "singleton" instance.
 *
 * @property string $prefixPath Return the current composition prefix path for the request based on request input and hidden option.
 * @property array $keys Return an array with key and value of all resolve composition values for the current request.
 * @property string $defaultLangShortCode Return default defined language shord code
 * @property string $langShortCode Return wrapper of getKey('langShortCode')
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Composition extends Component implements \ArrayAccess
{
    /**
     * @var string The Regular-Expression matching the var finder inside the url parts
     */
    const VAR_MATCH_REGEX = '/<(\w+):?([^>]+)?>/';
    
    /**
     * @deprecated Deprecated in 1.0.5 remove in 1.1.x
     */
    const EVENT_AFTER_SET = 'EVENT_AFTER_SET';

    /**
     * @var \yii\web\Request Request-Object container from DI
     */
    public $request;

    /**
     * @var boolean Enable or disable composition prefix out when using `prefixPath`. If disabled the response of prefixPath would be empty, otherwhise it
     * returns the full prefix composition pattern based url.
     */
    public $hidden = true;

    /**
     * @var boolean Disable composition prefixes in URLs only for default language. Takes effect only when `hidden` option is disabled.
     * @since 1.0.10
     */
    public $hideDefaultPrefixOnly = false;

    /**
     * @var string Url matching prefix, which is used for all the modules (e.g. an e-store requireds a language
     * as the cms needs this informations too). After proccessing this informations, they will be removed
     * from the url for further proccessing.
     *
     * Examples of how to use patterns:
     *
     * ```php
     * 'pattern' => '<langShortCode:[a-z]{2}>/<countryShortCode:[a-z]{2}>', // de/ch; fr/ch
     * ```
     */
    public $pattern = '<langShortCode:[a-z]{2}>';

    /**
     * @var array Default value if there is no composition provided in the url. The default value must match the url.
     */
    public $default = ['langShortCode' => 'en'];

    /**
     * @var array Define the default behavior for differnet host info schemas, if the host info is not found
     * the default behvaior via `$default` will be used.
     * An array where the key is the host info and value the array with the default configuration .e.g.
     *
     * ```php
     * 'hostInfoMapping' => [
     *     'http://mydomain.com' => ['langShortCode' => 'en'],
     *     'http://meinedomain.de' => ['langShortCode' => 'de'],
     * ],
     * ```
     *
     * The above configuration must be defined in your compostion componeont configuration in your config file.
     */
    public $hostInfoMapping = [];
    
    /**
     *
     * @var array|string An array with all valid hosts in order to ensure the request host is equals to valid hosts.
     * This filter provides protection against ['host header' attacks](https://www.acunetix.com/vulnerabilities/web/host-header-attack).
     *
     * ```php
     * 'allowedHosts' => [
     *     'example.com',
     *     '*.example.com',
     * ]
     * ```
     *
     * If null is defined, the allow host filtering is disabled, default value.
     * @since 1.0.5
     */
    public $allowedHosts = null;

    /**
     * Class constructor, to get data from DiContainer.
     *
     * @param \luya\web\Request $request Request componet resolved from Depency Manager
     * @param array $config The object configuration array
     */
    public function __construct(Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // check if the required key langShortCode exist in the default array.
        if (!array_key_exists('langShortCode', $this->default)) {
            throw new Exception("The composition default rule must contain a langShortCode.");
        }

        if ($this->allowedHosts !== null && !$this->isHostAllowed($this->allowedHosts)) {
            throw new ForbiddenHttpException("The current host '{$this->request->hostName}' is not in the list valid of hosts.");
        }
        
        if (array_key_exists($this->request->hostInfo, $this->hostInfoMapping)) {
            $this->default = $this->hostInfoMapping[$this->request->hostInfo];
        }
    }
    
    /**
     * Checks if the current request name against the allowedHosts list.
     *
     * @return boolean Whether the current hostName is allowed or not.
     * @since 1.0.5
     */
    public function isHostAllowed($allowedHosts)
    {
        $currentHost = $this->request->hostName;
        
        $rules = (array) $allowedHosts;
        
        foreach ($rules as $allowedHost) {
            if (StringHelper::matchWildcard($allowedHost, $currentHost)) {
                return true;
            }
        }
        
        return false;
    }

    private $_keys;
    
    /**
     * Resolves the current key and value objects based on the current pathInto and pattern from Request component.
     *
     * @return array An array with key values like `['langShortCode' => 'en']`.
     * @since 1.0.5
     */
    public function getKeys()
    {
        if ($this->_keys === null) {
            $this->_keys = $this->getResolvedPathInfo($this->request)->resolvedValues;
        }
        
        return $this->_keys;
    }
    
    /**
     * Resolve the current url request and retun an array contain resolved route and the resolved values.
     *
     * @param Request $request
     * @return \luya\web\CompositionResolver
     */
    public function getResolvedPathInfo(Request $request)
    {
        return new CompositionResolver($request, ['pattern' => $this->pattern, 'defaultValues' => $this->default]);
    }

    /**
     * Set a new composition key and value in composition array. If the key already exists, it will
     * be overwritten.
     *
     * @param string $key The key in the array, e.g. langShortCode
     * @param string $value The value coresponding to the key e.g. de
     */
    public function setKey($key, $value)
    {
        $this->_keys[$key] = $value;
    }

    /**
     * Get value from the composition array for the provided key, if the key does not existing the default value
     * will be return. The standard value of the defaultValue is false, so if nothing defined and the could not
     * be found, the return value is `false`.
     *
     * @param string $key The key to find in the composition array e.g. langShortCode
     * @param string $defaultValue The default value if they could not be found
     * @return string|bool
     */
    public function getKey($key, $defaultValue = false)
    {
        $this->getKeys();
        
        return isset($this->_keys[$key]) ? $this->_keys[$key] : $defaultValue;
    }
    
    /**
     * Get the composition prefix path based on current provided request.
     *
     * An example response could be `de` or with other composition keys and patterns `de/ch` or `de-CH`.
     *
     * @return string A prefix path like `de/ch`
     * @since 1.0.5
     */
    public function getPrefixPath()
    {
        return $this->createRouteEnsure();
    }

    /**
     * Create a route but ensures if composition is hidden anyhow.
     *
     * @param array $overrideKeys
     * @return string
     */
    public function createRouteEnsure(array $overrideKeys = [])
    {
        if (isset($overrideKeys['langShortCode'])) {
            $langShortCode = $overrideKeys['langShortCode'];
        } else {
            $langShortCode = $this->langShortCode;
        }
        return $this->hidden || (!$this->hidden && $langShortCode == $this->defaultLangShortCode && $this->hideDefaultPrefixOnly) ? '' : $this->createRoute($overrideKeys);
    }

    /**
     * Create compositon route based on the provided keys (to override), if no keys provided
     * all the default values will be used.
     *
     * @param array $overrideKeys
     * @return string
     */
    public function createRoute(array $overrideKeys = [])
    {
        $composition = $this->getKeys();
        
        foreach ($overrideKeys as $key => $value) {
            if (array_key_exists($key, $composition)) {
                $composition[$key] = $value;
            }
        }
        return implode('/', $composition);
    }

    /**
     * Prepend to current composition (or to provided composition prefix-route) to a given route.
     *
     * Assuming the current composition returns `en/gb` and the route is `foo/bar` the return
     * value would be `en/gb/foo/bar`.
     *
     * If a trailing slash is provided from a route, this will be returned as well, assuming:
     *
     * ```php
     * echo prependTo('/foobar', 'en/gb'); // ouput: /en/gb/foobar
     * echo prependTo('foobar', 'en/gb'); // output: en/gb/foobar
     * ```
     *
     * @param string $route The route where the composition prefix should be prepended.
     * @param null|string $prefix Define the value you want to prepend to the route or not.
     * @return string
     */
    public function prependTo($route, $prefix = null)
    {
        if ($prefix === null) {
            $prefix = $this->getPrefixPath();
        }

        if (empty($prefix)) {
            return $route;
        }

        $prepend = '';

        // if it contains a prepend slash, we keep this, as long as the route is also longer then just a slash.
        if (substr($route, 0, 1) == '/' && strlen($route) > 1) {
            $prepend = '/';
        }

        return $prepend.$prefix.'/'.ltrim($route, '/');
    }

    /**
     * Remove the composition full parterns from a given route
     *
     * @param string $route
     * @return string route cleanup from the compositon pattern (without).
     */
    public function removeFrom($route)
    {
        $pattern = preg_quote($this->prefixPath.'/', '#');

        return preg_replace("#$pattern#", '', $route, 1);
    }
    
    /**
     * Wrapper for `getKey('langShortCode')` to load language to set php env settings.
     *
     * @return string|boolean Get the language value from the langShortCode key, false if not set.
     */
    public function getLangShortCode()
    {
        return $this->getKey('langShortCode');
    }
    
    /**
     * Return the the default langt short code.
     *
     * @return string
     */
    public function getDefaultLangShortCode()
    {
        return $this->default['langShortCode'];
    }

    /**
     * ArrayAccess offset exists.
     *
     * @see \ArrayAccess::offsetExists()
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->_keys[$offset]);
    }

    /**
     * ArrayAccess set value to array.
     *
     * @see \ArrayAccess::offsetSet()
     * @param string $offset The key of the array
     * @param mixed $value The value for the offset key.
     * @throws \luya\Exception
     */
    public function offsetSet($offset, $value)
    {
        $this->setKey($offset, $value);
    }

    /**
     * ArrayAccess get the value for a key.
     *
     * @see \ArrayAccess::offsetGet()
     * @param string $offset The key to get from the array.
     * @return mixed The value for the offset key from the array.
     */
    public function offsetGet($offset)
    {
        return $this->getKey($offset, null);
    }

    /**
     * ArrayAccess unset key.
     *
     * Unsetting data via array access is not allowed.
     *
     * @see \ArrayAccess::offsetUnset()
     * @param string $offset The key to unset from the array.
     * @throws \luya\Exception
     */
    public function offsetUnset($offset)
    {
        throw new Exception('Deleting keys in Composition is not allowed.');
    }
    
    // Deprecated methods
    
    /**
     * Wrapper for `getKey('langShortCode')` to load language to set php env settings.
     *
     * @return string|boolean Get the language value from the langShortCode key, false if not set.
     * @deprecated in 1.1.0 use `getLangShortCode()` instead.
     */
    public function getLanguage()
    {
        return $this->getKey('langShortCode');
    }
    
    /**
     * Return the whole composition array.
     *
     * @return array
     * @deprecated Remove in 1.1.0 use `getKeys()` instead.
     */
    public function get()
    {
        return $this->_keys;
    }
    
    /**
     * Return a path like string with all composition with trailing slash e.g. us/e.
     *
     * @return string
     * @deprecated Remove in 1.1.0 use `getPrefixPath()` instead.
     */
    public function getFull()
    {
        return $this->createRouteEnsure();
    }
}
