<?php

namespace luya\admin\components;

use luya\base\AdminModuleInterface;
use yii\base\BaseObject;

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
 *         ->nodeRoute('menu_node_filemanager', 'folder_open', 'admin/storage/index')
 *         ->node('menu_node_system', 'layers')
 *             ->group('menu_group_access')
 *                 ->itemApi('menu_access_item_user', 'admin/user/index', 'person', 'api-admin-user')
 *                 ->itemApi('menu_access_item_group', 'admin/group/index', 'group', 'api-admin-group')
 *             ->group('menu_group_system')
 *                 ->itemApi('menu_system_item_language', 'admin/lang/index', 'language', 'api-admin-lang')
 *                 ->itemApi('menu_system_item_tags', 'admin/tag/index', 'label', 'api-admin-tag')
 *                 ->itemApi('menu_system_logger', 'admin/logger/index', 'label', 'api-admin-logger')
 *             ->group('menu_group_images')
 *                 ->itemApi('menu_images_item_effects', 'admin/effect/index', 'blur_circular', 'api-admin-effect')
 *                 ->itemApi('menu_images_item_filters', 'admin/filter/index', 'adjust', 'api-admin-filter');
 * }
 * ```
 *
 * @since 1.0.0
 * @author Basil Suter <basil@nadar.io>
 */
class AdminMenuBuilder extends BaseObject implements AdminMenuBuilderInterface
{
    private static $index = 0;
    
    private $_menu = [];
    
    private $_pointers = [];
    
    /**
     * @var array The available options for itemApi and itemRoute.
     */
    protected static $options = ['hiddenInMenu'];
    
    /**
     * @var \luya\base\AdminModuleInterface The context on what the menu is running.
     */
    protected $moduleContext;
    
    
    
    
    
    /**
     * @param \luya\base\AdminModuleInterface $module
     * @param array $config
     */
    public function __construct(AdminModuleInterface $module, array $config = [])
    {
        $this->moduleContext = $module;
        parent::__construct($config);
    }
    
    /**
     * @var array List of all permission APIs.
     */
    private $_permissionApis = [];
    
    public function getPermissionApis()
    {
        return $this->_permissionApis;
    }
    
    /**
     * @var array List of all permission Routes.
     */
    private $_permissionRoutes = [];
    
    public function getPermissionRoutes()
    {
        return $this->_permissionRoutes;
    }
    
    /**
     * The node is the menu entry in the TOP navigation of the luya administration interface.
     *
     * @param string $name The name of the node, all names will process trough the `Yii::t` function with its module name as prefix.
     * @param string $icon The icon name based on the google icons font see https://design.google.com/icons/.
     * @param bool $template Whether to use a custom template or not.
     * @return \luya\admin\components\AdminMenuBuilder
     */
    public function node($name, $icon, $template = false)
    {
        $this->_pointers['node'] = self::$index;
        $this->_menu[self::$index] = [
            'id' => self::$index,
            'moduleId' => $this->moduleContext->id,
            'template' => $template,
            'routing' => $template ? 'custom' : 'default',
            'alias' => $name,
            'icon' => $icon,
            'permissionRoute' => false,
            'permissionIsRoute' => false,
            'searchModelClass' => false,
        ];
    
        self::$index++;
        return $this;
    }
    
    /**
     * A node which is a custom route to open, nodes are the the top menu of the luya administration interfaces.
     *
     * @param string $name The name of the node, all names will process trough the `Yii::t` function with its module name as prefix.
     * @param string $icon The icon name based on the google icons font see https://design.google.com/icons/.
     * @param string $route The route to the template which is going to be render by angular, example `cmsadmin/default/index`.
     * @param string $searchModelClass The path to the model to search inside the admin global search, must implement the {{luya\admin\base\GenericSearchInterface}}.
     * @return \luya\admin\components\AdminMenuBuilder
     */
    public function nodeRoute($name, $icon, $route, $searchModelClass = null)
    {
        $this->_pointers['node'] = self::$index;
        $this->_menu[self::$index] = [
            'id' => self::$index,
            'moduleId' => $this->moduleContext->id,
            'template' => $route, // as the template is equal to the route of the node which is loaded
            'routing' => 'custom',
            'alias' => $name,
            'icon' => $icon,
            'permissionRoute' => $route,
            'permissionIsRoute' => true,
            'searchModelClass' => $searchModelClass,
        ];
    
        $this->_permissionRoutes[] = ['route' => $route, 'alias' => $name];
    
        self::$index++;
        return $this;
    }
    
    /**
     * Add a group, all items (api or route) must be child items of a group. The group is the title in the left menu of the admin interface.
     *
     * @param string $name The name of the group.
     * @return \luya\admin\components\AdminMenuBuilder
     */
    public function group($name)
    {
        $this->_pointers['group'] = $name;
        $this->_menu[$this->_pointers['node']]['groups'][$name] = ['name' => $name, 'items' => []];
    
        return $this;
    }
    
    /**
     * Add an item to a group. API items are based on the ngrest crud concept.
     *
     * @param string $name The name of the Api (displayed as menu point in the left navigation), all names run through the `Yii::t()` method prefixed with the module id.
     * @param string $route The api route to the ngrest controller `cmsadmin/navcontainer/index`.
     * @param string $icon The icon name based on the google icons font see https://design.google.com/icons/.
     * @param string $apiEndpoint The api endpoint defined in the NgRestModel::ngRestApiEndpoint `api-cms-navcontainer`.
     * @param array $options An array with options you can provided and read inside the admin menu component. See {{\luya\admin\components\AdminMenuBuilder::verifyOptions}} for detail list and informations.
     * @return \luya\admin\components\AdminMenuBuilder
     */
    public function itemApi($name, $route, $icon, $apiEndpoint, array $options = [])
    {
        $this->_menu[$this->_pointers['node']]['groups'][$this->_pointers['group']]['items'][] = [
            'alias' => $name,
            'route' => $route,
            'icon' => $icon,
            'permssionApiEndpoint' => $apiEndpoint,
            'permissionIsRoute' => false,
            'permissionIsApi' => true,
            'searchModelClass' => false,
            'options' => $this->verifyOptions($options),
        ];
    
        $this->_permissionApis[] = ['api' => $apiEndpoint, 'alias' => $name];
    
        return $this;
    }
    
    /**
     * Add an item to a group. Route items opens a angular view.
     *
     * @param string $name The name of the Api (displayed as menu point in the left navigation), all names run through the `Yii::t()` method prefixed with the module id.
     * @param string $route The route to the template `cmsadmin/permission/index`.
     * @param string $icon The icon name based on the google icons font see https://design.google.com/icons/.
     * @param string $searchModelClass The search model must implement the {{luya\admin\base\GenericSearchInterface}}.
     * @param array $options An array with options you can provided and read inside the admin menu component. See {{\luya\admin\components\AdminMenuBuilder::verifyOptions}} for detail list and informations.
     * @return \luya\admin\components\AdminMenuBuilder
     */
    public function itemRoute($name, $route, $icon, $searchModelClass = null, array $options = [])
    {
        $this->_menu[$this->_pointers['node']]['groups'][$this->_pointers['group']]['items'][] = [
            'alias' => $name,
            'route' => $route,
            'icon' => $icon,
            'permssionApiEndpoint' => null,
            'permissionIsRoute' => true,
            'permissionIsApi' => false,
            'searchModelClass' => $searchModelClass,
            'options' => $this->verifyOptions($options),
        ];
    
        $this->_permissionRoutes[] = ['route' => $route, 'alias' => $name];
    
        return $this;
    }
    
    /**
     * Verify the additional options of an itemRoute or itemApi item.
     *
     * The following options are currently supported
     *
     * - hiddenInMenu: If set to true the item will be hidden in the left menu, this is usefull when creating ngrest crud's for crud-realtion views.
     *
     * @param array $options The options to verify
     * @return array The verified allowed options.
     */
    protected function verifyOptions(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (!in_array($key, static::$options)) {
                unset($options[$key]);
            }
        }
        
        return $options;
    }
    
    /**
     * @inheritdoc
     */
    public function menu()
    {
        return $this->_menu;
    }
    
    /**
     * Helper method to get then value of an options inside an item.
     *
     * @param array $item The item where the option key persists.
     * @param string $optionName The name of the option to get.
     * @param mixed $defaultValue The default value if the option is not available for this item.
     * @return mixed
     */
    public static function getOptionValue(array $item, $optionName, $defaultValue = false)
    {
        if (!isset($item['options'])) {
            return $defaultValue;
        }
        
        return (isset($item['options'][$optionName])) ? $item['options'][$optionName] : $defaultValue;
    }
}
