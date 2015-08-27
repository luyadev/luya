<?php

namespace cms\helpers;

use Yii;
use cmsadmin\models\NavItem;

class Url
{
    /**
     * if the module could not be found (not registered in the cms) the method returns the provided module name.
     * 
     * returns only ONE even if there are more! not good structure inside the cms?
     * 
     * @param string $moduleName
     *
     * @return url
     */
    public static function toModule($moduleName)
    {
        $model = NavItem::find()->leftJoin('cms_nav_item_module', 'nav_item_type_id=cms_nav_item_module.id')->where(['nav_item_type' => 2, 'cms_nav_item_module.module_name' => $moduleName])->asArray()->one();

        if ($model) {
            $link = Yii::$app->links->findOneByArguments(['id' => $model['id']]);
            if ($link) {
                return $link['full_url'];
            }
        }

        return $moduleName;
    }
}
