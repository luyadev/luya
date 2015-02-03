<?php
namespace luya\components;

/**
 * if its not necesary to directly access the modules via /{module} we could
 * implement this solution:
 * http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#adding-rules-dynamically
 *
 * @author nadar
 *
 */
class UrlManager extends \yii\web\UrlManager
{
    public $enablePrettyUrl = true;

    public $showScriptName = false;
    
    
    public function createUrl($params)
    {
        $response = parent::createUrl($params);
        
        $params = (array) $params;
        
        $moduleName = \luya\helpers\Url::fromRoute($params[0], 'module');
        
        $moduleObject = \yii::$app->getModule($moduleName);
        
        $moduleContext = $moduleObject->getContext();
        if (!empty($moduleContext)) {
            $options = $moduleObject->getContextOptions();
            $navItemId = $options['navItemId'];
            $link = \yii::$app->collection->links->getOneByArguments(['nav_item_id' => $navItemId]);
            $response = str_replace($moduleName, $link['url'], $response);
        }
        
        return $response;
    }
}
