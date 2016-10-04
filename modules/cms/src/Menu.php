<?php

namespace luya\cms;

use Yii;

use ArrayAccess;
use yii\base\Component;
use yii\web\NotFoundHttpException;
use yii\db\Query as DbQuery;
use luya\cms\Exception;
use luya\cms\menu\Query as MenuQuery;
use luya\cms\models\NavItemModule;
use luya\traits\CacheableTrait;
use luya\cms\menu\Item;
use luya\cms\menu\InjectItem;

/**
 * Menu container component by language.
 *
 * The menu container component returns an array with all menu items for a specific language, the class
 * is designed to run in "singleton" mode. The menu component provides also basic find methods like findAll,
 * findOne to return specific data via the Query class. The menu components resolves also the current item
 * based on the current request object.
 *
 * ### findAll()
 *
 * Example of getting all menu items for a specific where condition. The findAll() method does not provide
 * the ability to add with statements, or chaning the language container as its a capsulated MenuQuery.
 *
 * ```php
 * $itemsArray = Yii::$app->menu->findAll(['parent_nav_id' => 0, 'parent_nav_id' => 1]);
 * ```
 *
 * ### findOne()
 *
 * Example of getting one menu item for a specific where condition. The findOne() method does not provide
 * the ability to add with statements, or chaning the language container as its a capsulated MenuQuery.
 *
 * ```php
 * $itemArray = Yii::$app->menu->findOne(['id' => 1]);
 * ```
 *
 * ### find()
 *
 * The find() methods is wrapper for creating a new cms\menu\Query().
 *
 * ```php
 * $itemsArray = Yii::$app->menu->find()->where(['id' => 1])->lang('en')->all();
 * // is equal to:
 * $itemsArray = (new \cms\menu\Query())->where(['id' => 1])->lang('en')->all();
 * ```
 *
 * ### current
 *
 * One of the main goals of the menu component is to retrieve the current active loaded item, based on the
 * current request object. You can always us getCurrent() or current to retrieve the current menu item.
 *
 * ```php
 * $currentItem = Yii::$app->menu->getCurrent();
 * // is equal to:
 * $currentItem = Yii::$app->menu->current;
 * ```
 *
 * ### currentAppendix
 *
 * The getCurrentAppendix() method returns the parts from the url who are not related to the menu link, the
 * appendix part is commonly a part for a module url rule used to switch between controlelrs and actions. The
 * currentAppendix information will be resolved with the getCurrent() method.
 *
 * ### home
 *
 * The the home item for the current active language (defined by composition). As of Yii object inheritance
 * you can use getHome() or home;
 *
 * ```php
 * $homeItem = Yii::$app->menu->getHome();
 * // is equal to:
 * $homeItem = Yii::$app->menu->home;
 * ```
 *
 * @since 1.0.0-beta1
 *
 * @author nadar
 */
class Menu extends Component implements ArrayAccess
{
    use CacheableTrait;
    
    /**
     * @todo rename to EVENT_ON_ITEM_FIND
     */
    const MENU_ITEM_EVENT = 'menuItemEvent';
    
    const EVENT_AFTER_LOAD = 'eventAfterLoad';
    
    /**
     * @var luya\web\Request Request object
     */
    public $request = null;
    
    public $cachePrefix = 'MenuContainerCache';
    
    private $_currentUrlRule = null;
    
    private $_composition = null;

    private $_current = null;

    private $_currentAppendix = null;

    private $_languageContainer = [];

    private $_languages = null;

    private $_redirectMap = null;
    
    private $_modulesMap = null;
    
    /**
     * Class constructor to DI the request object.
     *
     * @param \luya\web\Request            $request
     * @param \luya\components\Composition $composition
     * @param array                        $config
     */
    public function __construct(\luya\web\Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
    }
    
    public function setCurrentUrlRule(array $rule)
    {
        $this->_currentUrlRule = $rule;
    }
    
    public function getCurrentUrlRule()
    {
        return $this->_currentUrlRule;
    }
    
    /**
     * ArrayAccess check if the offset key exists in the language array.
     *
     * @param string $offset Language short code the verify
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return ($this->getLanguage($offset)) ? true : false;
    }

    /**
     * ArrayAccess get the current offset key if not yet loaded.
     *
     * @param string $offset Language short code to get
     */
    public function offsetGet($offset)
    {
        return $this->getLanguageContainer($offset);
    }

    /**
     * ArrayAccess offsetSet is not implemented in singleton component.
     *
     * @param string $offset
     * @param string $value
     *
     * @throws Exception Always throws exception as this method is not implemented.
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception('The set method is disabled for this component.');
    }

    /**
     * ArrayAccess offsetSet is not implemented in singleton component.
     *
     * @param string $offset
     *
     * @throws Exception Always throws exception as this method is not implemented.
     */
    public function offsetUnset($offset)
    {
        throw new Exception('The unset method is disabled for this component.');
    }

