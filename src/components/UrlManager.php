<?php
namespace luya\components;

/**
 * 
 * @todo see http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#adding-rules-dynamically
 * @author nadar
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
        
        if ($moduleName !== false) {
            $moduleObject = \yii::$app->getModule($moduleName);
            
            if (!empty($moduleObject->getContext())) {
                $options = $moduleObject->getContextOptions();
                $link = \yii::$app->collection->links->findOneByArguments(['nav_item_id' => $options['navItemId']]);
                $response = str_replace($moduleName, \yii::$app->collection->composition->getFull() . '/' . $link['url'], $response);
            }
        }
        return $response;
    }
}
