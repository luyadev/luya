<?php

namespace cms\components;

use Exception;
use Yii;
use yii\db\Query as DbQuery;
use cms\menu\Query as MenuQuery;

/**
 * Concept:
 * 
 * Return all for the current language (if not specific)
 * 
 * ```php
 * foreach(Yii::$app->menu->all() as $item) {
 * 
 * }
 * ```
 * 
 * ### Add Query
 * 
 * ability to add multiple querys as "AND" chain. like below: parent_nav_id = 0 AND parent_nav_id = 1
 * 
 * ```php
 * foreach(Yii::$app->menu->where(['parent_nav_id' => 0, 'parent_nav_id' => 1])->all() as $item) {
 *     
 * }
 * ```
 * 
 * Find one item:
 * 
 * ```php
 * $item = Yii::$app->menu->where(['id'])->one();
 * ```
 * 
 * 
 * declaration of $item:
 * 
 * ```php
 * $item->getTitle(); //
 * $item->getLink(); // /link/to/somewhere
 * $item->getChildren(); // returns a specific query on the current item
 * $item->getParent(); // return specific
 * $item->teardown();
 * ```
 * 
 * Get current active Item
 * 
 * ```php
 * $item = Yii::$app->menu->getCurrent();
 * ```
 * 
 * Get home item
 * 
 * ```php
 * $item = Yii::$app->menu->getHome();
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
 * @since 1.0.0-beta1
 * @author nadar
 */
class Menu extends \yii\base\Component
{
    public $cacheKey = 'luyaMenuComponent';
    
    public $cacheExpire = 3600;
    
    public $composition = null;
    
    public $request = null;
    
    private $_containerData = null;
    
    /**
     * Class constructor uses yii di container
     * 
     * @param \yii\web\Request $request
     * @param \luya\components\Composition $composition
     * @param array $config
     */
    public function __construct(\yii\web\Request $request, \luya\components\Composition $composition, array $config = [])
    {
        $this->request = $request;
        $this->composition = $composition;
        parent::__construct($config);
    }
    
    public function getContainerData()
    {
        if ($this->_containerData === null) {
            if (Yii::$app->has('cache')) {
                Yii::info('Menu component has cache component detected.');
                $data = Yii::$app->cache->get($this->cacheKey);
                if ($data === false) {
                    Yii::info('Menu component stores information into cache.');
                    $data = $this->loadContainerData();
                    Yii::$app->cache->set($this->cacheKey, $data, $this->cacheExpire);
                } else {
                    Yii::info('Menu component restored informations from cache.');
                }
                $this->_containerData = $data;
            } else {
                Yii::info('Menu component loaded from database.');
                $this->_containerData = $this->loadContainerData();
            }
        }
        
        return $this->_containerData;
    }
    
    public function languageContainerData($langShortCode)
    {
        if (array_key_exists($langShortCode, $this->containerData)) {
            return $this->containerData[$langShortCode];
        }
        
        throw new Exception("Unable to find the requested language '$langShortCode'.");
    }
    
    private function loadContainerData()
    {
        $container = [];
        
        $redirectMap = (new DbQuery())->select(['id', 'type', 'value'])->from('cms_nav_item_redirect')->indexBy('id')->all();
        
        foreach ((new DbQuery())->select(['short_code', 'id'])->from('admin_lang')->all() as $lang) {
            
            $data = (new DbQuery())->from(['cms_nav_item item'])
            ->select(['item.id', 'item.nav_id', 'item.title', 'item.rewrite', 'nav.is_home', 'nav.parent_nav_id', 'nav.sort_index', 'nav.is_hidden', 'nav.is_offline', 'item.nav_item_type', 'item.nav_item_type_id', 'cat.rewrite AS cat_rewrite'])
            ->leftJoin('cms_nav nav', 'nav.id=item.nav_id')
            ->leftJoin('cms_cat cat', 'cat.id=nav.cat_id')
            ->where(['nav.is_deleted' => 0, 'item.lang_id' => $lang['id']])
            ->orderBy(['cat_rewrite' => 'ASC', 'parent_nav_id' => 'ASC', 'nav.sort_index' => 'ASC'])
            ->indexBy('id')
            ->all();
            
            $index = [];
            
            foreach ($data as $item) {
                if (!array_key_exists($item['nav_id'], $index)) {
                    if ($item['parent_nav_id'] > 0) {
                        $rewrite = $index[$item['parent_nav_id']] . '/' . $item['rewrite'];
                    } else {
                        $rewrite = $item['rewrite'];
                    }
                    $index[$item['nav_id']] = $rewrite;
                }
            }
            
            array_walk($data, function(&$item, $key) use ($index, $redirectMap) {
                // concate rewrite link from parent nav ids
                if ($item['parent_nav_id'] > 0) {
                    $rewrite = $index[$item['parent_nav_id']] . '/' . $item['rewrite'];
                } else {
                    $rewrite = $item['rewrite'];
                }
                // add link key
                $item['link'] = $rewrite;
                // add redirect info if item_type 3
                if ($item['nav_item_type'] == 3) {
                    $item['redirect'] = $redirectMap[$item['nav_item_type_id']];
                } else {
                    $item['redirect'] = 0;
                }
                // remove unused keys
                unset($item['nav_item_type'], $item['nav_item_type_id']);
            });
            
            $container[$lang['short_code']] = $data;   
        }
        
        return $container;
    }
    
    public function getCurrent()
    {
        $id = 1; // resolve id from request object
        return (new MenuQuery($this))->one();
    }
    
    public function getHome()
    {
        return (new MenuQuery($this))->one();   
    }
    
    public function where(array $args)
    {
        /**
         * MenuFilter::one();
         * MenuFilter::all();
         */
        return (new MenuQuery(['menu' => $this]))->where($args);
    }
}