<?php

namespace luya\cms\admin\helpers;

use Yii;
use luya\admin\models\Lang;
use yii\db\Query;
use luya\cms\models\Nav;
use luya\admin\models\Group;
use luya\helpers\ArrayHelper;

/**
 * Menu Helper to collect Data used in Administration areas.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class MenuHelper
{
    private static $items;
    
    /**
     * Get all nav data entries with corresponding item content
     *
     * @return array
     */
    public static function getItems()
    {
        if (self::$items === null) {
            $items = (new Query())
            ->select(['cms_nav.id', 'nav_item_id' => 'cms_nav_item.id', 'nav_container_id', 'parent_nav_id', 'is_hidden', 'layout_file', 'is_offline', 'is_draft', 'is_home', 'cms_nav_item.title', 'publish_from', 'publish_till'])
            ->from('cms_nav')
            ->leftJoin('cms_nav_item', 'cms_nav.id=cms_nav_item.nav_id')
            ->orderBy(['sort_index' => SORT_ASC])
            ->where(['cms_nav_item.lang_id' => Lang::getDefault()['id'], 'cms_nav.is_deleted' => false, 'cms_nav.is_draft' => false])
            ->all();
            
            self::loadInheritanceData(0);
            
            $data = [];
            
            foreach ($items as $key => $item) {
                $item['is_editable'] = (int) Yii::$app->adminuser->canRoute('cmsadmin/page/update');
                $item['toggle_open'] = (int) Yii::$app->adminuser->identity->setting->get('tree.'.$item['id']);
                
                // the user have "page edit" permission, now we can check if the this group has more fined tuned permisionss from the
                // cms_nav_permissions table or not
                if ($item['is_editable']) {
                    $permitted = false;
                    
                    foreach (Yii::$app->adminuser->identity->groups as $group) {
                        if ($permitted) {
                            continue;
                        }
                        
                        $permitted = self::navGroupPermission($item['id'], $group->id);
                    }

                    if (!$permitted) {
                        $value = (isset(self::$_inheritData[$item['id']])) ? self::$_inheritData[$item['id']] : false;
                        if ($value === true) {
                            $permitted = true;
                        }
                    }
                    
                    $item['is_editable'] = $permitted;
                }
            
                $data[$key] = $item;
            }
            
            self::$items = $data;
        }
        
        return self::$items;
    }
    
    /* LOAD INHERITANCE CHECK FOR ITEMS AND STORE INT $data*/
    
    private static $_inheritData = [];
    
    private static $_navItems;
    
    private static function getNavItems()
    {
        if (self::$_navItems === null) {
            $items = Nav::find()->select(['sort_index', 'id', 'parent_nav_id', 'is_deleted'])->where(['is_deleted' => false])->orderBy(['sort_index' => SORT_ASC])->asArray()->all();
            return self::$_navItems = ArrayHelper::index($items, null, 'parent_nav_id');
        }
        
        return self::$_navItems;
    }
    
    /**
     * Find nav_id inheritances
     *
     * + Get all cms_nav items where is deleted 0 and sort_asc
     * + foreach items
     * + foreach all user groups for this item to check if an inheritance nod exists for this nav_item (self::navGroupInheritanceNode)
     * + Set the interanl check to false, if inherit or internal check is true, set value into $data factory
     * + proceed nodes of the current item with the information form $data factory as inheritation info.
     *
     * @param integer $parentNavId
     * @param string $fromInheritNode
     */
    private static function loadInheritanceData($parentNavId = 0, $fromInheritNode = false)
    {
        // get items from singleton object
        $items = (isset(self::getNavItems()[$parentNavId])) ? self::getNavItems()[$parentNavId] : [];
        foreach ($items as $item) {
            $internalCheck = false;
            foreach (Yii::$app->adminuser->identity->groups as $group) {
                if ($internalCheck) {
                    continue;
                }
                $internalCheck = self::navGroupInheritanceNode($item['id'], $group);
            }
            if (!array_key_exists($item['id'], self::$_inheritData)) {
                if ($fromInheritNode || $internalCheck) {
                    self::$_inheritData[$item['id']] = true;
                } else {
                    self::$_inheritData[$item['id']] = false;
                }
            }
            
            self::loadInheritanceData($item['id'], self::$_inheritData[$item['id']]);
        }
    }
    
    /* NAV GROUP INHERITANCE NODE */
    
    private static $_cmsPermissionData;
    
    private static function getCmsPermissionData()
    {
        if (self::$_cmsPermissionData === null) {
            self::$_cmsPermissionData = ArrayHelper::index((new Query())->select("*")->from("cms_nav_permission")->all(), null, 'group_id');
        }
        
        return self::$_cmsPermissionData;
    }
    
    public static function navGroupInheritanceNode($navId, Group $group)
    {
        // default defintion is false
        $definition = false;
        // see if permission data for group exists, foreach items and set if match
        if (isset(self::getCmsPermissionData()[$group->id])) {
            foreach (self::getCmsPermissionData()[$group->id] as $item) {
                if ($item['nav_id'] == $navId) {
                    $definition = $item['inheritance'];
                }
            }
        }
        if ($definition) {
            return (bool) $definition;
        }
        
        return false;
    }
    
    /* NAV GROUP PERMISSION */
    
    private static $_navGroupPermissions;
    
    private static function getNavGroupPermissions()
    {
        if (self::$_navGroupPermissions === null) {
            self::$_navGroupPermissions = ArrayHelper::index((new Query())->select(['group_id', 'nav_id'])->from("cms_nav_permission")->all(), null, 'group_id');
        }

        return self::$_navGroupPermissions;
    }
    
    public static function navGroupPermission($navId, $groupId)
    {
        // get defintions from singleton
        $definitions = (isset(self::getNavGroupPermissions()[$groupId])) ? self::getNavGroupPermissions()[$groupId] : [];
        // the group has no permission defined, this means he can access ALL cms pages
        if (count($definitions) == 0) {
            return true;
        }
        
        foreach ($definitions as $permission) {
            if ($navId == $permission['nav_id']) {
                return true;
            }
        }
        
        return false;
    }
    
    private static $containers;
    
    /**
     * Get all cms containers
     *
     * @return array
     */
    public static function getContainers()
    {
        if (self::$containers === null) {
            self::$containers = (new Query())->select(['id', 'name', 'alias'])->from('cms_nav_container')->where(['is_deleted' => false])->indexBy('id')->orderBy(['cms_nav_container.id' => 'ASC'])->all();
        }
        
        return self::$containers;
    }
    
    private static $drafts;
    
    /**
     * Get all drafts nav items
     *
     * @return array
     */
    public static function getDrafts()
    {
        if (self::$drafts === null) {
            self::$drafts = (new Query())
            ->select(['cms_nav.id', 'nav_container_id', 'parent_nav_id', 'is_hidden', 'is_offline', 'is_draft', 'is_home', 'cms_nav_item.title'])
            ->from('cms_nav')
            ->leftJoin('cms_nav_item', 'cms_nav.id=cms_nav_item.nav_id')
            ->orderBy('cms_nav.sort_index ASC')
            ->where(['cms_nav_item.lang_id' => Lang::getDefault()['id'], 'cms_nav.is_deleted' => false, 'cms_nav.is_draft' => true])
            ->all();
        }
        
        return self::$drafts;
    }
}
