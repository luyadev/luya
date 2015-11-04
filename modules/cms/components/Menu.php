<?php

namespace cms\components;

use Exception;
use Yii;
use yii\db\Query as DbQuery;
use cms\menu\Query as MenuQuery;
use cms\menu\cms\menu;
use cms\menu\cms\menu;

/**
 * Menu Component
 * 
 * **Query menu data**
 * 
 * ability to add multiple querys as "AND" chain. like below: parent_nav_id = 0 AND parent_nav_id = 1
 * 
 * ```php
 * foreach(Yii::$app->menu->find()->where(['parent_nav_id' => 0, 'parent_nav_id' => 1])->all() as $item) {
 *     echo $item->title;
 * }
 * ```
 * 
 * Find one item:
 * 
 * ```php
 * $item = Yii::$app->menu->find()->where(['id' => 1])->one();
 * ```
 * 
 * If the element coult nod be found, one will return *false*.
 * 
 * **Getter methods of an item**
 * 
 * ```php
 * $item->getTitle();
 * $item->getLink();
 * $item->getAlias();
 * $item->getChildren();
 * $item->getParent();
 * $item->teardown();
 * ```
 * 
 * All getter methods can be access like
 * 
 * ```php
 * $item->title;
 * $item->link;
 * $item->alias;
 * $item->childeren;
 * $item->parent;
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
 * @TBD
 * 
 * @todo add menu method to get breadcrumbs
 * @since 1.0.0-beta1
 * @author nadar
 */
class Menu extends \yii\base\Component
{
    public $cacheKey = 'luyaMenuComponent';
    
    public $cacheExpire = 3600;
    
    public $request = null;
    
    private $_composition = null;
    
    private $_current = null;
    
    private $_currentAppendix = null;
    
    private $_containerData = null;
    
    /**
     * Class constructor uses yii di container
     * 
     * @param \yii\web\Request $request
     * @param \luya\components\Composition $composition
     * @param array $config
     */
    public function __construct(\yii\web\Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
    }
    
    public function getComposition()
    {
        if ($this->_composition === null) {
            $this->_composition = Yii::$app->get('composition');
        }
        
        return $this->_composition;
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
            ->select(['item.id', 'item.nav_id', 'item.title', 'item.rewrite', 'nav.is_home', 'nav.parent_nav_id', 'nav.sort_index', 'nav.is_hidden', 'item.nav_item_type', 'item.nav_item_type_id', 'cat.rewrite AS cat'])
            ->leftJoin('cms_nav nav', 'nav.id=item.nav_id')
            ->leftJoin('cms_cat cat', 'cat.id=nav.cat_id')
            ->where(['nav.is_deleted' => 0, 'item.lang_id' => $lang['id'], 'nav.is_offline' => 0])
            ->orderBy(['cat' => 'ASC', 'parent_nav_id' => 'ASC', 'nav.sort_index' => 'ASC'])
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
                $item['alias'] = $rewrite;
                $item['link'] = $this->composition->full . $rewrite;
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
    
    public function resolveCurrent()
    {
        $requestPath = $this->request->get('path', null);
        
        if (empty($requestPath)) {
            $requestPath = $this->home->alias;
        }
        
        $urlParts = explode("/", $requestPath);
        
        
        $item = $this->aliasMatch($urlParts);
        
        if (!$item) {
            while (array_pop($urlParts)) {
                if (($item = $this->aliasMatch($urlParts)) !== false) {
                    break;
                }
            }
        }
        
        if (!$item) {
            return $this->home;
        }
        
        $this->_currentAppendix = substr($requestPath, strlen($item->alias) + 1);
        
        return $item;
    }
    
    private function aliasMatch(array $urlParts)
    {
        return (new MenuQuery(['menu' => $this]))->where(['alias' => implode('/', $urlParts)])->one();
    }
    
    public function getCurrentAppendix()
    {
        if ($this->_current === null) {
            $this->_current = $this->resolveCurrent();
        }
        
        return $this->_currentAppendix;
    }
    
    public function getCurrent()
    {
        if ($this->_current === null) {
            $this->_current = $this->resolveCurrent();
        }
        
        return $this->_current;
    }
    
    public function getHome()
    {
        return (new MenuQuery(['menu' => $this]))->where(['is_home' => '1'])->one();   
    }
    
    public function find()
    {
        return (new MenuQuery(['menu' => $this]));
    }    
    
    public function findAll(array $whereArguments)
    {
        return (new MenuQuery())->where($whereArguments)->all();
    }
    
    public function findOne(array $whereArguments)
    {
        return (new MenuQuery())->where($whereArguments)->one();
    }
}