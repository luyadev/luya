<?php

namespace app\modules\data\commands;

use Yii;
use luya\console\Command;
use luya\cms\models\Nav;
use luya\cms\models\NavItem;
use luya\admin\models\Lang;
use luya\cms\admin\Module;

class SetupController extends Command
{
    // 1 = parent is already used by "HOMEPAGE"
    public $pages = [
        ['alias' => 'page1', 'title' => 'Page 1', 'parent' => 0], // nav_item.id = 2
        ['alias' => 'page2', 'title' => 'Page 2', 'parent' => 0], // nav_item.id = 3
        ['alias' => 'page3', 'title' => 'Page 3', 'parent' => 0], // nav_item.id = 4
        ['alias' => 'page4', 'title' => 'Page 4', 'parent' => 0], // nav_item.id = 5
        ['alias' => 'page5', 'title' => 'Page 5', 'parent' => 0], // nav_item.id = 6
        ['alias' => 'page6', 'title' => 'Page 6', 'parent' => 0], // nav_item.id = 7

        ['alias' => 'p1-page1', 'title' => 'Page 1', 'parent' => 2], // nav_item.id = 8
        ['alias' => 'p1-page2', 'title' => 'Page 2', 'parent' => 2], // nav_item.id = 9
        ['alias' => 'p1-page3', 'title' => 'Page 3', 'parent' => 2], // nav_item.id = 10
        ['alias' => 'p1-page4', 'title' => 'Page 4', 'parent' => 2], // nav_item.id = 11
        ['alias' => 'p1-page5', 'title' => 'Page 5', 'parent' => 2], // nav_item.id = 12
        ['alias' => 'p1-page6', 'title' => 'Page 6', 'parent' => 2], // nav_item.id = 13
    ];
    
    public $redirects = [
        ['alias' => 'redirect-1', 'title' => 'Redirect to Page 1', 'parent' => 0, 'type' => '1', 'typeValue' => 2], // nav_item.id = 14
        ['alias' => 'redirect-2', 'title' => 'Redirect to Page 2', 'parent' => 0, 'type' => '1', 'typeValue' => 3], // nav_item.id = 15
        ['alias' => 'redirect-3', 'title' => 'Redirect to Sub Page 2', 'parent' => 0, 'type' => '1', 'typeValue' => 8], // nav_item.id = 16
        ['alias' => 'redirect-4', 'title' => 'Redirect to luya.io', 'parent' => 0, 'type' => '2', 'typeValue' => 'https://luya.io'], // nav_item.id = 17
    ];
    
    public $modules = [
        
    ];
    
    public function actionIndex()
    {
        Module::setAuthorUserId(1);
        $lang = new Lang();
        $lang->scenario = 'restcreate';
        $lang->attributes = ['name' => 'Deutsch', 'short_code' => 'de', 'is_default' => 0];
        $lang->save(false);
        
        foreach ($this->pages as $d) {
            $model = new Nav();
            $navItemId = $model->createPage($d['parent'], 1, 1, $d['title'], $d['alias'], 1, 'Description of ' . $d['title']);
            if ($navItemId) {
                $item = NavItem::findOne(['alias' => $d['alias']]);
                if ($item) {
                    $item->nav->updateAttributes(['is_offline' => 0, 'is_hidden' => 0]);
                }
            }
        }
        
        foreach ($this->redirects as $redir) {
            $model = new Nav();
            $redirItemId = $model->createRedirect($redir['parent'], 1, 1, $redir['title'], $redir['alias'], $redir['type'], $redir['typeValue'], 'Description of ' . $redir['title']);
            if ($redirItemId) {
                $item = NavItem::findOne(['alias' => $redir['alias']]);
                if ($item) {
                    $item->nav->updateAttributes(['is_offline' => 0, 'is_hidden' => 0]);
                }
            }
        }
    }
}
