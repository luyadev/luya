<?php
namespace cmsadmin;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-cms-cat' => 'cmsadmin\apis\CatController',
        'api-cms-nav' => 'cmsadmin\apis\NavController',
        'api-cms-navitem' => 'cmsadmin\\apis\\NavItemController',
        'api-cms-menu' => 'cmsadmin\apis\MenuController',
        'api-cms-navitempage' => 'cmsadmin\apis\NavItemPageController',
        'api-cms-layout' => 'cmsadmin\\apis\\LayoutController',
        'api-cms-block' => 'cmsadmin\\apis\\BlockController',
        'api-cms-navitemplageblockitem' => 'cmsadmin\\apis\\NavItemPageBlockItemController',
    ];

    public function getMenu()
    {
        $this->menu->createNode('cms', 'CMS', 'fa-database', 'cmsadmin-default-index');

        $node = $this->menu->createNode('cms-settings', 'CMS-Settings', 'fa-ils');
        $this->menu->createGroup($node, 'Verwalten', [
            $this->menu->createItem("cat", "Kategorien", "cmsadmin-cat-index", "fa-ils"),
            $this->menu->createItem("layout", "Layouts", "cmsadmin-layout-index", "fa-eyedropper"),
            $this->menu->createItem('block', "Blocks", "cmsadmin-block-index", "fa-outdent"),
        ]);

        return $this->menu->get();
    }

    public $assets = [
        'cmsadmin\Asset',
    ];
}
