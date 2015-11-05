<?php

namespace cms\components;

use Yii;

class Page extends \yii\base\Component
{
    public $model = null;
    
    public function getProperty($name)
    {
        $object = $this->model->nav->getProperty($name);
        
        if ($object) {
            return $object->value;
        }
        
        return false;
    }
}