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
use luya\admin\components\AdminMenuBuilder;
use luya\admin\importers\AuthImporter;
use luya\admin\importers\FilterImporter;
use luya\admin\importers\PropertyImporter;
use luya\admin\importers\StorageImporter;

/**
 * Admin Module.
 *
 * The Admin Module provides options to configure. In order to add the Admin module to your config use:
 *
 * ```php
 * 'modules' => [
 *     // ...
 *     'admin' => [
 *         'class' => 'luya\admin\Module',
 *         'secureLogin' => true,
 *     ]
 * ]
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Module extends \luya\admin\base\Module implements CoreModuleInterface
{
    /**
     * This event gets trigger before some trys to download a file.
     *
     * @var string Event Name
     */
    const EVENT_BEFORE_FILE_DOWNLOAD = 'EVENT_BEFORE_FILE_DOWNLOAD';
    
    /**
     * @var array Available translation messages.
     */
    public $uiLanguageDropdown = [
        'en' => 'English',
        'de' => 'Deutsch',
        'ru' => 'Pусский',
        'es' => 'Español',
        'fr' => 'Français',
        'ua' => 'Українська',
        'it' => 'Italiano',
        'el' => 'Ελληνικά',
        'vi' => 'Việt Nam',
    ];
    
    /**
     * @var boolean Enables a two-way factor auth system before logging into the admin
     * panel. If the system is not able to send mails (No configuration or missconfiguration)
     * then you are not able to login anymore. You should test the mail system before enabling
     * secureLogin. To test your smtp connection you can use `./vendor/bin/luya health/mailer`
     */
    public $secureLogin = false;
    
    /**
     * @var integer The number of rows which should be transferd for each request.
     */
    public $proxyRowsPerRequest = 25;

    /**
     * @var array A configuration array with all tags shipped by default with the admin module.
     */
    public $tags = [
        'file' => ['class' => 'luya\admin\tags\FileTag'],
    ];
    
    /**
     * @var array The available api endpoints within the admin module.
     */
    public $apis = [
        'api-admin-logger' => 'luya\admin\apis\LoggerController',
        'api-admin-common' => 'luya\admin\apis\CommonController',
        'api-admin-remote' => 'luya\admin\apis\RemoteController',
        'api-admin-storage' => 'luya\admin\apis\StorageController',
        'api-admin-menu' => 'luya\admin\apis\MenuController',
        'api-admin-timestamp' => 'luya\admin\apis\TimestampController',
        'api-admin-search' => 'luya\admin\apis\SearchController',
        'api-admin-user' => 'luya\admin\apis\UserController',
        'api-admin-group' => 'luya\admin\apis\GroupController',
        'api-admin-lang' => 'luya\admin\apis\LangController',
        'api-admin-effect' => 'luya\admin\apis\EffectController',
        'api-admin-filter' => 'luya\admin\apis\FilterController',
        'api-admin-tag' => 'luya\admin\apis\TagController',
        'api-admin-proxymachine' => 'luya\admin\apis\ProxyMachineController',
        'api-admin-proxybuild' => 'luya\admin\apis\ProxyBuildController',
        'api-admin-proxy' => 'luya\admin\apis\ProxyController',
    ];

    /**
     * @var array Url rules used by the administration application.
     */
    public $urlRules = [
        ['class' => 'luya\admin\components\UrlRule'],
        ['pattern' => 'file/<id:\d+>/<hash:\w+>/<fileName:(.*?)+>', 'route' => 'admin/file/download'],
        ['pattern' => 'admin', 'route' => 'admin/default/index'],
        ['pattern' => 'admin/login', 'route' => 'admin/login/index'],
    ];

    /**
     * @var array This property is used by the {{luya\web\Bootstrap::run}} method in order to set the collected asset files to assign.
     */
    public $assets = [];
    
    /**
     * @var array This property is used by the {{luya\web\Bootstrap::run}} method in order to set the collected menu items forom all admin modules and build the menu.
     */
    public $moduleMenus = [];
    
    /**
     * @var array Registering translation files for the admin module.
     */
    public $translations = [
        [
            'prefix' => 'admin*',
            'basePath' => '@admin/messages',
            'fileMap' => [
                'admin' => 'admin.php',
            ],
        ],
    ];
    
    /**
     * @var integer The expiration timeout for a proxy build in seconds. Default value is 1800 seconds which is 30 minutes.
     */
    public $proxyExpirationTime = 1800;
    
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
        return [
            'luya\admin\assets\Main',
            'luya\admin\assets\AngularI18n',
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
            'js_ngrest_rm_page', 'js_ngrest_rm_confirm', 'js_ngrest_error', 'js_ngrest_rm_update', 'js_ngrest_rm_success', 'js_tag_exists', 'js_tag_success', 'js_admin_reload', 'js_dir_till', 'js_dir_set_date', 'js_dir_table_add_row', 'js_dir_table_add_column', 'js_dir_image_description',
            'js_dir_no_selection', 'js_dir_image_upload_ok', 'js_dir_image_filter_error', 'js_dir_upload_wait', 'js_dir_manager_upload_image_ok', 'js_dir_manager_rm_file_confirm', 'js_dir_manager_rm_file_ok', 'js_zaa_server_proccess',
            'ngrest_select_no_selection', 'js_ngrest_toggler_success', 'js_filemanager_count_files_overlay', 'js_link_set_value', 'js_link_change_value',
        ];
    }
    
    private $_jsTranslations = [];
    
    /**
     * Getter method for the js translations array.
     *
     * @return array An array with all translated messages to store in the and access from the admin js scripts.
     */
    public function getJsTranslations()
    {
        $translations = [];
        foreach ($this->_jsTranslations as $module => $data) {
            foreach ($data as $key) {
                $translations[$key] = Yii::t($module, $key, [], Yii::$app->luyaLanguage);
            }
        }
        return $translations;
    }
    
    /**
     * Setter for js translations files.
     *
     * This setter method is used by the {{luya\web\Bootstrap::run}} to assign all js transaltion files from the admin modules.
     *
     * @param array $translations
     */
    public function setJsTranslations(array $translations)
    {
        $this->_jsTranslations = $translations;
    }
    
    /**
     * Get the admin module interface menu.
     *
     * @see \luya\admin\base\Module::getMenu()
     * @return \luya\admin\components\AdminMenuBuilderInterface Get the menu builder object.
     */
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))
            ->nodeRoute('menu_node_filemanager', 'folder_open', 'admin/storage/index', 'admin/storage/index')
            ->node('menu_node_system', 'layers')
                ->group('menu_group_access')
                    ->itemApi('menu_access_item_user', 'admin/user/index', 'person', 'api-admin-user')
                    ->itemApi('menu_access_item_group', 'admin/group/index', 'group', 'api-admin-group')
                ->group('menu_group_system')
                    ->itemApi('menu_system_item_language', 'admin/lang/index', 'language', 'api-admin-lang')
                    ->itemApi('menu_system_item_tags', 'admin/tag/index', 'label', 'api-admin-tag')
                    ->itemApi('menu_system_logger', 'admin/logger/index', 'label', 'api-admin-logger')
                ->group('menu_group_images')
                    ->itemApi('menu_images_item_effects', 'admin/effect/index', 'blur_circular', 'api-admin-effect')
                    ->itemApi('menu_images_item_filters', 'admin/filter/index', 'adjust', 'api-admin-filter')
                ->group('LCP')
                    ->itemApi('Machines', 'admin/proxy-machine/index', 'label', 'api-admin-proxymachine')
                    ->itemApi('Builds', 'admin/proxy-build/index', 'label', 'api-admin-proxybuild');
    }

    /**
     * Registering applicat components on application bootstraping proccess.
     *
     * @return array An array where the key is the application component name and value the configuration.
     */
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

    /**
     * Setup the admin importer classes.
     *
     * @param \uya\console\interfaces\ImportControllerInterface $import The import controller interface.
     * @return array An array with all importer classes.
     */
    public function import(ImportControllerInterface $import)
    {
        return [
            AuthImporter::class,
            FilterImporter::class,
            PropertyImporter::class,
            StorageImporter::class,
        ];
    }
    
    /**
     * Admin Module translation helper.
     *
     * @param string $message The message key to translation
     * @param array $params Optional parameters to pass to the translation.
     * @return string The translated message.
     */
    public static function t($message, array $params = [])
    {
        return Yii::t('admin', $message, $params, Yii::$app->luyaLanguage);
    }
}
