<?php

namespace tests\web\admin\models;

class StorageFilterTest extends \tests\web\BaseModel
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
