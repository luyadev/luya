<?php

namespace luya\components;

use Yii;

class UrlRule extends \luya\base\UrlRule
{
    public function init()
    {
        // override previous UrlRule initializer
    }

    public function createUrl($manager, $route, $params)
    {
        return false;
    }

    private $_defaultClassName = null;
    
    public function getDefaultClassName()
    {
        if ($this->_defaultClassName === null) {
            $this->_defaultClassName = Yii::$app->defaultRoute.'\\components\\UrlRule';
        }
        
        return $this->_defaultClassName;
    }
    
    private function getUrlParts($request)
    {
        return explode('/', $request->getPathInfo());
    }
    
    public function parseRequest($manager, $request)
    {
        // extra data from request to composition, which changes the pathInfo of the Request-Object.
        Yii::$app->composition->extractRequestData($request);
        
        // set user env variabls
        Yii::$app->language = Yii::$app->composition->getLanguage();
        setlocale(LC_ALL, Yii::$app->composition->getLocale(), Yii::$app->composition->getLocale().'.utf8');
        
        // get all parts from the current changed Request-Object.
        $urlParts = $this->getUrlParts($request);
        
        // if there are url parts and its not a module, load the default route based UrlRule if the class exstists.
        if (count($urlParts) > 0 && !array_key_exists($urlParts[0], Yii::$app->modules)) {
            if (class_exists($this->getDefaultClassName())) {
                $manager->addRules([['class' => $this->getDefaultClassName()]], false);
                return $manager->parseRequest($request);
            }
        }

        return false;
    }
}
