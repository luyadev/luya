<?php
namespace luya\components;

class UrlManager extends \yii\web\UrlManager
{
    public $enablePrettyUrl = true;
    
    public $showScriptName = false;
    
    public $rules = [
        ['class' => 'luya\components\UrlRule']
    ];
    
    public function clearRules()
    {
        $this->rules = [];
    }
}
