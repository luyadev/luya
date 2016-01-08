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

        foreach (Yii::$app->adminmenu->getModules() as $node) {
            if (isset($node['searchModelClass']) && !empty($node['searchModelClass'])) {
                $model = Yii::createObject($node['searchModelClass']);
                if (!$model instanceof \admin\base\GenericSearchInterface) {
                    throw new Exception('The model must be an instance of GenericSearchInterface');
                }
                $data = $model->genericSearch($query);
                $stateProvider = $model->genericSearchStateProvider();
                
                if (count($data) > 0) {
                    $search[] = [
                    	'type' => 'custom',
                        'menuItem' => $node,
                        'data' => $data,
                    	'stateProvider' => $stateProvider,
                    ];
                }
            }
        }

        foreach (Yii::$app->adminmenu->getItems() as $api) {
            if ($api['permissionIsApi']) {
                $ctrl = $module->createController($api['permssionApiEndpoint']);
                $data = $ctrl[0]->runAction('search', ['query' => $query]);
                if (count($data) > 0) {
                    $search[] = [
                    	'type' => 'api',
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
