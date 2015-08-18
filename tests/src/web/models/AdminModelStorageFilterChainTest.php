<?php

namespace tests\src\web\models;

class AdminModelStorageFilterChainTest extends BaseModel
{
    public $createScenario = 'default';
    
    public $updateScenario = 'default';
    
    public function getModel()
    {
        return new \admin\models\StorageFilterChain();
    }
    
    public function getParams()
    {
        return [
            'filter_id',
            'effect_id',
            'effect_json_values'
        ];
    }
}