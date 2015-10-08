<?php

namespace luya\components;

use luya\helpers\Url;

/**
 * Luya Composition Component to provide i18n/language handling.
 * 
 * @author nadar
 */
class Composition extends \yii\base\Component
{
    /**
     * @var string The Regular-Expression matching the var finder inside the url parts
     */
    const VAR_MATCH_REGEX = '/<(\w+):?([^>]+)?>/';
    
    /**
     * @var boolean Enable or disable the $composition->getFull() prefix. If disabled the response of getFull() would be empty, otherwhise it
     * returns the full prefix composition pattern based url.
     */
    public $hidden = false;

    /**
     * @var string Url matching prefix, which is used for all the modules (e.g. an e-store requireds a language
     * as the cms needs this informations too). After proccessing this informations, they will be removed
     * from the url for further proccessing.
     *
     * The fullqualified composer key will be stored in `$request->get('urlPrefixCompositionKey')`.
     *
     * Examples of how to use urlPrefixComposition
     * 
     * ```
     * $urlPrefixComposition = '<langShortCode:[a-z]{2}>/<countryShortCode:[a-z]{2}>'; // de/ch; fr/ch
     * ```
     */
    public $pattern = '<langShortCode:[a-z]{2}>';

    /**
     * @var array Default value if there is no composition provided in the url. The default value must match the $pattern url.
     */
    public $default = ['langShortCode' => 'de'];

    /**
     * @var array Read-Only property, contains all composition key value paringins
     */
    private $_composition = [];

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
        // array with all url parts, seperated by slash
        $requestUrlParts = explode('/', $request->pathInfo);
        // catch all results matching the var match regular expression
        preg_match_all(static::VAR_MATCH_REGEX, $this->pattern, $matches, PREG_SET_ORDER);
        // get all matches
        foreach ($matches as $index => $match) {
            // check if the index of the match is existing in the requestUrlParts array as the match always
            // starts from the begin of a string.
            if (isset($requestUrlParts[$index])) {
                $requestUrlValue = $requestUrlParts[$index];
                // check if the value of the requeste url value matches the regex of the compositoin
                if (preg_match("/^".$match[2]."$/", $requestUrlValue)) {
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
        // set all keys into the composition component
        $this->set($keys);
        // return array with route and resolvedValues
        return ['route' => implode('/', $requestUrlParts), 'resolvedValues' => $resolvedValues];
    }

    /**
     * Set a new composition key and value in composition array. If the key already exists, it will
     * be overwritten.
     * 
     * @param string $key The key in the array, e.g. langShortCode
     * @param string $value The value coresponding to the key e.g. de
     * @return void
     */
    public function setKey($key, $value)
    {
        $this->_composition[$key] = $value;
    }

    /**
     * Get value from the composition array for the provided key, if the key does not existing the default value
     * will be return. The standard value of the defaultValue is false, so if nothing defined and the could not
     * be found, the return value is `false`.
     * 
     * @param string $key The key to find in the composition array e.g. langShortCode
     * @param string $defaultValue The default value if they could not be found
     * @return string|boolean
     */
    public function getKey($key, $defaultValue = false)
    {
        return (isset($this->_composition[$key])) ? $this->_composition[$key] : $defaultValue;
    }

    /**
     * Return the whole composition array
     * 
     * @return array
     */
    public function get()
    {
        return $this->_composition;
    }

    /**
     * Override all composition values and strictly set new array.
     * 
     * @param array $array An array containg key value parings.
     * @return void
     */
    public function set(array $array)
    {
        $this->_composition = $array;
    }

    /**
     * Return a path like string with all composition with trailing slash e.g. us/e
     * 
     * @return void|string
     */
    public function getFull()
    {
        return ($this->hidden) ? '' : Url::trailing(implode('/', $this->_composition));
    }

    /**
     * Transform the langShortCode into a locale sign to set php env settings.
     * 
     * @return string
     */
    public function getLocale()
    {
        switch ($this->getKey('langShortCode')) {
            case 'de':
                return 'de_DE';
                break;
            case 'en':
                return 'en_EN';
                break;
            case 'fr':
                return 'fr_FR';
                break;
            case 'it':
                return 'it_IT';
                break;
        }
    }
    
    /**
     * Wrapper for `getKey('langShortCode')` to load language to set php env settings.
     * 
     * @return string|boolean
     */
    public function getLanguage()
    {
        return $this->getKey('langShortCode');
    }
}
