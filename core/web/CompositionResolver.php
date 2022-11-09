<?php

namespace luya\web;

use luya\helpers\StringHelper;
use luya\helpers\Url;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

/**
 * Resolve composition values from a given path and pattern.
 *
 * @property string $resolvedPath
 * @property array $resolvedValues
 * @property array $resolvedKeys
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.5
 */
class CompositionResolver extends BaseObject
{
    /**
     * @var string The Regular-Expression matching the var finder inside the url parts
     */
    public const VAR_MATCH_REGEX = '/<(\w+):?([^>]+)?>/';

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Composition Composition object.
     */
    public $composition;

    /**
     * Constructor ensures given Request component.
     *
     * @param Request $request
     * @param Composition $composition
     * @param array $config
     */
    public function __construct(Request $request, Composition $composition, array $config = [])
    {
        $this->request = $request;
        $this->composition = $composition;
        parent::__construct($config);
    }

    /**
     * Get the resolved path.
     *
     * @return string|array
     */
    public function getResolvedPath()
    {
        return $this->getInternalResolverArray()['route'];
    }

    /**
     * Get resolved composition values as array.
     *
     * @return array
     */
    public function getResolvedValues()
    {
        return $this->getInternalResolverArray()['values'];
    }

    /**
     * Get only the resolved composition keys from pattern.
     * @return array
     */
    public function getResolvedKeys()
    {
        return array_keys($this->getResolvedValues());
    }

    /**
     * Get a value for a given resolved pattern key.
     *
     * @param string $key
     * @return boolean|mixed
     */
    public function getResolvedKeyValue($key)
    {
        $keys = $this->resolvedValues;

        return isset($keys[$key]) ? $keys[$key] : false;
    }

    /**
     * Add trailing slash to the request pathinfo.
     *
     * @return string
     */
    protected function trailingPathInfo()
    {
        return Url::trailing($this->request->pathInfo);
    }

    /**
     * Generate the regex pattern based on the pattern.
     *
     * @return string
     */
    protected function buildRegexPattern()
    {
        return "@^{$this->composition->pattern}\/@";
    }

    private $_resolved;

    /**
     * Resolve the current data.
     *
     * @return array
     */
    protected function getInternalResolverArray()
    {
        if ($this->_resolved === null) {
            $requestPathInfo = $this->trailingPathInfo();
            $newRegex = $this->buildRegexPattern();

            // extract the rules from the regex pattern, this means you get array with keys for every rule inside the pattern string
            // example pattern: <langShortCode:[a-z]{2}>-<countryShortCode:[a-z]{2}>
            /* [0]=>
                 array(3) {
                     [0]=> string(24) "<langShortCode:[a-z]{2}>"
                     [1]=> string(13) "langShortCode"
                     [2]=> string(8) "[a-z]{2}"
                 }
               [1]=>
                 array(3) {
                     [0]=> string(27) "<countryShortCode:[a-z]{2}>"
                     [1]=> string(16) "countryShortCode"
                     [2]=> string(8) "[a-z]{2}"
                 }
             */
            preg_match_all(static::VAR_MATCH_REGEX, $this->composition->pattern, $patternDefinitions, PREG_SET_ORDER);

            foreach ($patternDefinitions as $definition) {
                $newRegex = str_replace($definition[0], '('.rtrim(ltrim($definition[2], '('), ')').')', $newRegex);
            }

            preg_match_all($newRegex, $requestPathInfo, $matches, PREG_SET_ORDER);

            if (isset($matches[0]) && !empty($matches[0])) {
                $keys = [];
                $matches = $matches[0];

                $compositionPrefix = $matches[0];
                unset($matches[0]);
                $matches = array_values($matches);

                foreach ($matches as $k => $v) {
                    $keys[$patternDefinitions[$k][1]] = $v;
                }

                $route = StringHelper::replaceFirst($compositionPrefix, '', $requestPathInfo);
            } else {
                $matches = [];
                $keys = $this->composition->default;
                $route = $requestPathInfo;
            }

            // the validation check for validates composition values is enabled
            if ($this->composition->expectedValues) {
                foreach ($keys as $patternKey => $expectedPatternValue) {
                    if (!array_key_exists($patternKey, $this->composition->expectedValues)) {
                        throw new InvalidConfigException("Invalid configuration, the expectedValues configuration key \"{$patternKey}\" does not exists in the resolved values list.");
                    }

                    $possibleValues = $this->composition->expectedValues[$patternKey];

                    if (!in_array($expectedPatternValue, $possibleValues)) {
                        throw new NotFoundHttpException("The requested composition key \"{$patternKey}\" with value \"{$expectedPatternValue}\" is not in the possible values list.");
                    }
                }
            }

            $this->_resolved = [
                'route' => rtrim($route, '/'),
                'values' => $keys,
            ];
        }

        return $this->_resolved;
    }
}
