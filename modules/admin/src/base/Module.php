<?php

namespace luya\admin\base;

use yii\helpers\ArrayHelper;
use luya\base\AdminModuleInterface;

/**
 * Admin-Module class.
 *
 * @todo move node(), nodeRoute(), group(), itemApi(), itemRoute() into a seperate class.
 *
 * @author nadar
 */
class Module extends \luya\base\Module implements AdminModuleInterface
{
    public $requiredComponents = ['db'];

    /**
     * @var array The config linker property can specific the configuration class for ngRest model where the key
     *            is the `api` and the value is the class to the config. An array could look like this:
     *
     * ```php
     * [
     *     'api-admin-user' => \path\to\Config::className(),
     *     'api-admin-group' => '\\path\\to\\config\\GroupConfig',
     * ]
     * ```
     *
     * The ngrestConfigLinker property is build to add the ability to override the base ngrest config inside
     * a project via the module configuration inside your prep/prod config. Example for override a default ngrest
     * config inside a project config:
     *
     * ```
     * return [
     *     // ...
     *     'modules' => [
     *         'admin' => [
     *             'class' => 'admin\Module',
     *             'ngrestConfigLinkter' => [
     *                 'api-admin-user' => \app\configs\ngrest\User::className(),
     *             ],
     *         ]
     *     ]
     * ];
     * ```
     * The above example will override the api-admin-user ngrest config with your project specific config.
     */
    public $ngrestConfigLinker = [];

    private $_menu = [];

    private $_pointers = [];

    private $_permissionApis = [];

    private $_permissionRoutes = [];

    /**
     * @var array Each module can have assets, all module controllers will register those assets in the view.. Valid class name to the asset e.g.
     *
     * ```php
     * public $assets = ['\app\assets\TestAsset'];
     * ```
     */
    public $assets = [];
    
    /**
     *
     * @var array Register translations from admin modules, to make them available in javascript files trough
     * the `i18n['yourTranslation']` object.
     */
    public $registerJsTranslation = [];
    
    /**
     * Checks if a config exist in the linked property based on the provided `$apiEndpoint`.
     *
     * @param string $apiEndpoint The identifier of an apiEndpoint. ApiEndpoints are listed in the module class.
     *
     * @return bool|string If apiEndpoint exists in the linker property returns className, otherwhise false.
     */
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
