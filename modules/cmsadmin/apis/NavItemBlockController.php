<?php

namespace cmsadmin\apis;

use cmsadmin\models\NavItemPageBlockItem;
use Yii;

class NavItemBlockController extends \admin\base\RestController
{
    public function actionCopyBlockFromStack()
    {
        $post = Yii::$app->request->post();
        
        $model = NavItemPageBlockItem::findOne(Yii::$app->request->post('copyBlockId', 0));
        
        if ($model) {
            $newModel = new NavItemPageBlockItem();
            $newModel->attributes = $model->toArray();
            $newModel->is_dirty = 0;
            $newModel->prev_id = Yii::$app->request->post('prevId', false);
            $newModel->placeholder_var = Yii::$app->request->post('placeholder_var', false);
            $newModel->sort_index = Yii::$app->request->post('sortIndex', false);
            $newModel->nav_item_page_id = Yii::$app->request->post('nav_item_page_id', false);
            if ($newModel->insert(false)) {
                return ['response' => true];
            }
        }
        
        return ['response' => false];
    }
}
