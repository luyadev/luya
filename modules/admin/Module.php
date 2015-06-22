<?php

namespace admin;

class Module extends \admin\base\Module
{
    public static $apis = [
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

    public static $urlRules = [
        ['class' => 'admin\components\UrlRule'],
    ];

    public $assets = [
        'admin\assets\Main',
    ];

    public $storageFolder = '@webroot/storage';

    public $storageFolderHttp = 'storage';

    public function init()
    {
        parent::init();
        
        foreach (\luya\helpers\Param::get('apis') as $item) {
            $this->controllerMap[$item['alias']] = $item['class'];
        }
    }

    /**
     * @todo remove this method!
     */
    public static function getAdminUser()
    {
        return new \admin\components\User();
    }

    /**
     * @todo remove this method!
     */
    public static function getAdminUserData()
    {
        return self::getAdminUser()->getIdentity();
    }

    public function getMenu()
    {
        return $this
        ->nodeRoute('Datei Manager', 'mdi-image-photo-library', 'admin-storage-index', 'admin/storage/index')
        ->node('Administration', 'mdi-navigation-apps')
            ->group('Zugriff')
                ->itemApi('Benutzer', 'admin-user-index', 'mdi-action-account-circle', 'api-admin-user')
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
            'menu' => [
                'class' => '\admin\components\Menu',
            ],
            'storage' => [
                'class' => '\admin\components\Storage'
            ],
            'auth' => [
                'class' => '\admin\components\Auth'
            ]
        ];
    }
    
    public function import(\luya\commands\ExecutableController $exec)
    {
        $log = [
            'filters' => [],
        ];

        foreach ($exec->getFilesNamespace('filters') as $filterClassName) {
            if (!class_exists($filterClassName)) {
                continue;
            }
            $object = new $filterClassName();
            $log['filters'][$filterClassName] = $object->save();
        }

        return $log;
    }
}
