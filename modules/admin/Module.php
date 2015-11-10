<?php

namespace admin;

class Module extends \admin\base\Module
{
    /**
     * @var bool Enables a two-way factor auth system before logging into the admin
     *           panel. If the system is not able to send mails (No configuration or missconfiguration)
     *           then you are not able to login anymore. You should test the mail system before enabling
     *           secureLogin. To test your smtp connection you can use `./vendor/bin/luya health/mailer`
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
        'api-admin-tag' => 'admin\apis\TagController',
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
        ->nodeRoute('Dateimanager', 'folder_open', 'admin-storage-index', 'admin/storage/index')
        ->node('System', 'layers')
            ->group('Zugriff')
                ->itemApi('Benutzer', 'admin-user-index', 'person', 'api-admin-user')
                ->itemApi('Gruppen', 'admin-group-index', 'group', 'api-admin-group')
            ->group('System')
                ->itemApi('Sprachen', 'admin-lang-index', 'language', 'api-admin-lang')
                ->itemApi('Tags', 'admin-tag-index', 'label', 'api-admin-tag')
            ->group('Bilder')
                ->itemApi('Effekte', 'admin-effect-index', 'blur_circular', 'api-admin-effect')
                ->itemApi('Filter', 'admin-filter-index', 'adjust', 'api-admin-filter')
        ->menu();
    }

    public function registerComponents()
    {
        return [
            'adminuser' => [
                'class' => '\admin\components\AdminUser',
            ],
            'adminmenu' => [
                'class' => '\admin\components\AdminMenu',
            ],
            'storage' => [
                'class' => '\admin\components\Storage',
            ],
            'auth' => [
                'class' => '\admin\components\Auth',
            ],
        ];
    }

    public function import(\luya\console\interfaces\ImportController $import)
    {
        return [
            '\\admin\\importers\\AuthImporter',
            '\\admin\\importers\\FilterImporter',
            '\\admin\\importers\\PropertyImporter',
        ];
    }
}
