<?php

namespace cmsadmin\helpers;

use Yii;
use admin\models\Lang;
use yii\db\Query;
use luya\helpers\ArrayHelper;

/**
 * Menu Helper to collect Data used in Administration areas.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta8
 */
class MenuHelper
{
    private static $items = null;
    
    /**
     * Get all nav data entries with corresponding item content
     * 
     * @return array
     */
    public static function getItems()
    {
        if (self::$items === null) {
            $items = (new Query())
            ->select(['cms_nav.id', 'nav_item_id' => 'cms_nav_item.id', 'nav_container_id', 'parent_nav_id', 'is_hidden', 'is_offline', 'is_draft', 'is_home', 'cms_nav_item.title'])
            ->from('cms_nav')
            ->leftJoin('cms_nav_item', 'cms_nav.id=cms_nav_item.nav_id')
            ->orderBy('cms_nav.sort_index ASC')
            ->where(['cms_nav_item.lang_id' => Lang::getDefault()['id'], 'cms_nav.is_deleted' => 0, 'cms_nav.is_draft' => 0])
            ->all();
            
            $data = [];
            
            foreach ($items as $key => $item) {
            
                $item['is_editable'] = (int) Yii::$app->adminuser->canRoute('cmsadmin/page/update');
                
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
                    
                    $item['is_editable'] = $permitted;
                }
            
                $data[$key] = $item;
            }
            
            self::$items = $data;
        }
        
        return self::$items;
    }
    
    public static function navGroupPermission($navId, $groupId)
    {
        $definitions = (new Query())->select("*")->from("cms_nav_permission")->where(['group_id' => $groupId])->all();
        
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
    
    private static $containerItems = null;
    
    /**
     * Get all containers with theyr corresponding items.
     */
    public static function getContainerItems()
    {
        if (self::$containerItems === null) {
            self::$containerItems = ArrayHelper::index(static::getItems(), null, 'nav_container_id');
        }
        
        return self::$containerItems;
    }
    
    private static $containerItemsParentGroups = [];
    
    public static function getContainerItemsParentGroups($containerId)
    {
        if (!array_key_exists($containerId, self::$containerItemsParentGroups)) {
            self::$containerItemsParentGroups[$containerId] = ArrayHelper::index(static::getItemsFromContainer($containerId), null, 'parent_nav_id');
        }
        return self::$containerItemsParentGroups[$containerId];
    }

    public static function getContainerItemsParentGroup($containerId, $parentId)
    {
        return isset(self::getContainerItemsParentGroups($containerId)[$parentId]) ? self::getContainerItemsParentGroups($containerId)[$parentId] : [];
    }

    /**
     * Get all items for a specific container.
     * 
     * @param unknown $containerId
     */
    public static function getItemsFromContainer($containerId)
    {
        return (isset(static::getContainerItems()[$containerId])) ? static::getContainerItems()[$containerId] : [];
    }
    
    private static $containers = null;
    
    /**
     * Get all cms containers
     * 
     * @return array
     */
    public static function getContainers()
    {
        if (self::$containers === null) {
            self::$containers = (new Query())->select(['id', 'name'])->from('cms_nav_container')->where(['is_deleted' => 0])->indexBy('id')->orderBy(['cms_nav_container.id' => 'ASC'])->all();
        }
        
        return self::$containers;
    }
    
    private static $drafts = null;
    
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
            ->where(['cms_nav_item.lang_id' => Lang::getDefault()['id'], 'cms_nav.is_deleted' => 0, 'cms_nav.is_draft' => 1])
            ->all();
        }
        
        return self::$drafts;
    }
}