    /**
     * Get the composition component if not yet loaded.
     *
     * @return luya\web\Composition Object with composition informationes.
     */
    public function getComposition()
    {
        if ($this->_composition === null) {
            $this->_composition = Yii::$app->get('composition');
        }

        return $this->_composition;
    }

    /**
     * Load and return the language container for the specific langShortCode, this method is used
     * when using the ArrayAccess offsetGet() method.
     *
     * @param string $langShortCode A languag short code which have to access in $this->getLanguages().
     *
     * @return array An array containing all items in theyr keys for the provided language short code.
     */
    public function getLanguageContainer($langShortCode)
    {
        if (!array_key_exists($langShortCode, $this->_languageContainer)) {
            $this->_languageContainer[$langShortCode] = $this->loadLanguageContainer($langShortCode);
            $this->trigger(self::EVENT_AFTER_LOAD);
        }

        return $this->_languageContainer[$langShortCode];
    }

    /**
     * Get languag information for a specific language short code.
     *
     * @param string $shortCode E.g. de or en
     *
     * @return array|false If the shortCode exists an array with informations as returned, otherwise false.
     */
    public function getLanguage($shortCode)
    {
        return (array_key_exists($shortCode, $this->getLanguages())) ? $this->getLanguages()[$shortCode] : false;
    }

    /**
     * Get an array with all available system languages based on the admin_lang table.
     *
     * @return array An array where the key is the short_code and the value an array containing shortcode and id.
     */
    public function getLanguages()
    {
        if ($this->_languages === null) {
            $this->_languages = (new DbQuery())->select(['short_code', 'id'])->indexBy('short_code')->from('admin_lang')->all();
        }

        return $this->_languages;
    }

    /**
     * Get an array containing all redirect items from the database table cms_nav_item_redirect.
     *
     * @return array An array where the key is the id and the value an array containing id, type and value.
     */
    public function getRedirectMap()
    {
        if ($this->_redirectMap === null) {
            $this->_redirectMap = (new DbQuery())->select(['id', 'type', 'value'])->from('cms_nav_item_redirect')->indexBy('id')->all();
        }

        return $this->_redirectMap;
    }

    /**
     * Returns the parts of the rules who do not belong to the current active menu item link. For instance the current menu link is `/de/company/news` where this
     * page is declared as a module with urlRules, controllers and actions. If the url path is `/de/company/news/detail/my-first-news` the
     * appendix would be `detail/my-first-news`.
     *
     * @return string The url part not related for the current active link
     */
    public function getCurrentAppendix()
    {
        if ($this->_current === null) {
            $this->_current = $this->resolveCurrent();
        }

        return $this->_currentAppendix;
    }

    /**
     * Ability to override the current item in order to make real preview urls (as when resolver does
     * not work of changed urls).
     *
     * @param \cms\menu\Item $item The current item object
     * @since 1.0.0-beta6
     */
    public function setCurrent(Item $item)
    {
        $this->_current = $item;
    }
    
    /**
     * Get the current menu item resolved by active language (from composition).
     *
     * @return \cms\menu\Item An item-object for the current active item.
     */
    public function getCurrent()
    {
        if ($this->_current === null) {
            $this->_current = $this->resolveCurrent();
        }

        return $this->_current;
    }
    
    /**
     * Get all items for a specific level.
     *
     * @param integer $level levels starts with 1
     * @param \luya\cms\menu\Item $baseItem Provide an optional element which represents the base calculation item for Theme
     * siblings/children calculation, this can be case when you have several contains do not want to use the "current" Item
     * as base calucation, because getCurrent() could be in another container so it would get you all level container items for
     * this container.
     * @return boolean|array QueryIterator with data
     */
    public function getLevelContainer($level, Item $baseItem = null)
    {
        // define if the requested level is the root line (level 1) or not
        $rootLine = ($level === 1) ? true : false;
        // countdown the level (as we need the parent of the element to get the children
        $level--;
        // foreach counter
        $i = 1;
        
        if ($baseItem === null) {
            $baseItem = $this->getCurrent();
        }
        
        // foreach
        foreach ($baseItem->with('hidden')->getTeardown() as $item) {
            // if its the root line an match level 1 get all siblings
            if ($rootLine && $i == 1) {
                return $item->without(['hidden'])->siblings;
            } elseif ($i == $level) {
                return $item->without(['hidden'])->children;
            }
            $i++;
        }
        // no no container found for the defined level
        return false;
    }

