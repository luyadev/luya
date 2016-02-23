<?php

namespace luya\components;

use Yii;

class UrlRule extends \luya\web\UrlRule
{
    private $_defaultClassName = null;

    public function init()
    {
        // override previous UrlRule initializer
    }

    public function createUrl($manager, $route, $params)
    {
        return false;
    }

    public function getDefaultClassName()
    {
        if ($this->_defaultClassName === null) {
            $this->_defaultClassName = Yii::$app->defaultRoute.'\\components\\UrlRule';
        }

        return $this->_defaultClassName;
    }

    public function getUrlParts($request)
    {
        $pathInfo = $request->getPathInfo();
        if (empty($pathInfo)) {
            return [];
        }

        return explode('/', rtrim($pathInfo, '/'));
    }

    /**
     * @todo verify the $urlParts variable, foreach resolvedValues when $urlParts not empty?
     * @param luya\web\UrlManager $manager
     * @param luya\web\Request $request
     * @return boolean
     */
    public function parseRequest($manager, $request)
    {
        // extra data from request to composition, which changes the pathInfo of the Request-Object.
        $resolver = Yii::$app->composition->getResolvedPathInfo($request);


        Yii::trace("LUYA UrlRUle component has resolved '".print_r($resolver, true)."'", __METHOD__);
        
        //$request->setPathInfo($resolver['route']);

        // set user env variabls
        // Yii::$app->language = Yii::$app->composition->language;
        // setlocale(LC_ALL, Yii::$app->composition->locale, Yii::$app->composition->locale.'.utf8');

        // get all parts from the current changed Request-Object.
        $urlParts = $this->getUrlParts($request);

        // fixed issue where "/en" does not find default cms route anymore.
        foreach ($resolver['resolvedValues'] as $value) {
            $urlParts[] = $value;
        }

        // if there are url parts and its not a module, load the default route based UrlRule if the class exstists.
        if (count($urlParts) > 0 && !array_key_exists($urlParts[0], Yii::$app->modules)) {
            if (class_exists($this->getDefaultClassName())) {
                $manager->addRules([['class' => $this->getDefaultClassName()]], false);
                Yii::info("If there are url parts and its not a module, load the default route based UrlRule if the class '".$this->getDefaultClassName()."' exstists.", __METHOD__);
                return $manager->parseRequest($request);
            }
        }

        return false;
    }
}
