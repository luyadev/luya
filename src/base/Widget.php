<?php

namespace luya\base;

use ReflectionClass;
use yii\helpers\Inflector;

class Widget extends \yii\base\Widget
{
    public function getViewPath()
    {
        $class = new ReflectionClass($this);
        
        return '@app/views/widgets/' . Inflector::camel2id($class->getShortName());
    }
}
