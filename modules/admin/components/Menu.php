<?php

namespace admin\components;

use Yii;
use \luya\helpers\Param;

class Menu extends \yii\base\Component
{
    
    private $_menu = null;
    
    private $_modules = null;
    
    private $_items = [];
    
    private $_nodes = [];
    
    public $userId = 0;
    
    public function getUserId()
    {
        return $this->userId;
    }
    
    public function getMenu()
    {
        if ($this->_menu === null) {
            $this->_menu = Param::get('adminMenus');
        }
        
        return $this->_menu;
    }
    
    public function getNodeData($id)
    {
        if (array_key_exists($id, $this->_nodes)) {
            return $this->_nodes[$id];
        }
        $i = 1;
        foreach ($this->getMenu() as $item) {
            $i++;
            if ($id == $i) {
                $data = $item;
                break;
            }
        }
    
        $this->_nodes[$id] = $data;
        
        return $data;
    }
    
    public function getModules()
    {
        if ($this->_modules !== null) {
            return $this->_modules;
        }
        $responseData = [];
        $index = 1;
        foreach ($this->getMenu() as $item) {
            $index++;
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
        
            // ok we have passed all the tests, lets make an entry
            $responseData[] = [
                'moduleId' => $item['moduleId'],
                'id' => $index,
                'template' => $item['template'],
                'routing' => $item['routing'],
                'alias' => $item['alias'],
                'icon' => $item['icon'],
            ];
        }
        
        $this->_modules = $responseData;
        
        return $responseData;
    }
    
    public function getModuleItems($nodeId)
    {
        if (array_key_exists($nodeId, $this->_items)) {
            return $this->_items[$nodeId];
        }
        $data = $this->getNodeData($nodeId);
        
        if (isset($data['groups'])) {
            foreach ($data['groups'] as $groupName => $groupItem) {
                foreach ($groupItem['items'] as $groupItemKey => $groupItemEntry) {
                    if ($groupItemEntry['permissionIsRoute']) {
                        // when true, set permissionGranted to true
                        if (!Yii::$app->auth->matchRoute($this->getUserId(), $groupItemEntry['route'])) {
                            unset($data['groups'][$groupName]['items'][$groupItemKey]);
                        } else {
                            /* fixed bug #51 */
                            $data['groups'][$groupName]['items'][$groupItemKey]['route'] = str_replace("/", "-", $data['groups'][$groupName]['items'][$groupItemKey]['route']);
                        }
                    } elseif ($groupItemEntry['permissionIsApi']) {
                        // when true, set permissionGranted to true
                        if (!Yii::$app->auth->matchApi($this->getUserId(), $groupItemEntry['permssionApiEndpoint'])) {
                            unset($data['groups'][$groupName]['items'][$groupItemKey]);
                        }
                    } else {
                        throw new \Exception('Menu item detected without permission entry');
                    }
                }
            }
        }
        
        $this->_items[$nodeId] = $data;
        return $data;
    }
    
    public function getItems()
    {
        $data = [];
        foreach($this->getModules() as $key => $node) {
            foreach($this->getModuleItems($node['id']) as $key => $value) {
                if ($key == "groups") {
                    foreach($value as $group => $groupValue) {
                        foreach($groupValue['items'] as $array) {
                            $data[] = $array;
                        }
                    }
                }
            }
        }
        return $data;
    }
}