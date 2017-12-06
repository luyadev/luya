<?php

namespace luya\cms\admin;

use Yii;
use luya\console\interfaces\ImportControllerInterface;
use luya\cms\admin\importers\BlockImporter;
use luya\cms\admin\importers\CmslayoutImporter;
use luya\cms\admin\importers\PropertyConsistencyImporter;
use luya\base\CoreModuleInterface;
use luya\admin\components\AdminMenuBuilder;

/**
 * CMS Admin Module.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Module extends \luya\admin\base\Module implements CoreModuleInterface
{
    /**
     * @var string The version label name of the first version, version alias is running through yii2 messaging system.
     */
    const VERSION_INIT_LABEL = 'Initial';
    
    const ROUTE_PAGE_CREATE = 'cmsadmin/page/create';
    
    const ROUTE_PAGE_UDPATE = 'cmsadmin/page/update';
    
    const ROUTE_PAGE_DELETE = 'cmsadmin/page/delete';
    
    const ROUTE_PAGE_DRAFTS = 'cmsadmin/page/drafts';
    
    const ROUTE_CONFIG = 'cmsadmin/config/index';

    /**
     * @inheritdoc
     */
    public $apis = [
        'api-cms-admin' => 'luya\cms\admin\\apis\\AdminController',
        'api-cms-navitempageblockitem' => 'luya\cms\admin\\apis\\NavItemPageBlockItemController',
        'api-cms-nav' => 'luya\cms\admin\apis\NavController',
        'api-cms-navitem' => 'luya\cms\admin\\apis\\NavItemController',
        'api-cms-menu' => 'luya\cms\admin\apis\MenuController',
        'api-cms-layout' => 'luya\cms\admin\\apis\\LayoutController',
        'api-cms-block' => 'luya\cms\admin\\apis\\BlockController',
        'api-cms-blockgroup' => 'luya\cms\admin\\apis\\BlockgroupController',
        'api-cms-navcontainer' => 'luya\cms\admin\apis\NavContainerController',
        'api-cms-navitemblock' => 'luya\cms\admin\apis\NavItemBlockController',
        'api-cms-redirect' => 'luya\cms\admin\apis\RedirectController',
    ];

    /**
     * @inheritdoc
     */
    public $dashboardObjects = [
        [
            'class' => 'luya\admin\dashboard\ListDashboardObject',
            'template' => '
				<a ng-repeat="item in data" ui-sref="custom.cmsedit({ navId : item.nav_id, templateId: \'cmsadmin/default/index\'})" class="list-group-item list-group-item-action flex-column align-items-start">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1">{{item.title}}</h5>
				      <small>{{item.timestamp_update * 1000 | date:\'short\'}}</small>
				    </div>
				    <small>by {{item.updateUser.firstname}} {{item.updateUser.lastname}}</small>
				</a>
			',
            'dataApiUrl' => 'admin/api-cms-navitem/last-updates',
            'title' => ['cmsadmin', 'cmsadmin_dashboard_lastupdate'],
        ],
    ];
    
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
        return  [
            'luya\cms\admin\assets\Main',
        ];
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
        return [
            'js_added_translation_ok', 'js_added_translation_error', 'js_page_add_exists', 'js_page_property_refresh', 'js_page_confirm_delete', 'js_page_delete_error_cause_redirects', 'js_state_online', 'js_state_offline',
            'js_state_hidden', 'js_state_visible', 'js_state_is_home', 'js_state_is_not_home', 'js_page_item_update_ok', 'js_page_block_update_ok', 'js_page_block_remove_ok', 'js_page_block_visbility_change', 'js_page_block_delete_confirm',
            'js_version_update_success', 'js_version_error_empty_fields', 'js_version_create_success', 'js_version_delete_confirm', 'js_version_delete_confirm_success',
            'view_index_page_success', 'js_config_update_success', 'js_page_update_layout_save_success', 'js_page_create_copy_success', 'view_update_block_tooltip_delete',
            'cmsadmin_settings_trashpage_title', 'cmsadmin_version_remove',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function onLoad()
    {
        self::registerTranslation('cmsadmin*', '@cmsadmin/messages', [
            'cmsadmin' => 'cmsadmin.php',
        ]);
    }
    
    /**
     * @var array Defined blocks to hidde from the cmsadmin. Those blocks are not listed in the Page Content blocks overview. You can override this
     * variable inside your configuration of the cmsadmin.
     *
     * ```php
     *  'modules' => [
     *      'cmsadmin' => [
     *          'class' => 'cmsadmin\Module',
     *          'hiddenBlocks' => [
     *              'cmsadmin\blocks\TextBlock',
     *          ],
     *      ],
     *  ],
     * ```
     *
     * You can define blocks by using the string notation:
     *
     * ```php
     * 'hiddenBlocks' => [
     *     'cmsadmin\blocks\TextBlock',
     *     'cmsadmin\blocks\AudioBlock',
     * ],
     * ```
     *
     * or you can use the object notation with static className method this is more convient as an IDE will auto complet the Input:
     *
     * ```php
     * 'hiddenBlocks' => [
     *     \cmsadmin\blocks\TextBlock::className(),
     *     \cmsadmin\blocks\AudioBlock::className(),
     * ],
     * ```
     */
    public $hiddenBlocks = [];
    
    private $_blockVariation;
    
    /**
     * Set block variations.
     *
     * ```php
     * 'blockVariations' => [
     *     TextBlock::class => [
     *         'variation1' => [
     *             'vars' => ['cssClass' => 'fetti-font-css-class'],
     *             'cfgs' => [], // will be ignore as its empty, so you can also just remove this part.
     *             'extras' => [], // will be ignore as its empty, so you can also just remove this part.
     *         ],
     *     ]
     * ]
     * ```
     *
     * @param array $config
     */
    public function setBlockVariations(array $config)
    {
        $_variations = [];
        foreach ($config as $key => $content) {
            if (is_numeric($key) && is_array($content)) {
                $_variations[key($content)] = array_shift($content);
            } else {
                $_variations[$key] = $content;
            }
        }
        $this->_blockVariation = $_variations;
    }
    
    /**
     * Getter method for blockVarionts.
     *
     * @return mixed[]|array[]
     */
    public function getBlockVariations()
    {
        return $this->_blockVariation;
    }
    
    /**
     * @inheritdoc
     */
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))
            ->nodeRoute('menu_node_cms', 'note_add', 'cmsadmin/default/index', 'luya\cms\models\NavItem')
            ->node('menu_node_cmssettings', 'settings')
                ->group('menu_group_env')
                    ->itemRoute('menu_group_item_env_permission', "cmsadmin/permission/index", 'gavel')
                    ->itemApi('menu_group_item_env_container', 'cmsadmin/navcontainer/index', 'label_outline', 'api-cms-navcontainer')
                    ->itemApi('menu_group_item_env_layouts', 'cmsadmin/layout/index', 'view_quilt', 'api-cms-layout')
                    ->itemRoute('menu_group_item_env_config', 'cmsadmin/config/index', 'build')
                    ->itemApi('menu_group_item_env_redirections', 'cmsadmin/redirect/index', 'compare_arrows', 'api-cms-redirect')
                ->group('menu_group_elements')
                    ->itemApi('menu_group_item_elements_group', 'cmsadmin/blockgroup/index', 'view_module', 'api-cms-blockgroup')
                    ->itemApi('menu_group_item_elements_blocks', 'cmsadmin/block/index', 'format_align_left', 'api-cms-block');
    }

    /**
     * @inheritdoc
     */
    public function extendPermissionApis()
    {
        return [
            ['api' => 'api-cms-navitempageblockitem', 'alias' => static::t('module_permission_page_blocks')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function extendPermissionRoutes()
    {
        return [
            ['route' => self::ROUTE_PAGE_CREATE, 'alias' => static::t('module_permission_add_new_page')],
            ['route' => self::ROUTE_PAGE_UDPATE, 'alias' => static::t('module_permission_update_pages')],
            ['route' => self::ROUTE_PAGE_DELETE, 'alias' => static::t('module_permission_delete_pages')],
            ['route' => self::ROUTE_PAGE_DRAFTS, 'alias' => static::t('module_permission_edit_drafts')],
            ['route' => self::ROUTE_CONFIG, 'alias' => static::t('module_permission_update_config')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function import(ImportControllerInterface $importer)
    {
        return [
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
     * @return string
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('cmsadmin', $message, $params);
    }
    
    private static $_authorUserId = 0;
    
    /**
     * Setter method for author user ID in order ensure phpunit tests.
     *
     * @param integer $userId
     */
    public static function setAuthorUserId($userId)
    {
        self::$_authorUserId = $userId;
    }
    
    /**
     * Get the user id of the logged in user in web appliation context.
     *
     * @return integer
     */
    public static function getAuthorUserId()
    {
        return (Yii::$app instanceof \luya\web\Application) ? Yii::$app->adminuser->getId() : self::$_authorUserId;
    }
}
