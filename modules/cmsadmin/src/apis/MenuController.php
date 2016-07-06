<?php

namespace cmsadmin\apis;

use Yii;
use luya\helpers\ArrayHelper;
use cmsadmin\helpers\MenuHelper;
use yii\db\Query;

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
    
    public function actionDataPermissions()
    {
		return ArrayHelper::index((new Query())->select("*")->from("cms_nav_permission")->all(), null, 'nav_id'); 	
    }
    
    public function actionDataPermissionRemove()
    {
        $navId = Yii::$app->request->getBodyParam('navId');
        $groupId = Yii::$app->request->getBodyParam('groupId');
        
        if (!empty($navId) && !empty($groupId)) {
            return Yii::$app->db->createCommand()->delete('cms_nav_permission', ['group_id' => $groupId, 'nav_id' => $navId])->execute();
        }
    }
    
    public function actionDataPermissionInsert()
    {
        $navId = Yii::$app->request->getBodyParam('navId');
        $groupId = Yii::$app->request->getBodyParam('groupId');
        
        if (!empty($navId) && !empty($groupId)) {
            return Yii::$app->db->createCommand()->insert('cms_nav_permission', ['group_id' => $groupId, 'nav_id' => $navId])->execute();
        }
    }
    
    public function actionDataPermissionInheritance()
    {
        $navId = Yii::$app->request->getBodyParam('navId');
        $groupId = Yii::$app->request->getBodyParam('groupId');
        
        if (!empty($navId) && !empty($groupId)) {
            $one = (new Query())->select("*")->from("cms_nav_permission")->where(['group_id' => $groupId, 'nav_id' => $navId])->one();
            
            if ($one) {
                Yii::$app->db->createCommand()->delete('cms_nav_permission', ['group_id' => $groupId, 'nav_id' => $navId])->execute();
            }
            
            return Yii::$app->db->createCommand()->insert('cms_nav_permission', ['group_id' => $groupId, 'nav_id' => $navId, 'inheritance' => 1])->execute();
        }
    }
}
