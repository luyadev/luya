<?php

namespace app\modules\data\commands;

use Yii;
use luya\console\Command;
use cmsadmin\models\Nav;
use cmsadmin\models\NavItem;

class SetupController extends Command
{
    // 1 = parent is already used by "HOMEPAGE"
    public $items = [
        ['alias' => 'page1', 'title' => 'Page 1', 'parent' => 0], // 2
        ['alias' => 'page2', 'title' => 'Page 2', 'parent' => 0], // 3
        ['alias' => 'page3', 'title' => 'Page 3', 'parent' => 0], // 4
        ['alias' => 'page4', 'title' => 'Page 4', 'parent' => 0], // 5
        ['alias' => 'page5', 'title' => 'Page 5', 'parent' => 0], // 6
        ['alias' => 'page6', 'title' => 'Page 6', 'parent' => 0], // 7
        
        ['alias' => 'p1-page1', 'title' => 'Page 1', 'parent' => 2],
        ['alias' => 'p1-page2', 'title' => 'Page 2', 'parent' => 2],
        ['alias' => 'p1-page3', 'title' => 'Page 3', 'parent' => 2],
        ['alias' => 'p1-page4', 'title' => 'Page 4', 'parent' => 2],
        ['alias' => 'p1-page5', 'title' => 'Page 5', 'parent' => 2],
        ['alias' => 'p1-page6', 'title' => 'Page 6', 'parent' => 2],
    ];
    
    public function actionIndex()
    {
        foreach ($this->items as $d) {
            $model = new Nav();
            $navItemId = $model->createPage($d['parent'], 1, 1, $d['title'], $d['alias'], 1, 'Description of ' . $d['title']);
            if ($navItemId) {
                $item = NavItem::findOne(['alias' => $d['alias']]);
                if ($item) {
                    $item->nav->updateAttributes(['is_offline' => 0, 'is_hidden' => 0]);
                }
            }
        }
    }
}