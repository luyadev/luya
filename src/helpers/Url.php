<?php
namespace luya\helpers;

use \yii;

class Url
{
    /**
     * get an array from the route which returns the module controller and action
     *
     * @param string $route
     */
    public static function fromRoute($route, $returnPart = false)
    {
        $parts = explode("/", $route);
        
        if (count($parts) == 3) {
            list($module, $controller, $action) = $parts;
        }
        
        if (count($parts) !== 3) {
            return false;
        }
        
        $parts = [
            "module" => $module,
            "controller" => $controller,
            "action" => $action
        ];
        
        if ($returnPart !== false) {
            return $parts[$returnPart];
        }
        
        return $parts;
    }
    
    /**
     * add a trailing slash to an url if there is no trailing slash at the end of the url
     * 
     * @param string $url The url which a trailing slash should be appended
     * @param string $slash If you want to trail a file on a windows system it gives you the ability to add forward slashes.
     */
    public static function trailing($url, $slash = "/")
    {
        return $url .  (substr($url, -1) == $slash ? '' : $slash);
    }
    
    /**
     * Wrapper functions for the createUrl function of the url manager.
     * 
     * @param string $route
     * @param array $params
     */
    public static function to($route, array $params = [])
    {
        $routeParams = [$route];
        foreach ($params as $key => $value) {
            $routeParams[$key] = $value;
        }
        
        return yii::$app->urlManager->createUrl($routeParams);
    }
}
