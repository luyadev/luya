<?php

namespace admin\apis;

use Yii;
use admin\models\SearchData;

/**
 * @author nadar
 */
class SearchController extends \admin\base\RestController
{
    public function actionIndex($query)
    {
        $search = [];
        $module = Yii::$app->getModule('admin');
        foreach(Yii::$app->menu->getItems() as $api) {
            if ($api['permissionIsApi']) {
                $ctrl = $module->createController($api['permssionApiEndpoint']);
                $data = $ctrl[0]->runAction('search', ['query' => $query]);
                if (count($data) > 0) {
                    $search[] = [
                        'api' => $api,
                        'data' => $data,  
                    ];
                }
            }
        }
        
        $searchData = new SearchData();
        $searchData->query = $query;
        $searchData->num_rows = count($search);
        $searchData->insert();
        
        return $search;
    }
}
