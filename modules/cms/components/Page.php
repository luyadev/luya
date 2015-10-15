<?php

namespace cms\components;

use Yii;

class Page extends \yii\base\Component
{
    public $model = null;
    
    public function getProperty($name)
    {
        return $this->model->nav->getProperty($name);
    }
    
    public function getProperties()
    {
        return $this->model->nav->getProperties();
    }
}