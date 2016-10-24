<?php

namespace luya\admin\components;

use yii\base\Object;
use luya\base\AdminModuleInterface;

/**
 * Builder class for the Administration Menu/Navigation.
 * 
 * This class is used to build the admin menu/navigation for all admin modules and is called in the `getMenu()` method of each
 * admin module class.
 * 
 * Example of how to use the AdminMenuBuilder class inside the `getMenu()` method of an Admin Module:
 * 
 * ```php
 * public function getMenu()
 * {
 *     return (new AdminMenuBuilder($this))
 *         ->nodeRoute('menu_node_filemanager', 'folder_open', 'admin-storage-index', 'admin/storage/index')
 *         ->node('menu_node_system', 'layers')
 *             ->group('menu_group_access')
 *                 ->itemApi('menu_access_item_user', 'admin-user-index', 'person', 'api-admin-user')
 *                 ->itemApi('menu_access_item_group', 'admin-group-index', 'group', 'api-admin-group')
 *             ->group('menu_group_system')
 *                 ->itemApi('menu_system_item_language', 'admin-lang-index', 'language', 'api-admin-lang')
 *                 ->itemApi('menu_system_item_tags', 'admin-tag-index', 'label', 'api-admin-tag')
 *                 ->itemApi('menu_system_logger', 'admin-logger-index', 'label', 'api-admin-logger')
 *             ->group('menu_group_images')
 *                 ->itemApi('menu_images_item_effects', 'admin-effect-index', 'blur_circular', 'api-admin-effect')
 *                 ->itemApi('menu_images_item_filters', 'admin-filter-index', 'adjust', 'api-admin-filter');
 * }
 * ```  
 * 
 * @since 1.0.0-RC2
 * @author Basil Suter <basil@nadar.io>
 */
class AdminMenuBuilder extends Object implements AdminMenuBuilderInterface
{
    private $_menu = [];
    
    private $_pointers = [];
    
    public $permissionApis = [];
    
    public $permissionRoutes = [];
    
    protected $moduleContext = null;
    
    /**
     * @param \luya\base\AdminModuleInterface $module
     * @param array $config
     */
    public function __construct(AdminModuleInterface $module, array $config = [])
    {
        $this->moduleContext = $module;
        parent::__construct($config);
    }
    
    public function node($name, $icon, $template = false)
    {
        $this->_pointers['node'] = $name;
        $this->_menu[$name] = [
            'moduleId' => $this->moduleContext->id,
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
    
    public function nodeRoute($name, $icon, $template, $route, $searchModelClass = null)
    {
        $this->_pointers['node'] = $name;
        $this->_menu[$name] = [
            'moduleId' => $this->moduleContext->id,
            'template' => $template,
            'routing' => $template ? 'custom' : 'default',
            'alias' => $name,
            'icon' => $icon,
            'permissionRoute' => $route,
            'permissionIsRoute' => true,
            'searchModelClass' => $searchModelClass,
        ];
    
        $this->permissionRoutes[] = ['route' => $route, 'alias' => $name];
    
        return $this;
    }
    
    public function group($name)
    {
        $this->_pointers['group'] = $name;
        $this->_menu[$this->_pointers['node']]['groups'][$name] = ['name' => $name, 'items' => []];
    
        return $this;
    }
    
    public function itemApi($name, $route, $icon, $apiEndpoint)
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
    
        $this->permissionApis[] = ['api' => $apiEndpoint, 'alias' => $name];
    
        return $this;
    }
    
    public function itemRoute($name, $route, $icon, $searchModelClass = null)
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
    
        $this->permissionRoutes[] = ['route' => $route, 'alias' => $name];
    
        return $this;
    }
    
    /**
     * {@inheritDoc}
     * @see \luya\admin\components\AdminMenuBuilderInterface::menu()
     */
    public function menu()
    {
        return $this->_menu;
    }
}