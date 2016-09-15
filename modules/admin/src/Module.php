<?php

namespace luya\admin;

use Yii;
use luya\web\UrlRule;
use luya\console\interfaces\ImportControllerInterface;
use luya\base\CoreModuleInterface;
use luya\admin\components\AdminLanguage;
use luya\admin\components\AdminUser;
use luya\admin\components\AdminMenu;
use luya\admin\components\StorageContainer;
use luya\admin\components\Auth;

class Module extends \luya\admin\base\Module implements CoreModuleInterface
{
    /**
     * This event gets trigger before some trys to download a file.
     *
     * @var string Event Name
     */
    const EVENT_BEFORE_FILE_DOWNLOAD = 'EVENT_BEFORE_FILE_DOWNLOAD';
    
    /**
     * @var bool Enables a two-way factor auth system before logging into the admin
     * panel. If the system is not able to send mails (No configuration or missconfiguration)
     * then you are not able to login anymore. You should test the mail system before enabling
     * secureLogin. To test your smtp connection you can use `./vendor/bin/luya health/mailer`
     */
    public $secureLogin = false;

    public $tags = [
        'file' => ['class' => 'luya\admin\tags\FileTag'],
    ];
    
    public $apis = [
        'api-admin-logger' => 'luya\admin\apis\LoggerController',
        'api-admin-common' => 'luya\admin\apis\CommonController',
        'api-admin-remote' => 'luya\admin\apis\RemoteController',
        'api-admin-storage' => 'luya\admin\apis\StorageController',
        'api-admin-menu' => 'luya\admin\apis\MenuController',
        'api-admin-timestamp' => 'luya\admin\apis\TimestampController',
        'api-admin-search' => 'luya\admin\apis\SearchController',
        'api-admin-user' => 'luya\admin\apis\UserController', // protected by auth()
        'api-admin-group' => 'luya\admin\apis\GroupController', // protected by auth()
        'api-admin-lang' => 'luya\admin\apis\LangController', // protected by auth()
        'api-admin-effect' => 'luya\admin\apis\EffectController', // protected by auth()
        'api-admin-filter' => 'luya\admin\apis\FilterController', // protected by auth()
        'api-admin-tag' => 'luya\admin\apis\TagController',
    ];

    public $urlRules = [
        ['class' => 'luya\admin\components\UrlRule'],
        ['pattern' => 'file/<id:\d+>/<hash:\w+>/<fileName:(.*?)+>', 'route' => 'admin/file/download', 'position' => UrlRule::POSITION_BEFORE_LUYA],
        ['pattern' => 'admin', 'route' => 'admin/default/index', 'position' => UrlRule::POSITION_BEFORE_LUYA],
        ['pattern' => 'admin/login', 'route' => 'admin/login/index', 'position' => UrlRule::POSITION_BEFORE_LUYA],
    ];

    public $assets = [
        'luya\admin\assets\Main',
        'luya\admin\assets\Flow',
    ];

    public $registerJsTranslation = [
        'js_ngrest_rm_page', 'js_ngrest_rm_confirm', 'js_ngrest_error', 'js_ngrest_rm_update', 'js_ngrest_rm_success', 'js_tag_exists', 'js_tag_success', 'js_admin_reload', 'js_dir_till', 'js_dir_set_date', 'js_dir_table_add_row', 'js_dir_table_add_column', 'js_dir_image_description',
        'js_dir_no_selection', 'js_dir_image_upload_ok', 'js_dir_image_filter_error', 'js_dir_upload_wait', 'js_dir_manager_upload_image_ok', 'js_dir_manager_rm_file_confirm', 'js_dir_manager_rm_file_ok', 'js_zaa_server_proccess',
        'ngrest_select_no_selection',
    ];
    
    public $moduleMenus = [];

    private $_jsTranslations = [];
    
    public function getJsTranslations()
    {
        return $this->_jsTranslations;
    }
    
    public function setJsTranslations(array $translations)
    {
        foreach ($translations as $module => $data) {
            foreach ($data as $key) {
                $this->_jsTranslations[$key] = Yii::t($module, $key, [], Yii::$app->luyaLanguage);
            }
        }
    }
    
    public function getMenu()
    {
        return $this
        ->nodeRoute(Module::t('menu_node_filemanager'), 'folder_open', 'admin-storage-index', 'admin/storage/index')
        ->node(Module::t('menu_node_system'), 'layers')
            ->group(Module::t('menu_group_access'))
                ->itemApi(Module::t('menu_access_item_user'), 'admin-user-index', 'person', 'api-admin-user')
                ->itemApi(Module::t('menu_access_item_group'), 'admin-group-index', 'group', 'api-admin-group')
            ->group(Module::t('menu_group_system'))
                ->itemApi(Module::t('menu_system_item_language'), 'admin-lang-index', 'language', 'api-admin-lang')
                ->itemApi(Module::t('menu_system_item_tags'), 'admin-tag-index', 'label', 'api-admin-tag')
                ->itemApi('Logger', 'admin-logger-index', 'label', 'api-admin-logger')
            ->group(Module::t('menu_group_images'))
                ->itemApi(Module::t('menu_images_item_effects'), 'admin-effect-index', 'blur_circular', 'api-admin-effect')
                ->itemApi(Module::t('menu_images_item_filters'), 'admin-filter-index', 'adjust', 'api-admin-filter')
        ->menu();
    }

    public function registerComponents()
    {
        return [
            'adminLanguage' => [
                'class' => AdminLanguage::className(),
            ],
            'adminuser' => [
                'class' => AdminUser::className(),
            ],
            'adminmenu' => [
                'class' => AdminMenu::className(),
            ],
            'storage' => [
                'class' => StorageContainer::className(),
            ],
            'auth' => [
                'class' => Auth::className(),
            ],
        ];
    }
    
    public $translations = [
        [
            'prefix' => 'admin*',
            'basePath' => '@admin/messages',
            'fileMap' => [
                'admin' => 'admin.php',
            ],
        ],
    ];

    public function import(ImportControllerInterface $import)
    {
        return [
            '\\luya\\admin\\importers\\AuthImporter',
            '\\luya\\admin\\importers\\FilterImporter',
            '\\luya\\admin\\importers\\PropertyImporter',
            '\\luya\\admin\\importers\\StorageImporter',
        ];
    }
    
    public static function t($message, array $params = [])
    {
        return Yii::t('admin', $message, $params, Yii::$app->luyaLanguage);
    }
}
