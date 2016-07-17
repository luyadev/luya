<?php

namespace cmsadmin;

use Yii;
use luya\console\interfaces\ImportControllerInterface;
use cmsadmin\importers\BlockGroupImporter;
use cmsadmin\importers\BlockImporter;
use cmsadmin\importers\CmslayoutImporter;
use cmsadmin\importers\PropertyConsistencyImporter;

class Module extends \admin\base\Module
{
    /**
     * @var string The version label name of the first version, version alias is running through yii2 messaging system.
     */
    const VERSION_INIT_LABEL = 'Initial';
    
    public $isCoreModule = true;

    public $apis = [
        'api-cms-admin' => 'cmsadmin\\apis\\AdminController',
        'api-cms-navitempageblockitem' => 'cmsadmin\\apis\\NavItemPageBlockItemController',
        'api-cms-nav' => 'cmsadmin\apis\NavController',
        'api-cms-navitem' => 'cmsadmin\\apis\\NavItemController',
        'api-cms-menu' => 'cmsadmin\apis\MenuController', // should put into api-cms-admin
        'api-cms-layout' => 'cmsadmin\\apis\\LayoutController',
        'api-cms-block' => 'cmsadmin\\apis\\BlockController',
        'api-cms-blockgroup' => 'cmsadmin\\apis\\BlockgroupController',
        'api-cms-navcontainer' => 'cmsadmin\apis\NavContainerController',
        'api-cms-navitemblock' => 'cmsadmin\apis\NavItemBlockController',
    ];

    public $assets = [
        'cmsadmin\assets\Main',
    ];
    
    public $registerJsTranslation = [
        'js_added_translation_ok', 'js_added_translation_error', 'js_page_add_exists', 'js_page_property_refresh', 'js_page_confirm_delete', 'js_page_delete_error_cause_redirects', 'js_state_online', 'js_state_offline',
        'js_state_hidden', 'js_state_visible', 'js_state_is_home', 'js_state_is_not_home', 'js_page_item_update_ok', 'js_page_block_update_ok', 'js_page_block_remove_ok', 'js_page_block_visbility_change', 'js_page_block_delete_confirm',
        'js_version_update_success', 'js_version_error_empty_fields', 'js_version_create_success', 'js_version_delete_confirm', 'js_version_delete_confirm_success'
    ];

    public $translations = [
        [
            'prefix' => 'cmsadmin*',
            'basePath' => '@cmsadmin/messages',
            'fileMap' => [
                'cmsadmin' => 'cmsadmin.php',
            ],
        ],
    ];
    
    public function getMenu()
    {
        return $this
            ->nodeRoute(static::t('menu_node_cms'), 'content_copy', 'cmsadmin-default-index', 'cmsadmin/default/index', 'cmsadmin\models\NavItem')
            ->node(static::t('menu_node_cmssettings'), 'settings')
                ->group(static::t('menu_group_env'))
                    ->itemRoute("Zugriffs Berechtigungen", "cmsadmin/permission/index", 'gavel')
                    ->itemApi(static::t('menu_group_item_env_container'), 'cmsadmin-navcontainer-index', 'label_outline', 'api-cms-navcontainer')
                    ->itemApi(static::t('menu_group_item_env_layouts'), 'cmsadmin-layout-index', 'view_quilt', 'api-cms-layout')
                ->group(static::t('menu_group_elements'))
                    ->itemApi(static::t('menu_group_item_elements_group'), 'cmsadmin-blockgroup-index', 'view_module', 'api-cms-blockgroup')
                    ->itemApi(static::t('menu_group_item_elements_blocks'), 'cmsadmin-block-index', 'format_align_left', 'api-cms-block')
            ->menu();
    }

    public function extendPermissionApis()
    {
        return [
            ['api' => 'api-cms-navitempageblockitem', 'alias' => static::t('module_permission_page_blocks')],
        ];
    }

    public function extendPermissionRoutes()
    {
        return [
            ['route' => 'cmsadmin/page/create', 'alias' => static::t('module_permission_add_new_page')],
            ['route' => 'cmsadmin/page/update', 'alias' => static::t('module_permission_update_pages')],
            ['route' => 'cmsadmin/page/drafts', 'alias' => static::t('module_permission_edit_drafts')],
        ];
    }

    /**
     * 
     * {@inheritDoc}
     * @see \luya\base\Module::import()
     */
    public function import(ImportControllerInterface $import)
    {
        return [
            BlockGroupImporter::className(),
            BlockImporter::className(),
            CmslayoutImporter::className(),
            PropertyConsistencyImporter::className(),
        ];
    }
    
    /**
     * Translations for CMS Module.
     * 
     * @param unknown $message
     * @param array $params
     */
    public static function t($message, array $params = [])
    {
        return Yii::t('cmsadmin', $message, $params, Yii::$app->luyaLanguage);
    }
    
    /**
     * Get the user id of the logged in user in web appliation context.
     * 
     * @todo add isGuest check
     * @return nummeric|0
     */
    public static function getAuthorUserId()
    {
        return (Yii::$app instanceof \luya\web\Application) ? Yii::$app->adminuser->getId() : 0;
    }
}
