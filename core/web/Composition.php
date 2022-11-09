<?php

namespace luya\web;

use luya\Exception;
use luya\helpers\ArrayHelper;
use luya\helpers\StringHelper;
use Yii;
use yii\base\Component;
use yii\web\ForbiddenHttpException;

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
    public const VAR_LANG_SHORT_CODE = 'langShortCode';

    /**
     * @var string The Regular-Expression matching the var finder inside the url parts
     */
    public const VAR_MATCH_REGEX = '/<(\w+):?([^>]+)?>/';

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
    public $pattern = "<".self::VAR_LANG_SHORT_CODE.":[a-z]{2}>";

    /**
     * @var array Default value if there is no composition provided in the url. The default value must match the url.
     */
    public $default = [self::VAR_LANG_SHORT_CODE => 'en'];

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
     * @var array|string An array with all valid hosts in order to ensure the request host is equals to valid hosts.
     * This filter provides protection against ['host header' attacks](https://www.acunetix.com/vulnerabilities/web/host-header-attack).
     *
     * The allowed hosts check does not care about the protocol (https/http), there fore take a look the {{luya\traits\ApplicationTrait::$ensureSecureConnection}}.
     *
     * ```php
     * 'allowedHosts' => [
     *     'example.com', // this does not include www.
     *     '*.example.com', // this incluides www. and all other subdomains.
     * ]
     * ```
     *
     * > In order to allow all subdomains including www or not use `*example.com`.
     *
     * If no value is defined, the allowed host filtering is disable, this is the default behavior.
     * @since 1.0.5
     */
    public $allowedHosts;

    /**
     * @var array An array where key is the pattern and value an array of possible values for this pattern.
     * A list of values which are valid for every pattern. If set and a value is provided which is not inside this property
     * an http not found exception is thrown.
     *
     * Every value must be set for the given pattern name:
     *
     * ```php
     * 'expectedValues' => [
     *     'langShortCode' => ['en', 'de'], // langShortCode pattern is required
     *     'countryShortCode' => ['ch', 'fr', 'de', 'uk'], // additional patterns if configured
     * ],
     * ```
     *
     * > This configuration is usual only used in MVC applications without CMS module, as the cms module throws an
     * > exception if the requested language is not available.
     *
     * @since 1.0.15
     */
    public $expectedValues = [];

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
        if (!array_key_exists(self::VAR_LANG_SHORT_CODE, $this->default)) {
            throw new Exception("The composition default rule must contain a langShortCode.");
        }

        if ($this->allowedHosts !== null && !$this->isHostAllowed($this->allowedHosts)) {
            throw new ForbiddenHttpException("Invalid host name.");
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

    /**
     * Find the host for a given definition based on the {{Composition::$hostInfoMapping}} definition.
     *
     * Find the host info mapping (if existing) for a lang short code:
     *
     * ```php
     * $host = $composition->resolveHostInfo('en');
     * ```
     *
     * Or resolve by provide full host info mapping defintion:
     *
     * ```php
     * $host = $composition->resolveHostInfo([
     *     'langShortCode' => 'de'
     *     'countryShortCode' => 'ch',
     * ]);
     * ```
     *
     * > Keep in mind that when {{Composition::$hostInfoMapping}} is empty (no defintion), false is returned.
     *
     * @param string|array $defintion The hostinfo mapping config containing an array with full defintion of different keys or a string
     * which will only resolved based on langShortCode identifier.
     * @return string|boolean Returns the host name from the host info maping otherwise false if not found.
     * @since 1.0.18
     */
    public function resolveHostInfo($defintion)
    {
        // if its a scalar value, we assume the user wants to find host info based on languageShortCode
        if (is_scalar($defintion)) {
            $defintion = [self::VAR_LANG_SHORT_CODE => $defintion];
        }

        $results = $this->hostInfoMapping;
        foreach ($defintion as $key => $value) {
            $results = ArrayHelper::searchColumns($results, $key, $value);
        }

        return empty($results) ? false : key($results);
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
        return new CompositionResolver($request, $this);
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

        return $this->_keys[$key] ?? $defaultValue;
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
        if (isset($overrideKeys[self::VAR_LANG_SHORT_CODE])) {
            $langShortCode = $overrideKeys[self::VAR_LANG_SHORT_CODE];
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
        return $this->getKey(self::VAR_LANG_SHORT_CODE);
    }

    /**
     * Return the the default langt short code.
     *
     * @return string
     */
    public function getDefaultLangShortCode()
    {
        return $this->default[self::VAR_LANG_SHORT_CODE];
    }

    /**
     * ArrayAccess offset exists.
     *
     * @see \ArrayAccess::offsetExists()
     * @return boolean
     */
    #[\ReturnTypeWillChange]
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
    #[\ReturnTypeWillChange]
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
    #[\ReturnTypeWillChange]
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
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        throw new Exception('Deleting keys in Composition is not allowed.');
    }

    /**
     * Wrapper for `getKey('langShortCode')` to load language to set php env settings.
     *
     * @return string|boolean Get the language value from the langShortCode key, false if not set.
     * @deprecated in 1.1.0 use `getLangShortCode()` instead, trigger in 2.0, will be removed in 3.0
     */
    public function getLanguage()
    {
        trigger_error('use `getLangShortCode()` instead. Will be removed in version 3.0', E_USER_DEPRECATED);
        return $this->getKey(self::VAR_LANG_SHORT_CODE);
    }

    /**
     * Return the whole composition array.
     *
     * @return array
     * @deprecated Remove in 1.1.0 use `getKeys()` instead, trigger in 2.0, will be removed in 3.0
     */
    public function get()
    {
        trigger_error('use `getKeys()` instead. Will be removed in version 3.0', E_USER_DEPRECATED);
        return $this->_keys;
    }

    /**
     * Return a path like string with all composition with trailing slash e.g. us/e.
     *
     * @return string
     * @deprecated Remove in 1.1.0 use `getPrefixPath()` instead, trigger in 2.0, will be removed in 3.0
     */
    public function getFull()
    {
        trigger_error('use `getPrefixPath()` instead. Will be removed in version 3.0', E_USER_DEPRECATED);
        return $this->createRouteEnsure();
    }
}
