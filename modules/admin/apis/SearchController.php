<?php

namespace admin\apis;

use Yii;

/**
 * @author nadar
 */
class SearchController extends \admin\base\RestController
{
    /**
     * @todo: changing the auser auth method, add user component
     */
    public function init()
    {
        parent::init();
        Yii::$app->menu->userId = $this->getUser()->id;
    }

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
        return $search;
    }
}
