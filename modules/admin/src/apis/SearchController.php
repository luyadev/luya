<?php

namespace luya\admin\apis;

use Yii;
use luya\Exception;
use luya\admin\models\SearchData;
use luya\admin\base\RestController;
use luya\admin\base\GenericSearchInterface;

/**
 * Search API, allows you to perform search querys for the entire administration including all items provided in the auth section.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SearchController extends RestController
{
    /**
     * Administration Global search provider.
     *
     * This method returns all node items with an search model class or a generic search interface instance and returns its data.
     *
     * @param string $query The query to search for.
     * @return array
     * @throws Exception
     */
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
                if (count($data) > 0) {
                    $stateProvider = $model->genericSearchStateProvider();
                    $search[] = [
                        'hideFields' => $model->genericSearchHiddenFields(),
                        'type' => 'custom',
                        'menuItem' => $node,
                        'data' => $data,
                        'stateProvider' => $stateProvider,
                    ];
                }
                
                unset($data);
            }
        }

        foreach (Yii::$app->adminmenu->getItems() as $api) {
            if ($api['permissionIsApi']) {
                $ctrl = $module->createController($api['permssionApiEndpoint']);
                $data = $ctrl[0]->runAction('search', ['query' => $query]);
                if (count($data) > 0) {
                    $stateProvider = $ctrl[0]->runAction('search-provider');
                    $hiddenFields = $ctrl[0]->runAction('search-hidden-fields');
                    $search[] = [
                        'hideFields' => $hiddenFields,
                        'type' => 'api',
                        'menuItem' => $api,
                        'data' => $data,
                        'stateProvider' => $stateProvider,
                    ];
                }
                unset($data);
            }
        }

        $searchData = new SearchData();
        $searchData->query = $query;
        $searchData->num_rows = count($search);
        $searchData->save();

        return $search;
    }
}
