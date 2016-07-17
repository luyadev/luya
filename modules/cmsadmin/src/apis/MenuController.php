<?php

namespace cmsadmin\apis;

use Yii;
use luya\helpers\ArrayHelper;
use cmsadmin\helpers\MenuHelper;
use yii\db\Query;
use admin\models\Group;
use cmsadmin\models\NavContainer;

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
    
    /**
     * Returns the full tree with groups, pages, is_inherit or not, does have rights or not as it was to hard to
     * implement does features directly with angular, now we just prepare anything withing php and delivers to angular only to display the data.
     */
    public function actionDataPermissionTree()
    {
        $data = [];
        // collect data
        foreach (NavContainer::find()->with('navs')->all() as $container) {
            $data[] = [
                'container' => $container,
                'items' => $this->getItems($container),
            ];
        }
        // collect group informations
        foreach ($this->getGroups() as $group) {
            $data['groups'][] = [
                'name' => $group->name,
                'id' => $group->id,
                'fullPermission' => $this->groupHasFullPermission($group),
            ];
        }
        // return array with full data
        return $data;
    }
    
    private function groupHasFullPermission(Group $group)
    {
        $count = (new Query())->select("*")->from("cms_nav_permission")->where(['group_id' => $group->id])->count();
        
        if ($count > 0) {
            return false;
        }
        
        return true;
    }
    
    private $_groups = null;
    
    private function getGroups()
    {
        if ($this->_groups === null) {
            $this->_groups = Group::find()->all();
        }
        
        return $this->_groups;
    }
    
    private function getItems(NavContainer $container, $parentNavId = 0, $parentGroup = [])
    {
        $navs = $container->getNavs()->andWhere(['parent_nav_id' => $parentNavId])->all();
        
        $data = [];
        
        foreach ($navs as $nav) {
            $array = $nav->toArray();
            
            if (empty($nav->activeLanguageItem)) {
            	continue;
            }
            $array['title'] = $nav->activeLanguageItem->title;
            
            foreach ($this->getGroups() as $key => $group) {
                $isInheritedFromParent = false;
                
                if (isset($parentGroup[$key])) {
                    if ($parentGroup[$key]['isGroupPermissionInheritNode'] || $parentGroup[$key]['isInheritedFromParent']) {
                        $isInheritedFromParent = true;
                    }
                }
                
                $array['groups'][$key] = [
                    'id' => $group->id,
                    'isGroupPermissionInheritNode' => $nav->isGroupPermissionInheritNode($group),
                    'hasGroupPermission' => $nav->hasGroupPermission($group),
                    'isInheritedFromParent' => $isInheritedFromParent,
                    'permissionCheckbox' => $nav->hasGroupPermissionSelected($group),
                    'groupFullPermission' => $this->groupHasFullPermission($group),
                ];
            }
            
            $array['__children'] = $this->getItems($container, $nav->id, $array['groups']);
            
            $data[] = $array;
        }
        
        return $data;
    }
    
    public function actionDataPermissionDelete()
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
    
    public function actionDataPermissionInsertInheritance()
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
    
    public function actionDataPermissionDeleteInheritance()
    {
        $navId = Yii::$app->request->getBodyParam('navId');
        $groupId = Yii::$app->request->getBodyParam('groupId');
        
        if (!empty($navId) && !empty($groupId)) {
            $one = (new Query())->select("*")->from("cms_nav_permission")->where(['group_id' => $groupId, 'nav_id' => $navId])->one();
        
            if ($one) {
                Yii::$app->db->createCommand()->delete('cms_nav_permission', ['group_id' => $groupId, 'nav_id' => $navId])->execute();
            }
        }
    }
    
    public function actionDataPermissionGrantGroup()
    {
        $groupId = Yii::$app->request->getBodyParam('groupId');
        if ($groupId) {
            Yii::$app->db->createCommand()->delete('cms_nav_permission', ['group_id' => $groupId])->execute();
        }
    }
}
