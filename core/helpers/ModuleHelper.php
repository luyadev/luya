<?php

namespace luya\helpers;

use Yii;
use luya\base\ModuleReflection;
use luya\Exception;

/**
 * Module Helper class
 * 
 * @author Basil Suter <basil@nadar.io>
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