    /**
     * Get the current item for specified level/depth. Menus always start on level/depth 1. This works
     * only in reversed order, to get the parent level from a child!
     *
     * @param int $level Level menu starts with 1
     *
     * @return \luya\cms\menu\Item An item-object for the specific level current.
     */
    public function getLevelCurrent($level)
    {
        $i = 1;
        foreach ($this->getCurrent()->with('hidden')->getTeardown() as $item) {
            if ($i == $level) {
                return $item;
            }
            ++$i;
        }

        return false;
    }
    
    /**
     * currentLevel() is deprecated, use getLevelCurrent().
     *
     * @param int $level
     */
    public function currentLevel($level)
    {
        trigger_error('currentLevel() is deprecated, use getLevelCurrent()', E_USER_NOTICE);

        return $this->getLevelCurrent($level);
    }

    /**
     * Return the home site for the current resolved language resolved by \luya\web\Composition component.
     *
     * @return \luya\cms\menu\Item An item-object for the home item for the current resolved language.
     */
    public function getHome()
    {
        return (new MenuQuery())->where(['is_home' => '1'])->with('hidden')->one();
    }

    /**
     * Wrapper method for `new \luya\cms\menu\Query()` object.
     *
     * @return \luya\cms\menu\Query
     */
    public function find()
    {
        return (new MenuQuery());
    }

    /**
     * Wrapper method to get all menu items for the current language without hidden items for
     * the specific where statement.
     *
     * @param array $where See \luya\cms\menu\Query::where()
     * @see \luya\cms\menu\Query::where()
     * @return  \luya\cms\menu\QueryIterator
     */
    public function findAll(array $where)
    {
        return (new MenuQuery())->where($where)->all();
    }

    /**
     * Wrapper method to get one menu item for current language without hidden items for the
     * sepcific where statement.
     *
     * @param array $where
     * @see \luya\cms\menu\Query::where()
     * @return \luya\cms\menu\QueryIterator
     */
    public function findOne(array $where)
    {
        return (new MenuQuery())->where($where)->one();
    }

    /* private methods */

    /**
     * Find the current element based on the request get property 'path'.
     *
     * 1. if request path is empty us the getHome() to return alias.
     * 2. find menu item based on the end of the current path (via array_pop)
     * 3. if no item could be found the home item will be returned
     * 4. otherwise return the alias match from step 2.
     *
     * @return \luya\cms\menu\Item
     */
    private function resolveCurrent()
    {
        $requestPath = $this->request->get('path', null);

        if (empty($requestPath)) {
            $home = $this->getHome();
            if (!$home) {
                throw new NotFoundHttpException('Home item could not be found, have you forget to set a default page?');
            }
            $requestPath = $home->alias;
        }

        $requestPath = rtrim($requestPath, '/');
        
        $urlParts = explode('/', $requestPath);
        
        $item = $this->aliasMatch($urlParts);

        if (!$item) {
            while (array_pop($urlParts)) {
                if (($item = $this->aliasMatch($urlParts)) !== false) {
                    break;
                }
            }
        }

        if ($item) {
            $this->_currentAppendix = substr($requestPath, strlen($item->alias) + 1);
            return $item;
        }

        // no item could have been resolved, but the home side type is module, which can have links.
        if (!$item && $this->home->type == 2) {
            $this->_currentAppendix = $requestPath;
            return $this->getHome();
        }
        
        throw new NotFoundHttpException("Unable to resolve requested path '".$requestPath."'.");
    }

    /**
     * prepand the base url for the provided alias.
     *
     * @param string $alias
     * @return string
     */
    public function buildItemLink($alias, $langShortCode)
    {
        return Yii::$app->getUrlManager()->prependBaseUrl($this->composition->prependTo($alias, $this->composition->createRouteEnsure(['langShortCode' => $langShortCode])));
    }
    
    /**
     * Return all nav item modules to request data later in items
     *
     * @return array An array with all modules index by the id
     */
    public function getModulesMap()
    {
        if ($this->_modulesMap === null) {
            $this->_modulesMap = NavItemModule::find()->select(['module_name', 'id'])->indexBy('id')->asArray()->all();
        }
        
        return $this->_modulesMap;
    }

    /**
     * load all navigation items for a specific language id.
     *
     * @param int $langId
     */
    private function getNavData($langId)
    {
        return (new DbQuery())->from(['cms_nav_item item'])
        ->select(['item.id', 'item.nav_id', 'item.title', 'item.description', 'item.keywords', 'item.alias', 'item.timestamp_create', 'item.timestamp_update', 'item.create_user_id', 'item.update_user_id', 'nav.is_home', 'nav.parent_nav_id', 'nav.sort_index', 'nav.is_hidden', 'item.nav_item_type', 'item.nav_item_type_id', 'nav_container.alias AS container'])
        ->leftJoin('cms_nav nav', 'nav.id=item.nav_id')
        ->leftJoin('cms_nav_container nav_container', 'nav_container.id=nav.nav_container_id')
        ->where(['nav.is_deleted' => 0, 'item.lang_id' => $langId, 'nav.is_offline' => 0, 'nav.is_draft' => 0])
        ->orderBy(['container' => 'ASC', 'parent_nav_id' => 'ASC', 'nav.sort_index' => 'ASC'])
        ->indexBy('id')
        ->all();
    }
        
