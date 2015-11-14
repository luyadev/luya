<?php

namespace cms\menu;

use Yii;

/**
 * Menu item Object.
 * 
 * Each menu itarition will return in an Item-Object. The Item-Object contains several methods like
 * returning title, url and ids or retrieve depending item irations like parents or childs. As the
 * Item Object extends the yii\base\Object all getter methods can be access as property.
 *
 * @author nadar
 *
 * @since 1.0.0-beta1
 */
class Item extends \yii\base\Object
{
    /**
     * @var array The item property containing the informations with key
     *            value parinings. This property will be assigned when creating the
     *            Item-Object.
     */
    public $itemArray = [];

    /**
     * @var array Privat property containing with informations for the
     *            Query Object.
     */
    private $_with = [];

    /**
     * Get the Id of the Item, the Id is an unique identifiere an represents the
     * id column in the cms_nav_item table.
     *
     * @return int
     */
    public function getId()
    {
        return $this->itemArray['id'];
    }

    /**
     * Get the Nav-id of the Item, the Nav-Id is not unique but in case of the language
     * container the nav id is unique. The Nav-Id identifier repersents the id coluumn
     * of the cms_nav table.
     * 
     * @return int
     */
    public function getNavId()
    {
        return $this->itemArray['nav_id'];
    }

    /**
     * Get the parent_nav_id of the current item. If the current Item-Object belongs to a
     * parent navigation item, the getParentNavId() method returns the getNavId() of the parent
     * item.
     * 
     * ```
     * .
     * ├── item (navId 1)
     * └── item (navId 2)
     *     ├── item (navId 3 with parentNavId 2)
     *     └── item (navId 4 with parentNavId 2)
     * ```
     * 
     * @return int
     */
    public function getParentNavId()
    {
        return $this->itemArray['parent_nav_id'];
    }

    /**
     * Returns the current Title of the Menu Item.
     * 
     * @return string e.g. "Hello World"
     */
    public function getTitle()
    {
        return $this->itemArray['title'];
    }

    /**
     * Returns the current alias name of the item (identifier for the url)
     * also (& previous) called rewrite.
     * 
     * @return string e.g. "hello-word"
     */
    public function getAlias()
    {
        return $this->itemArray['alias'];
    }

    /**
     * Returns the current item link relative path with composition (language). The
     * path is always relativ to the host.
     * 
     * @return string e.g. "/home/about-us" or with composition "/de/home/about-us"
     */
    public function getLink()
    {
        return ($this->itemArray['is_home'] && Yii::$app->composition->defaultLangShortCode == $this->itemArray['lang']) ? Yii::$app->urlManager->baseUrl : $this->itemArray['link'];
    }

    /**
     * Returns a boolean value whether the current item is an active link or not, this
     * is also for all parent elements. If a child item is active, the parent element
     * is activ as well.
     * 
     * @return bool
     */
    public function getIsActive()
    {
        return array_key_exists($this->id, Yii::$app->menu->current->teardown);
    }

    /**
     * Returns the depth of the navigation tree start with 1. Also known as menu level.
     * 
     * @return int
     */
    public function getDepth()
    {
        return $this->itemArray['depth'];
    }

    /**
     * Returns a Item-Object of the parent element, if no parent element exists returns false.
     * 
     * @return \cms\menu\Item|bool Returns the parent item-object or false if not exists.
     */
    public function getParent()
    {
        return (new Query())->where(['nav_id' => $this->parentNavId])->with($this->_with)->one();
    }

    /**
     * Return all parent elements **without** the current item.
     *
     * @return array An array with Item-Objects.
     */
    public function getParents()
    {
        $parent = $this->getParent();
        $data = [];
        while ($parent) {
            $data[] = $parent;
            $parent = $parent->getParent();
        }

        return array_reverse($data);
    }

    /**
     * Return all parent elemtns **with** the current item.
     * 
     * @return array An array with Item-Objects.
     */
    public function getTeardown()
    {
        $parent = $this->getParent();
        $current = $this;
        $data[$current->id] = $current;
        while ($parent) {
            $data[$parent->id] = $parent;
            $parent = $parent->getParent();
        }

        return array_reverse($data, true);
    }

    /**
     * Get all children of the current item. Children means going the depth/menulevel down e.g. from 1 to 2.
     * 
     * @return \cms\menu\QueryIterator Returns all children
     */
    public function getChildren()
    {
        return (new Query())->where(['parent_nav_id' => $this->navId])->with($this->_with)->all();
    }

    /**
     * Check whether an item has childrens or not returning a boolean value.
     *
     * @return bool If there are childrens the method returns true, otherwhise false.
     */
    public function hasChildren()
    {
        return ((new Query())->where(['parent_nav_id' => $this->navId])->with($this->_with)->one()) ? true : false;
    }

    /**
     * You can use with() before the following methods:
     * - getParent()
     * - getParents()
     * - getTeardown()
     * - getChildren()
     * - hasChildren().
     * 
     * @see \cms\menu\Query::with()
     *
     * @return \cms\menu\Item;
     */
    public function with($with)
    {
        $this->_with = (array) $with;

        return $this;
    }
}
