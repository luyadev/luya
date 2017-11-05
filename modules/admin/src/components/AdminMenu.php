<?php

namespace luya\admin\components;

use Yii;
use Exception;
use luya\helpers\ArrayHelper;

/**
 * Admin Menu Data.
 *
 * Collect informations from the menu data based on the admin modules in order to generate the different admin menu levels and containers.
 *
 * @property array $menu Returns an array with all menu elements.
 * @property integer $userId Returns the current admin user id.
 * @property array $adminModuleMenus An array with \luya\admin\components\AdminMenuBuilderInterface objects.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class AdminMenu extends \yii\base\Component
{
    /**
     * Get current admin user id.
     *
     * @return integer
     */
    public function getUserId()
    {
        return Yii::$app->adminuser->getId();
    }
    
    /**
     * Get the module menus.
     *
     * @return \luya\admin\components\AdminMenuBuilderInterface An array with AdminMenuBuilderInterface objects.
     */
    public function getAdminModuleMenus()
    {
        return Yii::$app->getModule('admin')->moduleMenus;
    }
    
    private $_menu;

    /**
     * Return the menu array entries from all registered admin modules.
     *
     * Response array is organized as follow:
     *
     * + Node (Root level menu)
     *   + Group
     *      + Items
     *
     * Example array response:
     *
     * ```php
     * Array (
     * [id] => 1, // auto assigned
     * [moduleId] => admin
     * [template] =>
     * [routing] => default
     * [alias] => menu_node_system
     * [icon] => layers
     * [permissionRoute] =>
     * [permissionIsRoute] =>
     * [searchModelClass] =>
     * [groups] => Array ( // Optional
     *        [menu_group_access] => Array  (
     *               [name] => menu_group_access
     *               [items] => Array  (
     *                       [0] => Array (
     *                               [alias] => menu_access_item_user
     *                               [route] => admin/user/index
     *                               [icon] => person
     *                               [permssionApiEndpoint] => api-admin-user
     *                               [permissionIsRoute] =>
     *                               [permissionIsApi] => 1
     *                               [searchModelClass] =>
     *                               [options] => Array ()
     *                           )
     *                       [1] => Array  (
     *                               [alias] => menu_access_item_group
     *                               [route] => admin/group/index
     *                               [icon] => group
     *                               [permssionApiEndpoint] => api-admin-group
     *                               [permissionIsRoute] =>
     *                               [permissionIsApi] => 1
     *                               [searchModelClass] =>
     *                               [options] => Array ( )
     *                           )
     *                   )
     *           )
     * )
     * ```
     *
     * @return array
     */
    public function getMenu()
    {
        if ($this->_menu !== null) {
            return $this->_menu;
        }
        
        $menu = [];
        foreach ($this->getAdminModuleMenus() as $menuBuilder) {
            // removed legacy support, menu must be instance of AdminmenuBuilderInterface
            if (!$menuBuilder instanceof AdminMenuBuilderInterface) {
                throw new Exception("admin menu must be instance of AdminMenuBuilderInterface");
            }
            // call the interface menu method returns the array for the given Module.
            $data = $menuBuilder->menu();
            $menu = ArrayHelper::merge($data, $menu);
        }
        
        $this->_menu = $menu;

        return $menu;
    }

    /**
     * Get the node for a given array key.
     *
     * @param integer $id
     * @return boolean|array
     */
    public function getNodeData($id)
    {
        if (!isset($this->getMenu()[$id])) {
            return false;
        }
        
        return $this->getMenu()[$id];
    }

    private $_modules;
    
    /**
     * Returns an Array with modules and checks the permission for those.
     *
     * Example Response:
     *
     * ```php
     * Array (
     * 'moduleId' => 'admin',
     * 'id' => 1,
     * 'template' => $item['template'],
     * 'routing' => $item['routing'],
     * 'alias' => $alias,
     * 'icon' => $item['icon'],
     * 'searchModelClass' => $item['searchModelClass'],
     * )
     * ```
     *
     * @throws \Exception
     * @return array Returns an array with all modules you have permission for.
     */
    public function getModules()
    {
        if ($this->_modules !== null) {
            return $this->_modules;
        }
        
        $responseData = [];
        foreach ($this->getMenu() as $item) {
            // check if this is an entrie with a permission
            if ($item['permissionIsRoute']) {
                // verify if the permission is provided for this user:
                // if the permission is granted will write inti $responseData,
                // if not we continue;
                if (!Yii::$app->auth->matchRoute($this->getUserId(), $item['permissionRoute'])) {
                    continue;
                }
            }

            // this item does have groups
            if (isset($item['groups'])) {
                $permissionGranted = false;

                // see if the groups has items
                foreach ($item['groups'] as $groupName => $groupItem) {
                    if (count($groupItem['items'])  > 0) {
                        if ($permissionGranted) {
                            continue;
                        }

                        foreach ($groupItem['items'] as $groupItemEntry) {
                            // a previous entry already has solved the question if the permission is granted
                            if ($permissionGranted) {
                                continue;
                            }
                            if ($groupItemEntry['permissionIsRoute']) {
                                // when true, set permissionGranted to true
                                if (Yii::$app->auth->matchRoute($this->getUserId(), $groupItemEntry['route'])) {
                                    $permissionGranted = true;
                                }
                            } elseif ($groupItemEntry['permissionIsApi']) {
                                // when true, set permissionGranted to true
                                if (Yii::$app->auth->matchApi($this->getUserId(), $groupItemEntry['permssionApiEndpoint'])) {
                                    $permissionGranted = true;
                                }
                            } else {
                                throw new \Exception('Menu item detected without permission entry');
                            }
                        }
                    }
                }

                if (!$permissionGranted) {
                    continue;
                }
            }
            
            try {
                $alias = Yii::t($item['moduleId'], $item['alias'], [], Yii::$app->language);
            } catch (\Exception $err) {
                $alias = $item['alias'];
            }
            
            // ok we have passed all the tests, lets make an entry
            $responseData[] = [
                'moduleId' => $item['moduleId'],
                'id' => $item['id'],
                'template' => $item['template'],
                'routing' => $item['routing'],
                'alias' => $alias,
                'icon' => $item['icon'],
                'searchModelClass' => $item['searchModelClass'],
            ];
        }

        $this->_modules = $responseData;

        return $responseData;
    }
    
    
    private $_nodeItems = [];

    /**
     * Returns the node with a groups array where each groups contains an items array with the item.
     *
     * @param integer $nodeId
     * @throws \Exception
     * @return array If there are not groups, or not items for a group an empty array will be returned.
     */
    public function getModuleItems($nodeId)
    {
        if (isset($this->_nodeItems[$nodeId])) {
            return $this->_nodeItems[$nodeId];
        }
        
        $data = $this->getNodeData($nodeId);
        
        if (isset($data['groups'])) {
            foreach ($data['groups'] as $groupName => $groupItem) {
                // translate the group names
                try {
                    $data['groups'][$groupName]['name'] = Yii::t($data['moduleId'], $groupItem['name'], [], Yii::$app->language);
                } catch (\Exception $e) {
                    // do nothing and keep the current name inside the array
                }
                foreach ($groupItem['items'] as $groupItemKey => $groupItemEntry) {
                    if ($groupItemEntry['permissionIsRoute']) {
                        if (!Yii::$app->auth->matchRoute($this->getUserId(), $groupItemEntry['route'])) {
                            unset($data['groups'][$groupName]['items'][$groupItemKey]);
                            continue;
                        }
                    } elseif ($groupItemEntry['permissionIsApi']) {
                        if (!Yii::$app->auth->matchApi($this->getUserId(), $groupItemEntry['permssionApiEndpoint'])) {
                            unset($data['groups'][$groupName]['items'][$groupItemKey]);
                            continue;
                        }
                    } else {
                        throw new \Exception('Menu item detected without permission entry');
                    }
                    try {
                        $alias = Yii::t($data['moduleId'], $data['groups'][$groupName]['items'][$groupItemKey]['alias'], [], Yii::$app->language);
                    } catch (Exception $err) {
                        $alias = $data['groups'][$groupName]['items'][$groupItemKey]['alias'];
                    }
                    
                    $data['groups'][$groupName]['items'][$groupItemKey]['hiddenInMenu'] = AdminMenuBuilder::getOptionValue($groupItemEntry, 'hiddenInMenu', false);
                    $data['groups'][$groupName]['items'][$groupItemKey]['alias'] = $alias;
                }
                
                // if there are no items for this group, unset the group from the data array
                if (count($data['groups'][$groupName]['items']) == 0) {
                    unset($data['groups'][$groupName]);
                }
            }
            
            // if there are no groups reset the array to an empty array
            if (empty($data['groups'])) {
                $data = [];
            }
        } else {
            // as we want to catch all groups and the items of the groups, if the group has no items reset the array to an empty arrray
            $data = [];
        }

        $this->_nodeItems[$nodeId] = $data;

        return $data;
    }

    private $_items;
    
    /**
     * Get all items for all nodes.
     *
     * @return array
     */
    public function getItems()
    {
        if ($this->_items !== null) {
            return $this->_items;
        }
        
        $data = [];
        foreach ($this->getModules() as $node) {
            foreach (ArrayHelper::getValue($this->getModuleItems($node['id']), 'groups', []) as $groupValue) {
                foreach ($groupValue['items'] as $array) {
                    $array['module'] = $node;
                    $data[] = $array;
                }
            }
        }

        $this->_items = $data;
        
        return $data;
    }

    /**
     * Return all informations about a menu point based on the api endpoint name.
     *
     * @param string $api The Api Endpoint
     * @return array|boolean
     */
    public function getApiDetail($api)
    {
        $items = $this->getItems();
        
        $key = array_search($api, array_column($items, 'permssionApiEndpoint'));
        
        if ($key !== false) {
            return $items[$key];
        }
        
        return false;
    }
}
