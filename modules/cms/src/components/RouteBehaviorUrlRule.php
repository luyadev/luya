<?php

namespace cms\components;

use Yii;
use yii\web\UrlRule;

class RouteBehaviorUrlRule extends \yii\web\UrlRule
{
    public $pattern = '<module>/<controller>/<action>';
    
    public $route = '<module>/<controller>/<action>';
    
    public $defaults = ['controller' => 'default', 'action' => 'index'];
    
    public $mode = UrlRule::PARSING_ONLY;
    
    public function parseRequest($manager, $request)
    {
        // add trace info
        Yii::info('LUYA-CMS RouteBehaviorUrlRule is parsing the Request for path info \'' . $request->pathInfo .'\'', __METHOD__);
        // return the custom route
        
        $parts = explode("/", $request->pathInfo);
        
        if (!isset($parts[0]) || !Yii::$app->hasModule($parts[0]) || $parts[0] === 'cms') {
            return false;   
        }
        
        return parent::parseRequest($manager, $request);
    }
}