    private $_paths = [];
    
    private $_nodes = [];
    
    /**
     * Helper method to build an index with all the alias paths to build the correct links.
     *
     * @param array $data
     * @return array An array with the index where the key is the nav_id
     */
    private function buildIndexForContainer($data)
    {
        $this->_paths = [];
        $this->_nodes = [];
        
        foreach ($data as $item) {
            $this->_nodes[$item['nav_id']] = ['parent_nav_id' => $item['parent_nav_id'], 'alias' => $item['alias'], 'nav_id' => $item['nav_id']];
        }
        
        foreach ($this->_nodes as $node) {
            $this->_paths[$node['nav_id']] = $this->processParant($node['nav_id'], null);
        }
        
        return $this->_paths;
    }
     
    private function processParant($nodeId, $path)
    {
        $parentId = $this->_nodes[$nodeId]['parent_nav_id'];
        $alias = $this->_nodes[$nodeId]['alias'];
    
        if ($parentId > 0 && array_key_exists($parentId, $this->_nodes)) {
            return $this->processParant($parentId, $path) . '/' . $alias;
        }
    
        return $alias;
    }

    /**
     * helper method to see if the request url can be found in the active container.
     *
     * @param array $urlParts
     */
    private function aliasMatch(array $urlParts)
    {
        return (new MenuQuery())->where(['alias' => implode('/', $urlParts)])->with('hidden')->one();
    }

    /**
     * Helper method to load all contaienr data for a specific langauge.
     *
     * @param string $langShortCode e.g. de
     * @throws Exception
     * @return array
     */
    private function loadLanguageContainer($langShortCode)
    {
        $cacheKey = $this->cachePrefix.$langShortCode;
        
        $languageContainer = $this->getHasCache($cacheKey);
        
        if ($languageContainer === false) {
            $lang = $this->getLanguage($langShortCode);
    
            if (!$lang) {
                throw new NotFoundHttpException(sprintf("The requested language '%s' does not exist in language table", $langShortCode));
            }
    
            $data = $this->getNavData($lang['id']);
    
            $index = $this->buildIndexForContainer($data);
    
            $languageContainer = [];
    
            // $key = cms_nav_item.id (as of indexBy('id'))
            foreach ($data as $key => $item) {
                $alias = $item['alias'];
    
                if ($item['parent_nav_id'] > 0 && array_key_exists($item['parent_nav_id'], $index)) {
                    $alias = $index[$item['parent_nav_id']].'/'.$item['alias'];
                }
    
                $languageContainer[$key] = [
                    'id' => $item['id'],
                    'nav_id' => $item['nav_id'],
                    'lang' => $lang['short_code'],
                    'link' => $this->buildItemLink($alias, $langShortCode),
                    'title' => $item['title'],
                    'alias' => $alias,
                    'description' => $item['description'],
                    'keywords' => $item['keywords'],
                    'create_user_id' => $item['create_user_id'],
                    'update_user_id' => $item['update_user_id'],
                    'timestamp_create' => $item['timestamp_create'],
                    'timestamp_update' => $item['timestamp_update'],
                    'is_home' => $item['is_home'],
                    'parent_nav_id' => $item['parent_nav_id'],
                    'sort_index' => $item['sort_index'],
                    'is_hidden' => $item['is_hidden'],
                    'type' => $item['nav_item_type'],
                    'nav_item_type_id' => $item['nav_item_type_id'],
                    'redirect' => ($item['nav_item_type'] == 3 && isset($this->redirectMap[$item['nav_item_type_id']])) ? $this->redirectMap[$item['nav_item_type_id']] : false,
                    'module_name' => ($item['nav_item_type'] == 2 && isset($this->modulesMap[$item['nav_item_type_id']])) ? $this->modulesMap[$item['nav_item_type_id']]['module_name'] : false,
                    'container' => $item['container'],
                    'depth' => count(explode('/', $alias)),
                ];
            }
            
            $this->setHasCache($cacheKey, $languageContainer);
        }
        
        return $languageContainer;
    }
    
    public function injectItem(InjectItem $item)
    {
        $this->_languageContainer[$item->getLang()][$item->getId()] = $item->toArray();
    }
    
    /**
     * Flush all caching data for the menu for each language
     */
    public function flushCache()
    {
        foreach ($this->getLanguages() as $lang) {
            $this->deleteHasCache($this->cachePrefix . $lang['short_code']);
        }
    }
}
