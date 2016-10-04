<?php

namespace luya\admin\apis;

use Yii;
use Exception;
use luya\admin\models\SearchData;
use luya\admin\base\RestController;
use luya\admin\base\GenericSearchInterface;

/**
 * Search API, allows you to perform search querys for the entire administration including all items provided in the auth section.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class SearchController extends RestController
{
    public function actionIndex($query)
    {
        $search = [];
        $module = Yii::$app->getModule('admin');

        foreach (Yii::$app->adminmenu->getModules() as $node) {
            if (isset($node['searchModelClass']) && !empty($node['searchModelClass'])) {
                $model = Yii::createObject($node['searchModelClass']);
                if (!$model instanceof GenericSearchInterface) {
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
                $stateProvider = $ctrl[0]->runAction('search-provider');
                if (count($data) > 0) {
                    $search[] = [
                        'type' => 'api',
                        'menuItem' => $api,
                        'data' => $data,
                        'stateProvider' => $stateProvider,
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
