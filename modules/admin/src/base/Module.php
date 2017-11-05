<?php

namespace luya\admin\base;

use yii\helpers\ArrayHelper;
use luya\base\AdminModuleInterface;

/**
 * The base Admin Module for all administration modules.
 *
 * Each administration module of LUYA must implemented this class. This class provides the ability to
 * store menu data, register translations.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Module extends \luya\base\Module implements AdminModuleInterface
{
    /**
     * @inheritdoc
     */
    public $requiredComponents = ['db'];
    
    /**
     * @var array Dashboard Objects will be retrieved when the admin dashboard is loaded.
     * You can use either easy to use preconfigured objects or provide a custom dashboard widget
     * object class.
     *
     * ```php
     * public $dashboardObjects = [
     *     [
     *         'class' => 'luya\admin\dashboard\BasicDashboardObject',
     *         'template' => '<ul ng-repeat="item in data"><li>{{item.title}}</li></ul>',
     *         'dataApiUrl' => 'admin/api-news-article',
     *         'title' => 'Latest News',
     *     ],
     *     [
     *         // ...
     *     ]
     * ];
     * ```
     *
     * In order to customize the template of a basic dashboard object you can override the  {{luya\admin\dashboard\BasicDashboardObject::$outerTemplate}}:
     *
     * ```php
     * [
     *     'class' => 'luya\admin\dashboard\BasicDashboardObject',
     *     'outerTemplate' => '<div class="wrap-around-template"><h1>{{title}}</h1><small>{{template}}</small></div>',
     *     'template' => '<ul ng-repeat="item in data"><li>{{item.title}}</li></ul>',
     *     'dataApiUrl' => 'admin/api-news-article',
     *     'title' => 'Latest News',
     * ],
     * ```
     *
     * You can also choose from predefined dashboard object which provides wrappers so you don't have to modify the {{luya\admin\dashboard\BasicDashboardObject::$outerTemplate}} string.
     *
     * + {{luya\admin\dashboard\ListDashboardObject}}
     * + {{luya\admin\dashboard\TableDashboardObject}}
     *
     */
    public $dashboardObjects = [];

    /**
     * > implementation discontinued but keep the concept comment for later usage.
     *
     * @var array The config linker property can specific the configuration class for ngRest model where the key
     * is the `api` and the value is the class to the config. An array could look like this:
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
     * ```php
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
     *
     * The above example will override the api-admin-user ngrest config with your project specific config.
     */
    //public $ngrestConfigLinker = [];

    
    /**
     * Returns all Asset files to registered in the administration interfaces.
     *
     * As the adminstration UI is written in angular, the assets must be pre assigned to the adminisration there for the `getAdminAssets()` method exists.
     *
     * ```php
     * public function getAdminAssets()
     * {
     *     return [
     *          'luya\admin\assets\Main',
     *          'luya\admin\assets\Flow',
     *     ];
     * }
     * ```
     *
     * @return array An array with with assets files where the array has no key and the value is the path to the asset class.
     */
    public function getAdminAssets()
    {
        return [];
    }
    
    /**
     * Returns all message identifier for the current module which should be assigned to the javascript admin interface.
     *
     * As the administration UI is written in angular, translations must also be available in different javascript section of the page.
     *
     * The response array of this method returns all messages keys which will be assigned:
     *
     * Example:
     *
     * ```php
     * public function getJsTranslationMessages()
     * {
     *     return ['js_ngrest_rm_page', 'js_ngrest_rm_confirm', 'js_ngrest_error'],
     * }
     * ```
     *
     * Assuming the aboved keys are also part of the translation messages files.
     *
     * @return array An array with values of the message keys based on the Yii translation system.
     */
    public function getJsTranslationMessages()
    {
        return [];
    }

    /**
     * @return array|\luya\admin\components\AdminMenuBuilderInterface
     */
    public function getMenu()
    {
        return false;
    }
    
    /**
     * Extend the permission apis with none menu based items.
     *
     * Example return:
     *
     * ```php
     * return [
     *     ['api' => 'api-cms-moveblock', 'alias' => 'Move blocks'],
     * ];
     * ```
     *
     * @return array An array with an array with keys `api` and `alias`.
     */
    public function extendPermissionApis()
    {
        return [];
    }

    /**
     * Extend the permission route with a none menu route the set permissions.
     *
     * Example return:
     *
     * ```php
     * public function extendPermissionRoutes()
     * {
     *     return [
     *         ['route' => 'cmsadmin/page/create', 'alias' => 'Page Create'],
     *         ['route' => 'cmsadmin/page/update', 'alias' => 'Page Edit'],
     *     ];
     * }
     * ```
     */
    public function extendPermissionRoutes()
    {
        return [];
    }

    /**
     * Get an array with all api routes based on the menu builder.
     *
     * @return array
     */
    public function getAuthApis()
    {
        $menu = $this->getMenu();
        
        if (!$menu) {
            return $this->extendPermissionApis();
        }
        
        return ArrayHelper::merge($this->extendPermissionApis(), $menu->getPermissionApis());
    }

    /**
     * Get an array with all routes based on the menu builder.
     *
     * @return array
     */
    public function getAuthRoutes()
    {
        $menu = $this->getMenu();
         
        if (!$menu) {
            return $this->extendPermissionRoutes();
        }
        
        return ArrayHelper::merge($this->extendPermissionRoutes(), $menu->getPermissionRoutes());
    }
}
