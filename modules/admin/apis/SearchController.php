<?php

namespace admin\apis;

use Yii;
use Exception;
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
        
        foreach(Yii::$app->menu->getModules() as $node) {
            if (isset($node['searchModelClass']) && !empty($node['searchModelClass'])) {
                $model = Yii::createObject($node['searchModelClass']);
                if (!$model instanceof \admin\base\GenericSearchInterface) {
                    throw new Exception("The model must be an instance of GenericSearchInterface");
                }
                $data = $model->genericSearch($query);
                if (count($data) > 0) {
                    $search[] = [
                        'menuItem' => $node,
                        'data' => $data,
                    ];
                }
            }
        }
        
        foreach(Yii::$app->menu->getItems() as $api) {
            if ($api['permissionIsApi']) {
                $ctrl = $module->createController($api['permssionApiEndpoint']);
                $data = $ctrl[0]->runAction('search', ['query' => $query]);
                if (count($data) > 0) {
                    $search[] = [
                        'menuItem' => $api,
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
