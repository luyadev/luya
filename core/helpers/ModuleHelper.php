<?php

namespace luya\helpers;

use Yii;
use luya\base\ModuleReflection;

/**
 * Module Helper class
 * 
 * @author nadar
 */
class ModuleHelper
{
    /**
     * Create module reflection object based on a luya module.
     * 
     * @param \luya\base\Module $moduleObject The module 
     * @return \luya\base\ModuleReflection The reflection module object
     */
    public static function reflectionObject(\luya\base\Module $moduleObject)
    {
        return Yii::createObject(['class' => ModuleReflection::className(), 'module' => $moduleObject]);
    }
}
