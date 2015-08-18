<?php

namespace tests\src\web\models;

class AdminModelStorageFolderTest extends BaseModel
{
    public $createScenario = 'default';
    
    public $updateScenario = 'default';
    
    public function getModel()
    {
        return new \admin\models\StorageFolder();
    }
    
    public function getParams()
    {
        return [
            'name',
            'parent_id',
            'timestamp_create'
        ];
    }
}