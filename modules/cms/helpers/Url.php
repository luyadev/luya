<?php

namespace cms\helpers;

use Yii;
use Exception;
use cmsadmin\models\NavItem;

class Url
{
    /**
     * if the module could not be found (not registered in the cms) the method returns the provided module name.
     * 
     * returns only ONE even if there are more! not good structure inside the cms?
     * 
     * @param string $moduleName
     * @return string The full_url from links component.
     */
    public static function toModule($moduleName)
    {
        $model = NavItem::findNavItem($moduleName);
        
        if ($model) {
            $menuItem = Yii::$app->menu->find()->where(['id' => $model['id']])->one();
            if ($menuItem) {
                return $menuItem->link;
            }
        }

        return $moduleName;
    }
    
    /**
     * Helper method to create a route based on the module name and the route and params.
     * 
     * @param string $moduleName The ID of the module, which should be found inside the nav items.
     * @param string $route The route for the url rules
     * @param array $params The parameters for the url rule
     * @throws Exception
     * @return string
     * @see \luya\helpers\Url::toModule()
     */
    public static function toModuleRoute($moduleName, $route, array $params = [])
    {
        $model = NavItem::findNavItem($moduleName);
        if ($model) {
            return \luya\helpers\Url::toModule($model['id'], $route, $params);
        }
        
        throw new Exception("Unable to find the Module '$moduleName' for url creation.");
    }
}
