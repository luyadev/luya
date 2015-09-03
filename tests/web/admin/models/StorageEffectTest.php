<?php

namespace tests\web\admin\models;

class StorageEffectTest extends \tests\web\BaseModel
{
    public function getModel()
    {
        return new \admin\models\StorageEffect();
    }

    public function getParams()
    {
        return [
            'name',
            'identifier',
            'imagine_name',
            'imagine_json_params',
        ];
    }
}
