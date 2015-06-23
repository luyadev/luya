<?php

namespace cms\components;

class Links extends \yii\base\Component
{
    private $links = [];
    
    /* cms collection */
    
    public function init()
    {
        $this->iteration(0, '', 0);
        foreach ($this->urls as $k => $args) {
            $this->addLink($k, $args);
        }
    }
    
    private $urls = [];
    
    private function iteration($parentNavId, $urlPrefix, $depth)
    {
        $tree = $this->getData($parentNavId);
        foreach ($tree as $index => $item) {
            if ($this->subNodeExists($item['id'])) {
                $this->iteration($item['id'], $urlPrefix.$item['rewrite'].'/', ($depth + 1));
            }
            $this->urls[$urlPrefix.$item['rewrite']] = [
                'url' => $urlPrefix.$item['rewrite'],
                'rewrite' => $item['rewrite'],
                'id' => (int) $item['id'],
                'parent_nav_id' => (int) $parentNavId,
                'nav_item_id' => (int) $item['nav_item_id'],
                'title' => $item['title'],
                'lang' => $item['lang_short_code'],
                'cat' => $item['cat_rewrite'],
                'depth' => (int) $depth,
            ];
        }
    }
    
    private function getData($parentNavId)
    {
        return \cmsadmin\models\Nav::getItemsData($parentNavId);
    }
    
    private function subNodeExists($parentNavId)
    {
        return (new \yii\db\Query())->select('id')->from('cms_nav')->where(['parent_nav_id' => $parentNavId])->count();
    }
    
    /* luya base collection */
    
    public function getAll()
    {
        return $this->links;
    }
    
    public function findByArguments(array $argsArray)
    {
        $_index = $this->getAll();
    
        foreach ($argsArray as $key => $value) {
            foreach ($_index as $link => $args) {
                if (!isset($args[$key])) {
                    unset($_index[$link]);
                }
    
                if (isset($args[$key]) && $args[$key] !== $value) {
                    unset($_index[$link]);
                }
            }
        }
    
        return $_index;
    }
    
    public function findOneByArguments(array $argsArray)
    {
        $links = $this->findByArguments($argsArray);
        if (empty($links)) {
            return false;
        }
    
        return array_values($links)[0];
    }
    
    public function teardown($link)
    {
        $parent = $this->getParent($link);
    
        $tears[] = $this->getLink($link);
        while ($parent) {
            $tears[] = $parent;
            $link = $parent['url'];
            $parent = $this->getParent($link);
        }
    
        $tears = array_reverse($tears);
    
        return $tears;
    }
    
    public function getParents($link)
    {
        $parent = $this->getParent($link);
    
        $tears = [];
        while ($parent) {
            $tears[] = $parent;
            $link = $parent['url'];
            $parent = $this->getParent($link);
        }
    
        $tears = array_reverse($tears);
    
        return $tears;
    }
    
    public function getParent($link)
    {
        $link = $this->getLink($link);
    
        return $this->findOneByArguments(['id' => $link['parent_nav_id']]);
    }
    
    public function getChilds($link)
    {
        $child = $this->getChild($link);
        $tears = [];
        while ($child) {
            $tears[] = $child;
            $link = $child['url'];
            $child = $this->getChild($link);
        }
    
        return $tears;
    }
    
    public function getChild($link)
    {
        $link = $this->getLink($link);
    
        return $this->findOneByArguments(['parent_nav_id' => $link['id']]);
    }
    
    public function addLink($link, $args)
    {
        $this->links[$link] = $args;
    }
    
    public function getLink($link)
    {
        return $this->links[$link];
    }
    
    private $_activeLink;
    
    public function setActiveLink($activeLink)
    {
        $this->_activeLink = $activeLink;
    }
    
    public function getActiveLink()
    {
        return $this->_activeLink;
    }
    
    public function getActiveLinkPart($part)
    {
        $parts = explode("/", $this->getActiveLink());
        return (array_key_exists($part, $parts)) ? $parts[$part] : null;
    }
}