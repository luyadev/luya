<?php

namespace luya\web;

use Yii;
use yii\base\Component;
use luya\Exception;
use luya\helpers\Url;
use luya\web\CompositionAfterSetEvent;

/**
 * LUYA Composition Component to provide i18n/language handling.
 * 
 * @property string $full Return `getFull()` method represents full composition
 * @property string $defaultLangShortCode Return default defined language shord code
 * @property string $language Return wrapper of getKey('langShortCode')
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Composition extends Component implements \ArrayAccess
{
    /**
     * @var string This event will method will triggere after setKey method is proccessed
     */
    const EVENT_AFTER_SET = 'EVENT_AFTER_SET';
    
    /**
     * @var string The Regular-Expression matching the var finder inside the url parts
     */
    const VAR_MATCH_REGEX = '/<(\w+):?([^>]+)?>/';

    /**
     * @var \yii\web\Request Request-Object container from DI
     */
    public $request = null;

    /**
     * @var bool Enable or disable the->getFull() prefix. If disabled the response of getFull() would be empty, otherwhise it
     * returns the full prefix composition pattern based url.
     */
    public $hidden = false;

    /**
     * @var array Can override the localisation value used for php internal `setlocale()` method for specific language. For example
     * the language is de but the it should use the locale charset `de_CH.utf` (locale -a will return all locales installed on the server)
     * you can define them inside an array where key is the language and value the locale value to be used.
     * 
     * ```php
     * public $local = [
     *    'de' => 'de_CH.utf',
     * ];
     */
    public $locales = [];
    
    /**
     * @var string Url matching prefix, which is used for all the modules (e.g. an e-store requireds a language
     * as the cms needs this informations too). After proccessing this informations, they will be removed
     * from the url for further proccessing.
     *
     * The fullqualified composer key will be stored in `$request->get('urlPrefixCompositionKey')`.
     *
     * Examples of how to use urlPrefixComposition
     * 
     * ```php
     * $urlPrefixComposition = '<langShortCode:[a-z]{2}>/<countryShortCode:[a-z]{2}>'; // de/ch; fr/ch
     * ```
     */
    public $pattern = '<langShortCode:[a-z]{2}>';

    /**
     * @var array Default value if there is no composition provided in the url. The default value must match the url.
     */
    public $default = ['langShortCode' => 'en'];

    /**
     * Define the default behavior for differnet host info schemas, if the host info is not found
     * the default behvaior via `$default` will be used.
     * 
     * @var array An array where the key is the host info and value the array with the default configuration .e.g.
     * 
     * ```
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
     * @var array Read-Only property, contains all composition key value paringins
     */
    private $_composition = [];
    
    private $_compositionKeys = [];

    /**    
     * Class constructor, to get data from DiContainer.
     * 
     * @param \luya\web\Request $request
     * @param array             $config
     */
    public function __construct(\luya\web\Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
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
     * Resolve the the composition on init.
     */
    public function init()
    {
        parent::init();
        
        // check if the required key langShortCode exist in the default array.
        if (!array_key_exists('langShortCode', $this->default)) {
            throw new Exception("The composition default rule must contain a langShortCode.");
        }
        
        if (array_key_exists($this->request->hostInfo, $this->hostInfoMapping)) {
            $this->default = $this->hostInfoMapping[$this->request->hostInfo];
        }
        
        // atach event to component
        $this->on(self::EVENT_AFTER_SET, [$this, 'eventAfterSet']);
        // resolved data
        $resolve = $this->getResolvedPathInfo($this->request);
        // set initializer comosition 
        foreach ($resolve['compositionKeys'] as $key => $value) {
            $this->setKey($key, $value);
        }
        $this->_compositionKeys = $resolve['keys'];
    }

    /**
     * This event will method will triggere after setKey method is proccessed. The
     * main purpose of this function to change the localisation based on the required
     * key 'langShortCode'.
     * 
     * @param luya\web\CompositionAfterSetEvent $event
     */
    public function eventAfterSet($event)
    {
        if ($event->key == 'langShortCode') {
            Yii::$app->language = $event->value;
            setlocale(LC_ALL, $this->getLocale(), $this->getLocale().'.utf8');
        }
    }
    
    /**
     * Resolve the current url request and retun an array contain resolved route and the resolved values.
     *
     * @param \yii\web\Request $request
     * @return array An array containing the route and the resolvedValues. Example array output when request path is `de/hello/world`:
     * 
     * ```php
     * [
     *     'route' => 'hello/world',
     *     'resolvedValues' => [
     *         0 => 'de'
     *     ],
     * ]
     * ```
     */
    public function getResolvedPathInfo(\yii\web\Request $request)
    {
        // contains all resolved values
        $resolvedValues = [];
        $foundKeys = [];
        // array with all url parts, seperated by slash
        $requestUrlParts = explode('/', $request->pathInfo);
        // catch all results matching the var match regular expression
        preg_match_all(static::VAR_MATCH_REGEX, $this->pattern, $matches, PREG_SET_ORDER);
        // get all matches
        foreach ($matches as $index => $match) {
            $foundKeys[] = $match[1];
            // check if the index of the match is existing in the requestUrlParts array as the match always
            // starts from the begin of a string.
            if (isset($requestUrlParts[$index])) {
                $requestUrlValue = $requestUrlParts[$index];
                // check if the value of the requeste url value matches the regex of the compositoin
                if (preg_match('/^'.$match[2].'$/', $requestUrlValue)) {
                    $resolvedValues[$match[1]] = $requestUrlValue;
                    // cause the part is matched by the composition, we have to unset the key from the array.
                    unset($requestUrlParts[$index]);
                }
            }
        }
        // get default values if nothing have been resolved
        if (count($resolvedValues) == 0) {
            $keys = $this->default;
        } else {
            $keys = $resolvedValues;
        }
        // return array with route and resolvedValues
        return ['route' => implode('/', $requestUrlParts), 'resolvedValues' => $resolvedValues, 'compositionKeys' => $keys, 'keys' => $foundKeys];
    }

    /**
     * Set a new composition key and value in composition array. If the key already exists, it will
     * be overwritten. The setKey method triggers the CompositionAfterSetEvent class.
     *
     * @param string $key   The key in the array, e.g. langShortCode
     * @param string $value The value coresponding to the key e.g. de
     */
    public function setKey($key, $value)
    {
        // set and override composition
        $this->_composition[$key] = $value;
        // trigger event
        $event = new CompositionAfterSetEvent();
        $event->key = $key;
        $event->value = $value;
        $this->trigger(self::EVENT_AFTER_SET, $event);
    }

    /**
     * Get value from the composition array for the provided key, if the key does not existing the default value
     * will be return. The standard value of the defaultValue is false, so if nothing defined and the could not
     * be found, the return value is `false`.
     *
     * @param string $key          The key to find in the composition array e.g. langShortCode
     * @param string $defaultValue The default value if they could not be found
     * @return string|bool
     */
    public function getKey($key, $defaultValue = false)
    {
        return (isset($this->_composition[$key])) ? $this->_composition[$key] : $defaultValue;
    }

    /**
     * Return the whole composition array.
     *
     * @return array
     */
    public function get()
    {
        return $this->_composition;
    }

    /**
     * Return a path like string with all composition with trailing slash e.g. us/e.
     *
     * @return void|string
     */
    public function getFull()
    {
        return $this->createRouteEnsure();
    }
    
    /**
     * create a route but ensures if composition is hidden anywho.
     * 
     * @param array $overrideKeys
     * @return string
     */
    public function createRouteEnsure(array $overrideKeys = [])
    {
        return ($this->hidden) ? '' : $this->createRoute($overrideKeys);
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
        $composition = $this->_composition;
        
        foreach ($overrideKeys as $key => $value) {
            if (in_array($key, $this->_compositionKeys)) {
                $composition[$key] = $value;
            }
        }
        
        return implode('/', $composition);
    }

    /**
     * Prepend to current composition (or to provided composition prefix-route) to a given route.
     *
     * @param string $route The route where the composition prefix should be prepended.
     * @param null|string $prefix Define the value you want to prepend to the route or not.
     * @return string
     */
    public function prependTo($route, $prefix = null)
    {
        if ($prefix === null) {
            $prefix = $this->getFull();
        }
        
        if (empty($prefix)) {
            return $route;
        }

        $prepend = '';

        if (substr($route, 0, 1) == '/') {
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
        $pattern = preg_quote($this->getFull().'/');

        return preg_replace("#$pattern#", '', $route, 1);
    }

    /**
     * Transform the langShortCode into a locale sign to set php env settings.
     *
     * @return string
     */
    public function getLocale()
    {
        if (array_key_exists($this->language, $this->locales)) {
            return $this->locales[$this->language];
        }
        
        switch ($this->language) {
            case 'de':
                return 'de_DE';
            case 'fr':
                return 'fr_FR';
            case 'it':
                return 'it_IT';
            case 'ru':
                return 'ru_RU';
            default:
                return 'en_EN';
        }
    }

    /**
     * Wrapper for `getKey('langShortCode')` to load language to set php env settings.
     *
     * @return string|bool
     */
    public function getLanguage()
    {
        return $this->getKey('langShortCode');
    }

    // ArrayAccess implentation

    public function offsetExists($offset)
    {
        return isset($this->_composition[$offset]);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            throw new Exception('Unable to set array value without key. Empty keys not allowed.');
        }
        $this->setKey($offset, $value);
    }

    public function offsetGet($offset)
    {
        return $this->getKey($offset, null);
    }

    public function offsetUnset($offset)
    {
        throw new Exception('Deleting keys in Composition is not allowed.');
    }
}
