<?php

namespace tests\src\web\models;

class AdminModelStorageImageTest extends BaseModel
{
    public $createScenario = 'default';
    
    public $updateScenario = 'default';
    
    public function getModel()
    {
        return new \admin\models\StorageImage();
    }
    
    public function getParams()
    {
        return [
            'file_id',
            'filter_id',
        ];
    }
}