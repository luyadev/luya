<?php

namespace cmsadmin\apis;

use luya\helpers\ArrayHelper;
use cmsadmin\helpers\MenuHelper;
use yii\db\Query;

class MenuController extends \admin\base\RestController
{
    public function actionDataMenu()
    {
        return [
            'items' => ArrayHelper::typeCast(MenuHelper::getItems()),
            'drafts' => ArrayHelper::typeCast(MenuHelper::getDrafts()),
            'containers' => ArrayHelper::typeCast(MenuHelper::getContainers()),
        ];
    }
    
    public function actionDataPermissions()
    {
		return ArrayHelper::index((new Query())->select("*")->from("cms_nav_permission")->all(), null, 'nav_id'); 	
    }
}
