<?php

namespace cms\components;

use Exception;
use Yii;
use yii\db\Query as DbQuery;
use cms\menu\Query as MenuQuery;

/**
 * Menu Component.
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
 *
 * @since 1.0.0-beta1
 *
 * @author nadar
 */
class Menu extends \yii\base\Component
{
    public $request = null;

    private $_composition = null;

    private $_current = null;

    private $_currentAppendix = null;

    private $_containerData = null;

    /**
     * Class constructor uses yii di container.
     * 
     * @param \yii\web\Request             $request
     * @param \luya\components\Composition $composition
     * @param array                        $config
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
            $this->_containerData = $data = $this->loadContainerData();
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

    private function buildItemLink($alias)
    {
        return Yii::$app->getUrlManager()->prependBaseUrl($this->composition->prependTo($alias));
    }

    private function loadContainerData()
    {
        $container = [];

        $redirectMap = (new DbQuery())->select(['id', 'type', 'value'])->from('cms_nav_item_redirect')->indexBy('id')->all();

        foreach ((new DbQuery())->select(['short_code', 'id'])->from('admin_lang')->all() as $lang) {
            $data = (new DbQuery())->from(['cms_nav_item item'])
            ->select(['item.id', 'item.nav_id', 'item.title', 'item.alias', 'nav.is_home', 'nav.parent_nav_id', 'nav.sort_index', 'nav.is_hidden', 'item.nav_item_type', 'item.nav_item_type_id', 'nav_container.alias AS container'])
            ->leftJoin('cms_nav nav', 'nav.id=item.nav_id')
            ->leftJoin('cms_nav_container nav_container', 'nav_container.id=nav.nav_container_id')
            ->where(['nav.is_deleted' => 0, 'item.lang_id' => $lang['id'], 'nav.is_offline' => 0])
            ->orderBy(['container' => 'ASC', 'parent_nav_id' => 'ASC', 'nav.sort_index' => 'ASC'])
            ->indexBy('id')
            ->all();

            $index = [];

            foreach ($data as $item) {
                if (!array_key_exists($item['nav_id'], $index)) {
                    if ($item['parent_nav_id'] > 0 && array_key_exists($item['parent_nav_id'], $index)) {
                        $alias = $index[$item['parent_nav_id']].'/'.$item['alias'];
                    } else {
                        $alias = $item['alias'];
                    }
                    $index[$item['nav_id']] = $alias;
                }
            }

            array_walk($data, function (&$item, $key) use ($index, $redirectMap, $lang) {
                // concate alias link from parent nav ids
                if ($item['parent_nav_id'] > 0 && array_key_exists($item['parent_nav_id'], $index)) {
                    $alias = $index[$item['parent_nav_id']].'/'.$item['alias'];
                } else {
                    $alias = $item['alias'];
                }

                // add link key
                $item['lang'] = $lang['short_code'];
                $item['alias'] = $alias;
                $item['link'] = $this->buildItemLink($alias);
                $item['depth'] = count(explode('/', $alias));
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

        $urlParts = explode('/', $requestPath);

        $item = $this->aliasMatch($urlParts);

        if (!$item) {
            while (array_pop($urlParts)) {
                if (($item = $this->aliasMatch($urlParts)) !== false) {
                    break;
                }
            }
        }

        if (!$item) {
            $this->_currentAppendix = $requestPath;

            return $this->home;
        }

        $this->_currentAppendix = substr($requestPath, strlen($item->alias) + 1);

        return $item;
    }

    private function aliasMatch(array $urlParts)
    {
        return (new MenuQuery(['menu' => $this]))->where(['alias' => implode('/', $urlParts)])->with('hidden')->one();
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

    /**
     * Get the current item for the provided level depth.
     * 
     * @param int $level Level menu starts with 1
     */
    public function currentLevel($level)
    {
        $i = 1;
        $parents = $this->current->with('hidden')->teardown;
        foreach ($parents as $item) {
            if ($i == $level) {
                return $item;
            }
            ++$i;
        }

        return false;
    }

    public function getHome()
    {
        return (new MenuQuery())->where(['is_home' => '1'])->with('hidden')->one();
    }

    public function find()
    {
        return (new MenuQuery());
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
