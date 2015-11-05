<?php

namespace cms\components;

use Yii;

class Page extends \yii\base\Component
{
    public $model = null;
    
    public function getProperty($name)
    {
        return $this->model->nav->getProperty($name)->value;
    }
}