<?php

namespace cms\components;

class Page extends \yii\base\Component
{
    public $model = null;

    public function getProperty($name)
    {
        $object = $this->model->nav->getProperty($name);

        if ($object) {
            return $object->getValue();
        }

        return false;
    }
    
    public function getProperties()
    {
        return $this->model->nav->getProperties();
    }
}
