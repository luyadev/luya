<?php

namespace cmsadmin;

class Module extends \admin\base\Module
{
    public $apis = [
        'api-cms-admin' => 'cmsadmin\\apis\\AdminController',
        'api-cms-navitempageblockitem' => 'cmsadmin\\apis\\NavItemPageBlockItemController',
        'api-cms-defaults' => 'cmsadmin\apis\DefaultsController',
        'api-cms-nav' => 'cmsadmin\apis\NavController',
        'api-cms-navitem' => 'cmsadmin\\apis\\NavItemController',
        'api-cms-menu' => 'cmsadmin\apis\MenuController', // should put into api-cms-admin
        //'api-cms-navitempage' => 'cmsadmin\apis\NavItemPageController', // should put into api-cms-admin
        //'api-cms-navitemmodule' => 'cmsadmin\\apis\\NavItemModuleController',
        'api-cms-layout' => 'cmsadmin\\apis\\LayoutController',
        'api-cms-block' => 'cmsadmin\\apis\\BlockController',
        'api-cms-blockgroup' => 'cmsadmin\\apis\\BlockgroupController',
        'api-cms-cat' => 'cmsadmin\apis\CatController',

    ];

    public $assets = [
        'cmsadmin\assets\Main',
    ];

    public function getMenu()
    {
        return $this
            ->nodeRoute('Seiteninhalte', 'mdi-content-content-copy', 'cmsadmin-default-index', 'cmsadmin/default/index', 'cmsadmin\models\NavItem')
            ->node('CMS-Einstellungen', 'mdi-action-settings')
                ->group('Seitenvorlagen')
                    ->itemApi('Kategorien', 'cmsadmin-cat-index', 'mdi-device-storage', 'api-cms-cat')
                    ->itemApi('Layouts', 'cmsadmin-layout-index', 'mdi-action-aspect-ratio', 'api-cms-layout')
                ->group('Inhaltselemente')
                    ->itemApi('Blockgruppen', 'cmsadmin-blockgroup-index', 'mdi-content-content-copy', 'api-cms-blockgroup')
                    ->itemApi('Blöcke Verwalten', 'cmsadmin-block-index', 'mdi-editor-format-align-left', 'api-cms-block')
            ->menu();
    }

    public function extendPermissionApis()
    {
        return [
            ['api' => 'api-cms-navitempageblockitem', 'alias' => 'Blöcke einfügen und verschieben'],
        ];
    }

    public function extendPermissionRoutes()
    {
        return [
            ['route' => 'cmsadmin/page/create', 'alias' => 'Seiten Erstellen'],
            ['route' => 'cmsadmin/page/update', 'alias' => 'Seiten Bearbeiten'],
        ];
    }

    /**
     * @todo do not only import, also update changes in the template
     * @todo how do we send back values into the executblae controller for output purposes?
     */
    public function import(\luya\commands\ImportController $import)
    {
        return [
            '\\cmsadmin\\importers\\BlockImporter',
            '\\cmsadmin\\importers\\CmslayoutImporter',
        ];
    }
}
