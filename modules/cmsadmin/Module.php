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
            ->nodeRoute('CMS Inhalte', 'mdi-social-public', 'cmsadmin-default-index', 'cmsadmin/default/index')
            ->node('CMS Einstellungen', 'mdi-image-tune')
                ->group('Verwalten')
                    ->itemApi('Kategorien', 'cmsadmin-cat-index', 'mdi-action-settings-applications', 'api-cms-cat')
                    ->itemApi('Layout', 'cmsadmin-layout-index', 'mdi-image-style', 'api-cms-layout')
                ->group('Blöcke')
                    ->itemApi('Gruppen', 'cmsadmin-blockgroup-index', 'mdi-content-content-copy', 'api-cms-blockgroup')
                    ->itemApi('Verwalten', 'cmsadmin-block-index', 'mdi-editor-format-align-left', 'api-cms-block')
            ->menu();
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

    /**
     * @todo do not only import, also update changes in the template
     * @todo how do we send back values into the executblae controller for output purposes?
     */
    public function import(\luya\commands\ExecutableController $exec)
    {
        $_log = [
            'blocks' => [],
            'layouts' => [],
        ];

        $allblocks = \cmsadmin\models\Block::find()->all();
        $exists = [];
        foreach ($exec->getFilesNamespace('blocks') as $ns) {
            $model = \cmsadmin\models\Block::find()->where(['class' => $ns])->asArray()->one();
            if (!$model) {
                $block = new \cmsadmin\models\Block();
                $block->scenario = 'commandinsert';
                $block->setAttributes([
                    'group_id' => 1,
                    'system_block' => 0,
                    'class' => $ns,
                ]);
                $block->insert();
                $_log['blocks'][$ns] = 'new block has been added to database.';
            } else {
                $_log['blocks'][$ns] = 'already in the database.';
                $exists[] = $model['id'];
            }
        }
        foreach ($allblocks as $block) {
            if (!in_array($block->id, $exists)) {
                /*
                $items = \cmsadmin\models\NavItemPageBlockItem::find()->where(['block_id' => $block->id])->all();
                foreach($items as $it) {
                    $it->delete();
                }
                */
                $block->delete();
            }
        }

        /* import project specific layouts */
        $cmslayouts = \yii::getAlias('@app/views/cmslayouts');

        if (file_exists($cmslayouts)) {
            foreach (scandir($cmslayouts) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }

                $layoutItem = \cmsadmin\models\Layout::find()->where(['view_file' => $file])->one();

                $content = file_get_contents($cmslayouts.DIRECTORY_SEPARATOR.$file);
                // find all twig brackets
                preg_match_all("/\{\{(.*?)\}\}/", $content, $results);
                // local vars
                $_placeholders = [];
                $_vars = [];
                // explode the specific vars for each type
                foreach ($results[1] as $match) {
                    $parts = explode('.', trim($match));
                    switch ($parts[0]) {
                        case 'placeholders':
                            $_placeholders[] = ['label' => $parts[1], 'var' => $parts[1]];
                            break;
                        case 'vars':
                            $_vars = $parts[1];
                            break;
                    }
                }
                if ($layoutItem) {
                    $layoutItem->scenario = 'restupdate';
                    $layoutItem->setAttributes([
                        'name' => ucfirst($file),
                        'view_file' => $file,
                        'json_config' => json_encode(
                                ['placeholders' => $_placeholders,
                                ]
                        ),
                    ]);
                    $layoutItem->save();

                    $_log['layouts'][$file] = "existing cmslayout $file updated.";
                } else {
                    // add item into the database table
                    $data = new \cmsadmin\models\Layout();
                    $data->scenario = 'restcreate';
                    $data->setAttributes([
                        'name' => ucfirst($file),
                        'view_file' => $file,
                        'json_config' => json_encode(
                                ['placeholders' => $_placeholders,
                                ]
                        ),
                        ]);
                    $data->save();
                    $_log['layouts'][$file] = "new cmslayout $file found and inserted.";
                }
            }
        }

        return $_log;
    }
}
