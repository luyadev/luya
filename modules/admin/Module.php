<?php

namespace admin;

class Module extends \admin\base\Module
{
    /**
     * @var boolean Enables a two-way factor auth system before logging into the admin
     * panel. If the system is not able to send mails (No configuration or missconfiguration)
     * then you are not able to login anymore. You should test the mail system before enabling
     * secureLogin.
     */
    public $secureLogin = false;
    
    public $isCoreModule = true;

    public $apis = [
        'api-admin-remote' => 'admin\apis\RemoteController',
        'api-admin-defaults' => 'admin\apis\DefaultsController',
        'api-admin-storage' => 'admin\apis\StorageController',
        'api-admin-menu' => 'admin\apis\MenuController',
        'api-admin-timestamp' => 'admin\apis\TimestampController',
        'api-admin-search' => 'admin\apis\SearchController',
        'api-admin-user' => 'admin\apis\UserController', // protected by auth()
        'api-admin-group' => 'admin\apis\GroupController', // protected by auth()
        'api-admin-lang' => 'admin\apis\LangController', // protected by auth()
        'api-admin-effect' => 'admin\apis\EffectController', // protected by auth()
        'api-admin-filter' => 'admin\apis\FilterController', // protected by auth()
    ];

    public $urlRules = [
        ['class' => 'admin\components\UrlRule'],
    ];

    public $assets = [
        'admin\assets\Main',
    ];

    public $moduleMenus = [];

    public function getMenu()
    {
        return $this
        ->nodeRoute('Dateimanager', 'mdi-file-folder-open', 'admin-storage-index', 'admin/storage/index')
        ->node('System', 'mdi-maps-layers')
            ->group('Zugriff')
                ->itemApi('Benutzer', 'admin-user-index', 'mdi-social-person', 'api-admin-user')
                ->itemApi('Gruppen', 'admin-group-index', 'mdi-action-account-child', 'api-admin-group')
            ->group('System')
                ->itemApi('Sprachen', 'admin-lang-index', 'mdi-action-language', 'api-admin-lang')
            ->group('Bilder')
                ->itemApi('Effekte', 'admin-effect-index', 'mdi-image-blur-linear', 'api-admin-effect')
                ->itemApi('Filter', 'admin-filter-index', 'mdi-image-adjust', 'api-admin-filter')
        ->menu();
    }

    public function registerComponents()
    {
        return [
            'adminuser' => [
                'class' => '\admin\components\AdminUser',
            ],
            'menu' => [
                'class' => '\admin\components\Menu',
            ],
            'storage' => [
                'class' => '\admin\components\Storage',
            ],
            'auth' => [
                'class' => '\admin\components\Auth',
            ],
        ];
    }

    public function import(\luya\commands\ImportController $import)
    {
        return [
            '\\admin\\importers\\AuthImporter',
            '\\admin\\importers\\FilterImporter',
            '\\admin\\importers\\PropertyImporter',
        ];
    }
}
