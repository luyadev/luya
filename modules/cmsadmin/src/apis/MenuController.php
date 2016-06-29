<?php

namespace cmsadmin\apis;

use luya\helpers\ArrayHelper;
use cmsadmin\helpers\MenuHelper;

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
}
