<?php

namespace luya\helpers;

use Yii;
use luya\base\ModuleReflection;

class ModuleHelper
{
    public static function reflectionObject(\luya\base\Module $moduleObject)
    {
        return Yii::createObject(['class' => ModuleReflection::className(), 'module' => $moduleObject]);
    }
}
