<?php
namespace luya\components;

/**
 * 
 * @todo see http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#adding-rules-dynamically
 * @todo change to public $ruleConfig = ['class' => 'yii\web\UrlRule'];
 * 
 * @author nadar
 */
class UrlManager extends \yii\web\UrlManager
{
    public $enablePrettyUrl = true;

    public $showScriptName = false;
    /*
    public $compositionPatterns = [];
    
    private function addCompositionPattern($rule, $composition, $compositionPattern)
    {
        $this->compositionPatterns[$composition][] = [
            'rule' => $rule,
            'compositionPattern' => $compositionPattern
        ];
    }
    
    public function addRules($rules, $append = true)
    {
        foreach ($rules as $key => $rule) {
            if (isset($rule['compositionPattern']) && isset($rule['pattern'])) {
                foreach($rule['compositionPattern'] as $composition => $compositionPattern) {
                    $this->addCompositionPattern($rule, $composition, $compositionPattern);
                }
                unset ($rules[$key]['compositionPattern']);
            }
        }
        parent::addRules($rules, $append);
    }
    
    public function parseCompositeRequest($request, $composition)
    {
        $_rules = [];
        
        foreach ($this->compositionPatterns[$composition] as $rule) {
            $_rules[] = ['pattern' => $rule['compositionPattern'], 'route' => $rule['rule']['route']];
        }
        
        $_oldRules = $this->rules;
        
        parent::addRules($_rules, false);
        
        $return = $this->parseRequest($request);
        
        $this->rules = $_oldRules;
        
        return $return;
    }
    
    
    public function createCompositeUrl($params, $composition)
    {
        $_rules = [];
        
        foreach ($this->compositionPatterns[$composition] as $rule) {
            $_rules[] = ['pattern' => $rule['compositionPattern'], 'route' => $rule['rule']['route']];
        }
        
        $_oldRules = $this->rules;
        
        parent::addRules($_rules, false);
        
        $return = $this->createUrl($params);
        
        $this->rules = $_oldRules;
        
        return $return;
    }
    */ 
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
