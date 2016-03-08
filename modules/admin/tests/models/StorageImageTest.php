<?php

namespace tests\web\admin\models;

class StorageImageTest extends \tests\web\BaseModel
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
