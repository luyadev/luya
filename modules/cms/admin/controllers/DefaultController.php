<?php

namespace luya\cms\admin\controllers;

use \luya\cms\models\Log;

class DefaultController extends \luya\admin\base\Controller
{
    public function actionIndex()
    {
        $data = Log::find()->orderBy(['timestamp' => SORT_DESC])->limit(40)->all();
        $groups = [];
        foreach ($data as $item) {
            $groups[strtotime('today', $item->timestamp)][] = $item;
        }
        return $this->renderPartial('index', [
            'groups' => $groups,
        ]);
    }
}
