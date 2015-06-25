<?php

namespace cms\components;

use Yii;
use \cmsadmin\models\Nav;
use \cmsadmin\models\Cat;

class Links extends \yii\base\Component
{
    private $links = [];
    
    public $loadIsHidden = false;
    
    private $compositionPrefix = null;
    
    /* cms collection */
    
    public function init()
    {
        $this->compositionPrefix = Yii::$app->composition->getFull();
        $this->loadData();
        foreach ($this->urls as $k => $args) {
            $this->addLink($k, $args);
        }
    }
    
    private $urls = [];
    
    public function loadData()
    {
        $this->iteration(0, '', 0);
    }
    
    private function iteration($parentNavId, $urlPrefix, $depth)
    {
        $tree = $this->getData($parentNavId);
        foreach ($tree as $index => $item) {
            if ($this->subNodeExists($item['id'])) {
                $this->iteration($item['id'], $urlPrefix.$item['rewrite'].'/', ($depth + 1));
            }
            if (!array_key_exists($urlPrefix.$item['rewrite'], $this->urls)) {
                $rewrite = $urlPrefix.$item['rewrite'];
                $this->urls[$rewrite] = [
                    'full_url' => $this->compositionPrefix . $rewrite,
                    'url' => $rewrite,
                    'rewrite' => $item['rewrite'],
                    'id' => (int) $item['id'],
                    'parent_nav_id' => (int) $parentNavId,
                    'nav_item_id' => (int) $item['nav_item_id'],
                    'title' => $item['title'],
                    'lang' => $item['lang_short_code'],
                    'lang_id' => $item['lang_id'],
                    'cat' => $item['cat_rewrite'],
                    'depth' => (int) $depth,
                ];
            }
        }
    }
    
    private function getData($parentNavId)
    {
        return Nav::getItemsData($parentNavId, $this->loadIsHidden);
    }
    
    /**
     * @todo create in model cms-nav
     */
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
    
                if (isset($args[$key]) && $args[$key] != $value) {
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
    
    public function hasLink($link)
    {
        return array_key_exists($link, $this->links);
    }
    
    public function getLink($link)
    {
        return (array_key_exists($link, $this->links)) ? $this->links[$link] : false;
    }
    

    /*
    
    private $_activeLink;
    
    public function setActiveLink($activeLink)
    {
    $this->_activeLink = $activeLink;
    }
    
    public function getActiveLink()
    {
    return $this->_activeLink;
    }
    
    */
    
    public function getActiveLinkPart($part)
    {
        $parts = explode("/", $this->activeLink);
        return (array_key_exists($part, $parts)) ? $parts[$part] : null;
    }
    
    /* ------------------------------------------------------------------------- */
    
    public $activeLink = null;
    
    public function getResolveActiveLink()
    {
        if (empty($this->activeLink)) {
            $this->activeLink = $this->getDefaultLink();
        }
        return $this->activeLink;
    }
    
    /**
     * if the current active link is `http://localhost/luya-project/public_html/de/asfasdfasdfasdf/moduel-iin-seite3/foo-modul-param` where `foo-modul-param` is a param this
     * function will remove the module params and isolate the active link.
     * 
     * @param unknown $urls
     * @param unknown $parts
     * @return string|boolean
     */
    public function isolateLinkSuffix($link)
    {
        $parts = explode('/', $link);
        $parts[] = '__FIRST_REMOVAL'; // @todo remove
        
        while (array_pop($parts)) {
            $match = implode('/', $parts);
            if (array_key_exists($match, $this->getAll())) {
                return $match;
            }
        }
    
        return false;
    }
    
    /**
     * will return the opposite value of isolateLinkSuffix (module parameters e.g.)
     * @param unknown $links
     */
    public function isolateLinkAppendix($fullUrl, $suffix)
    {
        return substr($fullUrl, strlen($suffix) + 1);
    }
    
    public function getDefaultLink()
    {
        $cat = Cat::getDefault();  
        $link = $this->findOneByArguments(['id' => $cat['default_nav_id']]);
        return $link['url'];
    }

}