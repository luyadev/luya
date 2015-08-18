<?php

namespace tests\src\web\models;

class AdminModelStorageFilterTest extends BaseModel
{
    public function getModel()
    {
        return new \admin\models\StorageFilter();
    }
    
    public function getParams()
    {
        return [
            'name',
            'identifier',
        ];
    }
}