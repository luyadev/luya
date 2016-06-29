<?php

namespace cmsadmin\controllers;

use admin\base\Controller;
use cmsadmin\helpers\MenuHelper;

class PermissionController extends Controller
{
    public function actionIndex()
    {
        //var_dumP(MenuHelper::getContainers());
        //print_r(MenuHelper::getContainerItems());
        
        //print_r(MenuHelper::getContainerItemsParentGroup(1, 0));
        //exit;
        $data = [];
        foreach (MenuHelper::getContainers() as $container) {
            $data[] = [
                'container' => $container,
                'items' => $this->getItems($container['id']),
            ];
        }
        
        return $this->renderPartial('index', [
            'data' => $data,
        ]);
    }
    
    private function getItems($containerId, $parentNavId = 0)
    {
        $items = MenuHelper::getContainerItemsParentGroup($containerId, $parentNavId);
        
        $data = [];
        
        foreach ($items as $k => $v) {
            
            $v['__children'] = $this->getItems($containerId, $v['id']);
            $data[] = $v;
        }
        
        return $data;
    }
}