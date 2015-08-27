<?php

namespace cmsadmin;

use Yii;
use cmsadmin\models\Block;
use cmsadmin\models\Layout;
use luya\commands\ExecutableController;

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
    public function import(ExecutableController $exec)
    {
        $_log = [
            'blocks' => [],
            'layouts' => [],
        ];

        $allblocks = Block::find()->all();
        $exists = [];
        foreach ($exec->getFilesNamespace('blocks') as $ns) {
            $model = Block::find()->where(['class' => $ns])->asArray()->one();
            if (!$model) {
                $block = new Block();
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
                $block->delete();
            }
        }

        /* import project specific layouts */
        $cmslayouts = Yii::getAlias('@app/views/cmslayouts');
        $layoutFiles = [];
        if (file_exists($cmslayouts)) {
            foreach (scandir($cmslayouts) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $layoutFiles[] = $file;
                $layoutItem = Layout::find()->where(['view_file' => $file])->one();

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
                $_placeholders = ['placeholders' => $_placeholders];
                if ($layoutItem) {
                    $match = $this->comparePlaceholders($_placeholders, json_decode($layoutItem->json_config, true));
                    if ($match) {
                        continue;
                    }
                    $layoutItem->scenario = 'restupdate';
                    $layoutItem->setAttributes([
                        'name' => ucfirst($file),
                        'view_file' => $file,
                        'json_config' => json_encode($_placeholders),
                    ]);
                    $layoutItem->save();

                    $_log['layouts'][$file] = "existing cmslayout $file updated.";
                } else {
                    // add item into the database table
                    $data = new Layout();
                    $data->scenario = 'restcreate';
                    $data->setAttributes([
                        'name' => ucfirst($file),
                        'view_file' => $file,
                        'json_config' => json_encode($_placeholders),
                        ]);
                    $data->save();
                    $_log['layouts'][$file] = "new cmslayout $file found and inserted.";
                }
            }

            foreach (Layout::find()->where(['not in', 'view_file', $layoutFiles])->all() as $layoutItem) {
                $layoutItem->delete();
            }
        }

        return $_log;
    }

    /**
     * @param array $array1
     * @param array $array2
     *
     * @return bool true if the same, false if not the same
     */
    private function comparePlaceholders($array1, $array2)
    {
        if (!array_key_exists('placeholders', $array1) || !array_key_exists('placeholders', $array2)) {
            return false;
        }

        $a1 = $array1['placeholders'];
        $a2 = $array2['placeholders'];

        if (count($a1) !== count($a2)) {
            return false;
        }

        foreach ($a1 as $key => $holder) {
            if (!array_key_exists($key, $a2)) {
                return false;
            }

            foreach ($holder as $var => $value) {
                if (!array_key_exists($var, $a2[$key])) {
                    return false;
                }

                if ($value != $a2[$key][$var]) {
                    return false;
                }
            }
        }

        return true;
    }
}
