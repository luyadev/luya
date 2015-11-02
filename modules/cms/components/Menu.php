<?php

namespace cms\components;

use Yii;
use yii\db\Query;

/**
 * Concept:
 * 
 * Return all for the current language (if not spefied)
 * ```php
 * foreach(Yii::$app->menu->all() as $item) {
 * 
 * }
 * ```
 * 
 * ### Add Filters
 * 
 * ability to add multiple filters as "AND" chain. like below: parent_nav_id = 0 AND parent_nav_id = 1
 * 
 * ```php
 * foreach(Yii::$app->menu->filter(['parent_nav_id' => 0, 'parent_nav_id' => 1])->all() as $item) {
 *     
 * }
 * ```
 * 
 * Find one item:
 * ```php
 * $item = Yii::$app->menu->filter(['id'])->one();
 * ```
 * 
 * 
 * declaration of $item:
 * ```php
 * $item->getTitle(); //
 * $item->getLink(); // /link/to/somewhere
 * $item->getChildren(); // returns a specific filter on the current item
 * $item->getParents(); // returns a speicific filter on the current item
 * $item->teardown();
 * ```
 * 
 * Get current active Item
 * ```php
 * $item = Yii::$app->menu->getCurrent();
 * ```
 * 
 * Example to get Breadcrumbs:
 * 
 * ```php
 * foreach(Yii::$app->menu->current->teardown() as $item) {
 *     echo "<a href='" . $item->link . "'>" . item->title . "</a>"; // getter methodes can be accessed as property name as of yii object definitons
 * }
 * ```
 * 
 * @author nadar
 */
class Menu extends \yii\base\Component
{
    /*
    public function init()
    {
        $this->load();
    }
    
    private function load()
    {
        $data = (new Query())->from(['cms_nav_item item'])
        ->select(['item.id', 'item.nav_id', 'item.title', 'item.rewrite', 'nav.is_home', 'nav.parent_nav_id', 'nav.sort_index', 'nav.is_hidden', 'nav.is_offline', 'cat.name AS cat_name', 'cat.rewrite AS cat_rewrite'])
        ->leftJoin('cms_nav nav', 'nav.id=item.nav_id')
        ->leftJoin('cms_cat cat', 'cat.id=nav.cat_id')
        ->orderBy(['nav.sort_index' => 'ASC'])
        ->indexBy('id')
        ->all();
    }
    */
}