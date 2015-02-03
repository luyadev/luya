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
    
    public static function to($route, array $params = [])
    {
        $routeParams = [$route];
        foreach ($params as $key => $value) {
            $routeParams[$key] = $value;
        }
        
        return yii::$app->urlManager->createUrl($routeParams);
    }
}
