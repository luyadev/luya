<?php

namespace luya\cms\admin\apis;

use Yii;
use luya\helpers\ArrayHelper;
use luya\cms\admin\helpers\MenuHelper;
use yii\db\Query;
use luya\admin\models\Group;
use luya\cms\models\NavContainer;

/**
 * Menu Api provides commont tasks to retrieve cmsadmin menu data and cms group permissions setting tasks.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class MenuController extends \luya\admin\base\RestController
{
    public function actionDataMenu()
    {
        return [
            'items' => ArrayHelper::typeCast(MenuHelper::getItems()),
            'drafts' => ArrayHelper::typeCast(MenuHelper::getDrafts()),
            'containers' => ArrayHelper::typeCast(MenuHelper::getContainers()),
            'hiddenCats' => ArrayHelper::typeCast(Yii::$app->adminuser->identity->setting->get("togglecat", [])),
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
            $this->getItems($container);

            $data['containers'][] = [
                'containerInfo' => $container,
                'items' => isset(self::$_permissionItemData[$container->id]) ? self::$_permissionItemData[$container->id] : [],
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

    private $_groups;

    private function getGroups()
    {
        if ($this->_groups === null) {
            $this->_groups = Group::find()->all();
        }

        return $this->_groups;
    }

    private static $_permissionItemData = [];

    private function getItems(NavContainer $container, $parentNavId = 0, $parentGroup = [], $index = 1)
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

            $array['nav_level'] = $index;

            self::$_permissionItemData[$container->id][] = $array;

            $this->getItems($container, $nav->id, $array['groups'], $index+1);

            //$data[] = $array;
        }

        //return $data;
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

            return Yii::$app->db->createCommand()->insert('cms_nav_permission', ['group_id' => $groupId, 'nav_id' => $navId, 'inheritance' => true])->execute();
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
