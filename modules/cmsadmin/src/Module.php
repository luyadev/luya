<?php

namespace cmsadmin;

use Yii;

class Module extends \admin\base\Module
{
    public $isCoreModule = true;

    public $apis = [
        'api-cms-admin' => 'cmsadmin\\apis\\AdminController',
        'api-cms-navitempageblockitem' => 'cmsadmin\\apis\\NavItemPageBlockItemController',
        'api-cms-nav' => 'cmsadmin\apis\NavController',
        'api-cms-navitem' => 'cmsadmin\\apis\\NavItemController',
        'api-cms-menu' => 'cmsadmin\apis\MenuController', // should put into api-cms-admin
        //'api-cms-navitempage' => 'cmsadmin\apis\NavItemPageController', // should put into api-cms-admin
        //'api-cms-navitemmodule' => 'cmsadmin\\apis\\NavItemModuleController',
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
        'js_state_hidden', 'js_state_visible', 'js_state_is_home', 'js_state_is_not_home', 'js_page_item_update_ok', 'js_page_block_update_ok', 'js_page_block_remove_ok', 'js_page_block_visbility_change'
    ];

    public function getMenu()
    {
        return $this
            ->nodeRoute(Module::t('menu_node_cms'), 'content_copy', 'cmsadmin-default-index', 'cmsadmin/default/index', 'cmsadmin\models\NavItem')
            ->node(Module::t('menu_node_cmssettings'), 'settings')
                ->group(Module::t('menu_group_env'))
                    ->itemApi(Module::t('menu_group_item_env_container'), 'cmsadmin-navcontainer-index', 'label_outline', 'api-cms-navcontainer')
                    ->itemApi(Module::t('menu_group_item_env_layouts'), 'cmsadmin-layout-index', 'view_quilt', 'api-cms-layout')
                ->group(Module::t('menu_group_elements'))
                    ->itemApi(Module::t('menu_group_item_elements_group'), 'cmsadmin-blockgroup-index', 'view_module', 'api-cms-blockgroup')
                    ->itemApi(Module::t('menu_group_item_elements_blocks'), 'cmsadmin-block-index', 'format_align_left', 'api-cms-block')
            ->menu();
    }

    public function extendPermissionApis()
    {
        return [
            ['api' => 'api-cms-navitempageblockitem', 'alias' => 'Blöcke einfügen und verschieben'],
        ];
    }

    public function extendPermissionRoutes()
    {
        return [
            ['route' => 'cmsadmin/page/create', 'alias' => 'Seiten Erstellen'],
            ['route' => 'cmsadmin/page/update', 'alias' => 'Seiten Bearbeiten'],
            ['route' => 'cmsadmin/page/drafts', 'alias' => 'Vorlagen Bearbeiten'],
        ];
    }

    /**
     * @todo do not only import, also update changes in the template
     * @todo how do we send back values into the executblae controller for output purposes?
     */
    public function import(\luya\console\interfaces\ImportController $import)
    {
        return [
            '\\cmsadmin\\importers\\BlockImporter',
            '\\cmsadmin\\importers\\CmslayoutImporter',
            '\\cmsadmin\\importers\\PropertyConsistencyImporter',
        ];
    }
    
    public $translations = [
        [
            'prefix' => 'cmsadmin*',
            'basePath' => '@cmsadmin/messages',
            'fileMap' => [
                'cmsadmin' => 'cmsadmin.php',
            ],
        ],
    ];
    
    public static function t($message, array $params = [])
    {
        return Yii::t('cmsadmin', $message, $params, Yii::$app->luyaLanguage);
    }
}
