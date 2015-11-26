<?php

namespace cmsadmin\components;

/**
 * @TODO deltete this class, use other class to load
 *
 * @author nadar
 */
class Menu
{
    private $menu = [];
    private $container = [];
    private $lang = [];

    public function __construct()
    {
    }

    public function setContainerByAlias($containerAlias)
    {
        $this->container = (new \yii\db\Query())->select(['id'])->from('cms_nav_container')->where(['alias' => $containerAlias])->one();
    }

    public function setContainerById($containerId)
    {
        $this->container = (new \yii\db\Query())->select(['id'])->from('cms_nav_container')->where(['id' => $containerId])->one();
    }

    public function setLangByShortCode($langShortCode)
    {
        $this->lang = (new \yii\db\Query())->select(['id', 'short_code'])->from('admin_lang')->where(['short_code' => $langShortCode])->one();
    }

    public function all()
    {
        return $this->menu;
    }

    public function children($parentId)
    {
        return (isset($this->menu[$parentId])) ? $this->menu[$parentId] : [];
    }

    public function childrenRecursive($parentId, $subName = '__sub')
    {
        if (empty($this->menu)) {
            $this->getFromParentNode(0);
        }
        $data = [];
        if (!isset($this->menu[$parentId])) {
            return [];
        }
        $items = $this->menu[$parentId];
        $i = 0;
        foreach ($items as $k => $v) {
            $data[$i] = $v;
            if (isset($this->menu[$v['id']])) {
                $data[$i][$subName] = $this->childrenRecursive($v['id'], $subName);
            }
            ++$i;
        }

        return $data;
    }
    /* private */

    /**
     * Creating the menu array. The first key represents the parent_id, the value represents all the
     * menu items for this parent_id.
     *
     * ```php
     * $menu = [
     *     0 => [
     *         1 => [
     *             'title' => 'Frontpage'
     *         ],
     *         2 => [
     *             'title' => 'Second Page'
     *         ]
     *     ],
     *
     *     2 => [
     *         3 => [
     *             'title' => 'Sub Page #1 of "Second Page"'
     *         ],
     *         4 => [
     *             'title' => 'Sub Page #2 of "Second Page"'
     *         ]
     *     ]
     * ]
     * ```
     *
     * @param int $node parent_nav_id value
     */
    private function getFromParentNode($parentNavId)
    {
        // get the root node of the tree
        $tree = $this->getData($parentNavId);
        // foreach all the elements, make an array entry and lookup for child nodes.
        foreach ($tree as $key => $item) {
            // see if parent exists
            if ($this->subNodeExists($item['id'])) {
                $this->getFromParentNode($item['id']);
                $item['expandable'] = true;
            } else {
                $item['expandable'] = false;
            }
            // store into array, where the array key is the id
            $this->menu[$parentNavId][$item['id']] = $item;
        }
    }

    private function subNodeExists($parentNavId)
    {
        return (new \yii\db\Query())->select('id')->from('cms_nav')->where(['parent_nav_id' => $parentNavId])->count();
    }

    private function getData($parentNavId)
    {
        return (new \yii\db\Query())
            ->select('cms_nav.id, cms_nav.is_draft, cms_nav.sort_index, cms_nav.parent_nav_id, cms_nav_item.title, cms_nav_item.alias, cms_nav.is_hidden, cms_nav.is_offline, cms_nav.is_home')
            ->from('cms_nav')
            ->leftJoin('cms_nav_item', 'cms_nav.id=cms_nav_item.nav_id')
            ->orderBy('cms_nav.sort_index ASC')
            ->where(['parent_nav_id' => $parentNavId, 'nav_container_id' => $this->container['id'], 'cms_nav_item.lang_id' => $this->lang['id'], 'cms_nav.is_deleted' => 0])
            ->all();
    }
}
