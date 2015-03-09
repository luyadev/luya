<?php
namespace admin;

use luya\Luya;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-admin-defaults' => 'admin\apis\DefaultsController',
        'api-admin-user' => 'admin\apis\UserController',
        'api-admin-menu' => 'admin\apis\MenuController',
        'api-admin-group' => 'admin\apis\GroupController',
        'api-admin-lang' => 'admin\apis\LangController',
        'api-admin-storage' => 'admin\apis\StorageController',
        'api-admin-effect' => 'admin\apis\EffectController',
        'api-admin-filter' => 'admin\apis\FilterController',
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
    
    public function init()
    {
        foreach (luya::getParams('apis') as $item) {
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
        $this->menu->createNode('storage', 'Dateien Manager', 'fa-hdd-o', 'admin-storage-index');
        // create menu node
        $node = $this->menu->createNode('admin', 'Admin Einstellungen', 'fa-gears');
        // create menu group
        $this->menu->createGroup($node, 'Zugriff', [
            // insert group items
            $this->menu->createItem("user", "Benutzer", "admin-user-index", "fa-user"),
            $this->menu->createItem("group", "Gruppen", "admin-group-index", "fa-users")
        ]);

        $this->menu->createGroup($node, 'System', [
            $this->menu->createItem("lang", "Sprachen", "admin-lang-index", "fa-language")
        ]);
        
        $this->menu->createGroup($node, 'Bilder', [
            $this->menu->createItem('effect', 'Effekte', 'admin-effect-index', 'fa-link'),
            $this->menu->createItem('filter', 'Filter', 'admin-filter-index', 'fa-filter'),
        ]);
        
        return $this->menu->get();
    }


    public function getLuyaConfig()
    {
        return [
            'storage' => new \admin\components\Storage(),
        ];
    }
}
