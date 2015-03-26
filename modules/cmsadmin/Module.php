<?php
namespace cmsadmin;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-cms-admin' => 'cmsadmin\\apis\\AdminController',
        'api-cms-navitemplageblockitem' => 'cmsadmin\\apis\\NavItemPageBlockItemController',
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
        'cmsadmin\Asset',
    ];
    
    public function getMenu()
    {
        return $this
            ->nodeRoute("CMS Inhalt", "fa-th-list", "cmsadmin-default-index", "cmsadmin/default/index")
            ->node("CMS Settings", "fa-wrench")
                ->group("Verwalten")
                    ->itemApi("Kategorien", "cmsadmin-cat-index", "fa-ils", "api-cms-cat")
                    ->itemApi("Layout", "cmsadmin-layout-index", "fa-eyedropper", "api-cms-layout")
                ->group("Blöcke")
                    ->itemApi("Gruppen", "cmsadmin-blockgroup-index", "fa-group", "api-cms-blockgroup")
                    ->itemApi("Verwalten", "cmsadmin-block-index", "fa-outdent", "api-cms-block")
            ->menu();
                
        /*
        $this->menu->createNode('cms', 'CMS Inhalte', 'fa-th-list', 'cmsadmin-default-index');

        $node = $this->menu->createNode('cms-settings', 'CMS Einstellungen', 'fa-wrench');
        $this->menu->createGroup($node, 'Verwalten', [
            $this->menu->createItem("cat", "Kategorien", "cmsadmin-cat-index", "fa-ils"),
            $this->menu->createItem("layout", "Layouts", "cmsadmin-layout-index", "fa-eyedropper"),
        ]);

        $this->menu->createGroup($node, 'Blöcke', [
            $this->menu->createItem('blockgroup', 'Gruppen', 'cmsadmin-blockgroup-index', 'fa-group'),
            $this->menu->createItem('block', "Verwalte", "cmsadmin-block-index", "fa-outdent"),
        ]);

        return $this->menu->get();
        */
    }
    
    public function extendPermissionApis()
    {
        return [
            ['api' => 'api-cms-navitemplageblockitem', 'alias' => 'Blöcke Einfügen und Verschiebe'],
        ];
    }
    
    public function extendPermissionRoutes()
    {
        return [
            ['route' => 'cmsadmin/page/create', 'alias' => 'Seiten Erstellen'],
            ['route' => 'cmsadmin/page/update', 'alias' => 'Seiten Bearbeiten'],
        ];
    }
    
    public function import(\luya\commands\ExecutableController $exec)
    {
        $cmslayouts = \yii::getAlias('@app/views/cmslayouts');
        
        if (file_exists($cmslayouts)) {
            foreach(scandir($cmslayouts) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                
                $item = \cmsadmin\models\Layout::find()->where(['view_file' => $file])->one();
                
                if (!$item) {
                    
                    $content = file_get_contents($cmslayouts . DIRECTORY_SEPARATOR . $file);
                    
                    // find placeholders
                    preg_match_all("/\{\{(.*?)\}\}/", $content, $results);
                    
                    $_placeholders = [];
                    $_vars = [];
                    
                    foreach($results[1] as $match) {
                        $parts = explode(".", trim($match));
                        switch ($parts[0]) {
                            case "placeholders":
                                $_placeholders = ['label' => $parts[1], 'var' => $parts[1]];
                                break;
                            case "vars":
                                $_vars = $parts[1];
                                break;
                        }
                    }
                    
                    
                    $data = new \cmsadmin\models\Layout();
                    $data->scenario = 'restcreate';
                    $data->setAttributes([
                        "name" => ucfirst($file),
                        "view_file" => $file,
                        "json_config" => json_encode(
                            ['placeholders' => [
                                $_placeholders
                            ]]
                        ),
                    ]);
                    $data->save();
                    
                    echo "$file found and insereted.";
                }
            }
        }
        
        return "importer finished";
    }
}
