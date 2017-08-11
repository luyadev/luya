<?php

namespace luya\cms\admin\controllers;

use \luya\cms\models\Log;
use luya\admin\base\Controller;

/**
 * 
 * @author Basil Suter <basil@nadar.io>
 *
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $data = Log::find()->orderBy(['timestamp' => SORT_DESC])->limit(40)->all();
        $groups = [];
        foreach ($data as $item) {
            $groups[strtotime('today', $item->timestamp)][] = $item;
        }
        return $this->render('index', [
            'groups' => $groups,
        ]);
    }
}
