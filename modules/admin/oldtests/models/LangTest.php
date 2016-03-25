<?php

namespace tests\web\admin\models;

class LangTest extends \tests\web\BaseModel
{
    public function getModel()
    {
        return new \admin\models\Lang();
    }

    public function getParams()
    {
        return [
            'name',
            'short_code',
        ];
    }
}
