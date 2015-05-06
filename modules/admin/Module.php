<?php

namespace admin;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-admin-defaults' => 'admin\apis\DefaultsController',
        'api-admin-storage' => 'admin\apis\StorageController',
        'api-admin-menu' => 'admin\apis\MenuController',
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
        'admin\AssetAdmin',
        'admin\AssetAngularLoadingBar',
        'admin\AssetAceUi',
        'admin\AssetAce',
    ];

    public $storageFolder = '@webroot/storage';

    public $storageFolderHttp = 'storage';

    public function init()
    {
        foreach (\luya\helpers\Param::get('apis') as $item) {
            $this->controllerMap[$item['alias']] = $item['class'];
        }
        parent::init();
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
        ->nodeRoute('Datei Manager', 'fa-hdd-o', 'admin-storage-index', 'admin/storage/index')
        ->node('Admin Einstellungen', 'fa-gears')
            ->group('Zrugriff')
                ->itemApi('Benutzer', 'admin-user-index', 'fa-user', 'api-admin-user')
                ->itemApi('Gruppen', 'admin-group-index', 'fa-users', 'api-admin-group')
            ->group('System')
                ->itemApi('Sprachen', 'admin-lang-index', 'fa-language', 'api-admin-lang')
            ->group('Bilder')
                ->itemApi('Effekte', 'admin-effect-index', 'fa-link', 'api-admin-effect')
                ->itemApi('Filter', 'admin-filter-index', 'fa-filter', 'api-admin-filter')
        ->menu();
    }
    /*
    public function getMenu()
    {
        $this->menu->createNode('storage', 'Dateien Manager', 'fa-hdd-o', 'admin-storage-index');
        // create menu node
        $node = $this->menu->createNode('admin', 'Admin Einstellungen', 'fa-gears');
        // create menu group
        $this->menu->createGroup($node, 'Zugriff', [
            // insert group items
            $this->menu->createItem("user", "Benutzer", "admin-user-index", "fa-user"),
            $this->menu->createItem("group", "Gruppen", "admin-group-index", "fa-users"),
        ]);

        $this->menu->createGroup($node, 'System', [
            $this->menu->createItem("lang", "Sprachen", "admin-lang-index", "fa-language"),
        ]);

        $this->menu->createGroup($node, 'Bilder', [
            $this->menu->createItem('effect', 'Effekte', 'admin-effect-index', 'fa-link'),
            $this->menu->createItem('filter', 'Filter', 'admin-filter-index', 'fa-filter'),
        ]);

        return $this->menu->get();
    }
    */

    public function getLuyaComponents()
    {
        return [
            'storage' => new \admin\components\Storage(),
            'auth' => new \admin\components\Auth(),
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
