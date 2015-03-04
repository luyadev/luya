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
    ];

    public static $urlRules = [
        ['class' => 'admin\components\UrlRule'],
    ];

    public function init()
    {
        foreach (luya::getParams('apis') as $item) {
            $this->controllerMap[$item['alias']] = $item['class'];
        }
        parent::init();
    }

    public static function getAdminUser()
    {
        return new \admin\components\User();
    }

    public static function getAdminUserData()
    {
        return self::getAdminUser()->getIdentity();
    }

    public function getMenu()
    {
        // create menu node
        $node = $this->menu->createNode('admin', 'Administration', 'fa-gears');
        // create menu group
        $this->menu->createGroup($node, 'Authentifizierung', [
            // insert group items
            $this->menu->createItem("user", "Benutzer", "admin-user-index", "fa-user"),
            $this->menu->createItem("group", "Gruppen", "admin-group-index", "fa-users")
        ]);

        $this->menu->createGroup($node, 'Einstellungen', [
            $this->menu->createItem("lang", "Sprachen", "admin-lang-index", "fa-language")
        ]);

        return $this->menu->get();
    }

    public $assets = [
        'admin\AssetAdmin',
        'admin\AssetAngularLoadingBar',
        'admin\AssetAceUi',
        'admin\AssetAce',
    ];
    
    public function getLuyaConfig()
    {
        return [
            'storage' => new \admin\components\Storage()
        ];
    }
    
}
