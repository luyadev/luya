<?php

namespace admin\base;

use yii\helpers\ArrayHelper;

/**
 * define in module settings the ngrestConfigLinker property of each Module to override the local
 * use ngRestConfig.
 * 
 * ```php
 * [
 *  'class' => 'path\to\Module',
 *  'ngrestConfigLinker' => [
 *      'api-admin-user' => \new\path\to\Config::className(),
 *  ]
 * ]  
 * ```
 * 
 * @todo move node(), nodeRoute(), group(), itemApi(), itemRoute() into a seperate class.
 *
 * @author nadar
 */
class Module extends \luya\base\Module
{
    public $isAdmin = true;

    public $requiredComponents = ['db'];

    private $_menu = [];

    private $_pointers = [];

    private $_permissionApis = [];

    private $_permissionRoutes = [];

    public $ngrestConfigLinker = [];

    public function getLinkedNgRestConfig($apiEndpoint)
    {
        return array_key_exists($apiEndpoint, $this->ngrestConfigLinker) ? $this->ngrestConfigLinker[$apiEndpoint] : false;
    }

    public function getMenu()
    {
        return [];
    }

    protected function node($name, $icon, $template = false)
    {
        $this->_pointers['node'] = $name;
        $this->_menu[$name] = [
            'moduleId' => $this->id,
            'template' => $template,
            'routing' => $template ? 'custom' : 'default',
            'alias' => $name,
            'icon' => $icon,
            'permissionRoute' => false,
            'permissionIsRoute' => false,
            'searchModelClass' => false,
        ];

        return $this;
    }

    protected function nodeRoute($name, $icon, $template, $route, $searchModelClass = null)
    {
        $this->_pointers['node'] = $name;
        $this->_menu[$name] = [
            'moduleId' => $this->id,
            'template' => $template,
            'routing' => $template ? 'custom' : 'default',
            'alias' => $name,
            'icon' => $icon,
            'permissionRoute' => $route,
            'permissionIsRoute' => true,
            'searchModelClass' => $searchModelClass,
        ];

        $this->_permissionRoutes[] = ['route' => $route, 'alias' => $name];

        return $this;
    }

    protected function group($name)
    {
        $this->_pointers['group'] = $name;
        $this->_menu[$this->_pointers['node']]['groups'][$name] = ['name' => $name, 'items' => []];

        return $this;
    }

    protected function itemApi($name, $route, $icon, $apiEndpoint)
    {
        $this->_menu[$this->_pointers['node']]['groups'][$this->_pointers['group']]['items'][] = [
            'alias' => $name,
            'route' => $route,
            'icon' => $icon,
            'permssionApiEndpoint' => $apiEndpoint,
            'permissionIsRoute' => false,
            'permissionIsApi' => true,
            'searchModelClass' => false,
        ];

        $this->_permissionApis[] = ['api' => $apiEndpoint, 'alias' => $name];

        return $this;
    }

    protected function itemRoute($name, $route, $icon, $searchModelClass = null)
    {
        $this->_menu[$this->_pointers['node']]['groups'][$this->_pointers['group']]['items'][] = [
            'alias' => $name,
            'route' => $route,
            'icon' => $icon,
            'permssionApiEndpoint' => null,
            'permissionIsRoute' => true,
            'permissionIsApi' => false,
            'searchModelClass' => $searchModelClass,
        ];

        $this->_permissionRoutes[] = ['route' => $route, 'alias' => $name];

        return $this;
    }

    protected function menu()
    {
        return $this->_menu;
    }

    public function extendPermissionApis()
    {
        return [];
    }

    public function extendPermissionRoutes()
    {
        return [];
    }

    public function getAuthApis()
    {
        $this->getMenu();

        return ArrayHelper::merge($this->extendPermissionApis(), $this->_permissionApis);
    }

    public function getAuthRoutes()
    {
        $this->getMenu();

        return ArrayHelper::merge($this->extendPermissionRoutes(), $this->_permissionRoutes);
    }
}
