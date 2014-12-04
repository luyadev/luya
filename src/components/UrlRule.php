<?php
namespace luya\components;

use Yii;

class UrlRule extends \luya\base\UrlRule
{
    public function parseRequest($manager, $request)
    {
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
        }
        // nothing happend here
        return false;
    }
}
