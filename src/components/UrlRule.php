<?php
namespace luya\components;

use Yii;

class UrlRule extends \luya\base\UrlRule
{
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        
        $parts = explode("/", $pathInfo);
        
        $pc = yii::$app->getModule('luya')->urlPrefixComposition;
        
        $url = $request->getPathInfo();
        
        preg_match_all('/<(\w+):?([^>]+)?>/', $pc, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $index => $match) {
            if (isset($parts[$index])) {
                $urlValue = $parts[$index];
                $rgx = $match[2];
                $param = $match[1];
                
                preg_match("/^$rgx$/", $urlValue, $res);
                if (count($res) == 1) {
                    // ok! remove it, and add requestParam
                    $request->setQueryParams([$param => $urlValue]);
                    unset($parts[$index]);
                }
            }
        }
        
        $request->setPathInfo(implode("/", $parts));
        
        $langObject = new \luya\collection\Lang();
        $langObject->evalRequest($request);
        
        Yii::$app->get('collection')->lang = $langObject;
        
        // MODULE ROUTING
        // NEW: starte module routing from previously cutted route (above)
        // @todo make a config entry do disabled "direct module booting, except of the admin module" (?idea)
        $parts = explode("/", $request->getPathInfo());
        
        // does the module exists in the list
        if (isset($parts[0]) && array_key_exists($parts[0], Yii::$app->modules)) {
            $route = $parts[0];
        } else {
            $route = Yii::$app->defaultRoute;
        }
        
        $module = Yii::$app->getModule($route);
        // class namespacing
        $class = $module->getModuleNamespace() . '\components\UrlRule'; // @todo: replace with \yii::$app->params['modules']
        // if class exists, insert rule and parse the requests
        if (class_exists($class)) {
            // clear existsing rules to avoid infinite loading
            $manager->clearRules();
            // add module class
            $manager->addRules([['class' => $class]]);
            // parse requests and return
            return $manager->parseRequest($request);
        } else {
            // we do not have a loading class
            // the module does not have a UrlRule component
            // we starte loading the default include <module>/default/index
            //return [$route . '/default/index', ['path' => $request->getPathInfo()]];
        }
        // nothing happend here
        return false;
    }
}
