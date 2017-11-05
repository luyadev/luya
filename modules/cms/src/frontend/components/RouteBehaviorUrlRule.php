<?php

namespace luya\cms\frontend\components;

use Yii;
use yii\web\UrlRule;

/**
 * Routing Rule for UrlManager.
 *
 * UrlRule to enable default routing behavior as the CatchAllRule will catch default routing behavior otherwhise.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RouteBehaviorUrlRule extends \yii\web\UrlRule
{
    public $pattern = '<module>/<controller>/<action>';
    
    public $route = '<module>/<controller>/<action>';
    
    public $defaults = ['controller' => 'default', 'action' => 'index'];
    
    public $mode = UrlRule::PARSING_ONLY;
    
    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {
        // return the custom route
        $parts = explode("/", $request->pathInfo);
        
        if (!isset($parts[0]) || !Yii::$app->hasModule($parts[0]) || $parts[0] === 'cms') {
            return false;
        }
        
        // add trace info
        Yii::info('LUYA-CMS RouteBehaviorUrlRule is parsing the Request for path info \'' . $request->pathInfo .'\'', __METHOD__);
        
        return parent::parseRequest($manager, $request);
    }
}
