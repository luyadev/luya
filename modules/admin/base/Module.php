<?php

namespace admin\base;

class Module extends \luya\base\Module
{
    public $isAdmin = true;
    
    public $requiredComponents = ['db'];

    private $_menu = [];

    private $_pointers = [];

    private $_permissionApis = [];

    private $_permissionRoutes = [];

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
        ];

        return $this;
    }

    protected function nodeRoute($name, $icon, $template, $route)
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
        ];

        $this->_permissionApis[] = ['api' => $apiEndpoint, 'alias' => $name];

        return $this;
    }

    protected function itemRoute($name, $route, $icon)
    {
        $this->_menu[$this->_pointers['node']]['groups'][$this->_pointers['group']]['items'][] = [
            'alias' => $name,
            'route' => $route,
            'icon' => $icon,
            'permssionApiEndpoint' => null,
            'permissionIsRoute' => true,
            'permissionIsApi' => false,
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

        return \yii\helpers\ArrayHelper::merge($this->extendPermissionApis(), $this->_permissionApis);
    }

    public function getAuthRoutes()
    {
        $this->getMenu();

        return \yii\helpers\ArrayHelper::merge($this->extendPermissionRoutes(), $this->_permissionRoutes);
    }
}
