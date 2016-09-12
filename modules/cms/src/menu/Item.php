<?php

namespace luya\cms\menu;

use Yii;
use luya\cms\Exception;
use luya\admin\models\User;
use luya\cms\models\Nav;

/**
 * Menu item Object.
 *
 * Each menu itaration will return in an Item-Object. The Item-Object contains several methods like
 * returning title, url and ids or retrieve depending item iterations like parents or childs. As the
 * Item Object extends the yii\base\Object all getter methods can be access as property.
 *
 * @property integer $id Returns Unique identifier of item, represents data record of cms_nav_item table.
 * @property boolean $isHidden Returns boolean state of visbility.
 * @property string $container Returns the container name.
 * @property integer $navId Returns the Navigation Id which is not unique but is used for the menu tree
 * @property integer $parentNavId Returns the parent navigation id of this item (0 = root level).
 * @property string $title Returns the title of this page
 * @property integer $type Returns the type of page 1=Page with blocks, 2=Module, 3=Redirect
 * @property string $moduleName Returns the name of the module if its of type module(2)
 * @property string $description Returns the page description (used for making meta key description).
 * @property array $keywords Returns an array of user defined keywords for this page (user to generate meta keywords)
 * @property string $alias Returns the alias name of this page.
 * @property integer $dateCreated Returns an unix timestamp when the page was created.
 * @property integer $dateUpdated Returns an unix timestamp when the page was last time updated.
 * @property object $userCreated Returns an active record object for the admin user who created this page.
 * @property object $userUpdated Returns an active record object for the admin user who last time updated this page.
 * @property string $link  Returns the current item link relative path with composition (language). The path is always relativ to the host.
 * @property boolean $isActive Returns a boolean value whether the current item is an active link or not, this is also for all parent elements. If a child item is active, the parent element is activ as well.
 * @property integer $depth Returns the depth of the navigation tree start with 1. Also known as menu level.
 * @property object $parent Returns a Item-Object of the parent element, if no parent element exists returns false.
 * @property array $parents Return all parent elements **without** the current item.
 * @property array $sibilings Get all sibilings for the current item, this also includes the current item iteself.
 * @property array $teardown Return all parent elemtns **with** the current item.
 * @property array $children Get all children of the current item. Children means going the depth/menulevel down e.g. from 1 to 2.
 *
 * @author nadar
 * @since 1.0.0-beta1
 */
class Item extends \yii\base\Object
{
    /**
     * @var array The item property containing the informations with key  value parinings. This property will be assigned when creating the
     * Item-Object.
     */
    public $itemArray = null;

    /**
     * @var string|null Can contain the language context, so the sub querys for this item will be the same language context
     * as the parent object which created this object.
     */
    public $lang = null;
    
    /**
     * @var array Privat property containing with informations for the Query Object.
     */
    private $_with = [];

    /**
     * Item-Object initiliazer, verify if the itemArray property is empty.
     *
     * @throws Exception
     */
    public function init()
    {
        if ($this->itemArray === null) {
            throw new Exception('The itemArray property can not be null.');
        }
        // call parent object initializer
        parent::init();
    }
    
    /**
     * Get the Id of the Item, the Id is an unique identifiere an represents the
     * id column in the cms_nav_item table.
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->itemArray['id'];
    }

    /**
     * Whether the item is hidden or not if hidden items can be retreived (with/without settings).
     *
     * @return boolean
     */
    public function getIsHidden()
    {
        return (bool) $this->itemArray['is_hidden'];
    }
    
    /**
     * Override the default hidden state of an item.
     *
     * @param boolean $value True or False depending on the visbility of the item.
     */
    public function setIsHidden($value)
    {
        $this->itemArray['is_hidden'] = (int) $value;
    }
    
    /**
     * Return the current container name of this item.
     *
     * @return string Return alias name of the container
     */
    public function getContainer()
    {
        return $this->itemArray['container'];
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
        return (int) $this->itemArray['nav_id'];
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
        return (int) $this->itemArray['parent_nav_id'];
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
     * Override the current title of item.
     *
     * @param string $title The title to override of the existing.
     */
    public function setTitle($title)
    {
        $this->itemArray['title'] = $title;
    }
    
    /**
     * Return the current nav item type by number.
     *
     * + 1 = Page with blocks
     * + 2 = Module
     * + 3 = Redirect
     *
     * @return int The type number
     */
    public function getType()
    {
        return (int) $this->itemArray['type'];
    }
    
    /**
     * If the type of the item is equals 2 we can detect the module name and returns
     * this information.
     *
     * @return boolean|string The name of the module or false if not found or wrong type
     * @since 1.0.0-beta5
     */
    public function getModuleName()
    {
        if ($this->getType() === 2) {
            return $this->itemArray['module_name'];
            /*
            if (isset($this->itemArray['nav_item_type_id'], Yii::$app->menu->modulesMap)) {
                return Yii::$app->menu->modulesMap[$this->itemArray['nav_item_type_id']]['module_name'];
            }
            */
        }
        
        return false;
    }
    
    /**
     * Returns the description provided by the cms admin, if any.
     *
     * @return string The description string for this page.
     */
    public function getDescription()
    {
        return $this->itemArray['description'];
    }

    private $_keywords = null;
    
    private $_delimiters = [',', ';', '|'];
    
    /**
     * @return array An array with all keywords for this page
     * @since 1.0.0-beta6
     */
    public function getKeywords()
    {
        if ($this->_keywords === null) {
            if (empty($this->itemArray['keywords'])) {
                $this->_keywords = [];
            } else {
                foreach (explode($this->_delimiters[0], str_replace($this->_delimiters, $this->_delimiters[0], $this->itemArray['keywords'])) as $name) {
                    if (!empty(trim($name))) {
                        $this->_keywords[] = trim($name);
                    }
                }
            }
        }
        
        return $this->_keywords;
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
     * Returns an unix timestamp when the page was created.
     *
     * @return int Unix timestamp
     */
    public function getDateCreated()
    {
        return $this->itemArray['timestamp_create'];
    }
    
    /**
     * Returns an unix timestamp when the page was last time updated.
     *
     * @return int Unix timestamp
     */
    public function getDateUpdated()
    {
        return $this->itemArray['timestamp_update'];
    }
    
    /**
     * Returns an active record object for the admin user who created this page.
     *
     * @return \admin\models\User|boolean Returns an ActiceRecord for the admin user who created the page, if not
     * found the return value is false.
     */
    public function getUserCreated()
    {
        return User::findOne($this->itemArray['create_user_id']);
    }
    
    /**
     * Returns an active record object for the admin user who last time updated this page.
     *
     * @return \admin\models\User|boolean Returns an ActiceRecord for the admin user who last time updated this page, if not
     * found the return value is false.
     */
    public function getUserUpdated()
    {
        return User::findOne($this->itemArray['update_user_id']);
    }
    
    /**
     * Internal used to retriev redirect data if any
     * @return multitype:
     */
    protected function redirectMapData($key)
    {
        return (!empty($this->itemArray['redirect'])) ? $this->itemArray['redirect'][$key] : false;
    }

    /**
     * Returns the current item link relative path with composition (language). The
     * path is always relativ to the host.
     *
     * As changed in 1.0.0-beta6, hidden links will be returned from getLink. So if you make a link
     * from a page to a hidden page, the link of the hidden page will be returned and the link
     * will be successfully displayed
     *
     * @return string e.g. "/home/about-us" or with composition "/de/home/about-us"
     */
    public function getLink()
    {
        // take care of redirect
        if ($this->getType() === 3) {
            switch ($this->redirectMapData('type')) {
                case 1:
                    return (($item = (new Query())->where(['nav_id' => $this->redirectMapData('value')])->with(['hidden'])->lang($this->lang)->one())) ? $item->getLink() : null;
                case 2:
                    return $this->redirectMapData('value');
            }
        }
        
        if ($this->itemArray['is_home'] && Yii::$app->composition->defaultLangShortCode == $this->itemArray['lang']) {
            return Yii::$app->urlManager->prependBaseUrl('');
        }
        
        return $this->itemArray['link'];
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

    private $_parent = null;
    
    /**
     * Getter method wrapper for `hasParent()`
     *
     * @return boolean
     * @since 1.0.0-beta6
     */
    public function getHasParent()
    {
        return $this->hasParent();
    }
    
    /**
     * Check whether parent element exists or not
     *
     * @return boolean
     */
    public function hasParent()
    {
        return ($this->getParent()) ? true : false;
    }
    
    /**
     * Returns a Item-Object of the parent element, if no parent element exists returns false.
     *
     * @return \cms\menu\Item|bool Returns the parent item-object or false if not exists.
     */
    public function getParent()
    {
        if ($this->_parent === null) {
            $this->_parent = (new Query())->where(['nav_id' => $this->parentNavId, 'container' => $this->getContainer()])->with($this->_with)->lang($this->lang)->one();
        }
        
        return $this->_parent;
    }

    /**
     * Return all parent elements **without** the current item.
     *
     * @return array An array with Item-Objects.
     */
    public function getParents()
    {
        $parent = $this->with($this->_with)->getParent();
        $data = [];
        while ($parent) {
            $data[] = $parent;
            $parent = $parent->with($this->_with)->getParent();
        }

        return array_reverse($data);
    }

    /**
     * Get all sibilings for the current item, this also includes the current item iteself.
     *
     * @return array An array with all item-object siblings
     * @since 1.0.0-beta3
     */
    public function getSiblings()
    {
        return (new Query())->where(['parent_nav_id' => $this->getParentNavId(), 'container' => $this->getContainer()])->with($this->_with)->lang($this->lang)->all();
    }
    
    /**
     * Return all parent elements **with** the current item.
     *
     * @return array An array with Item-Objects.
     */
    public function getTeardown()
    {
        $parent = $this->with($this->_with)->getParent();
        $current = $this;
        $data[$current->id] = $current;
        while ($parent) {
            $data[$parent->id] = $parent;
            $parent = $parent->with($this->_with)->getParent();
        }

        return array_reverse($data, true);
    }

    private $_children = null;
    
    /**
     * Get all children of the current item. Children means going the depth/menulevel down e.g. from 1 to 2.
     *
     * @return \cms\menu\QueryIterator Returns all children
     */
    public function getChildren()
    {
        if ($this->_children === null) {
            $this->_children = (new Query())->where(['parent_nav_id' => $this->navId, 'container' => $this->getContainer()])->with($this->_with)->lang($this->lang)->all();
        }
        
        return $this->_children;
    }
    
    /**
     * Getter method wrapper for `hasChildren()`
     *
     * @since 1.0.0-beta6
     * @return boolean
     */
    public function getHasChildren()
    {
        return $this->hasChildren();
    }

    /**
     * Check whether an item has childrens or not returning a boolean value.
     *
     * @return bool If there are childrens the method returns true, otherwhise false.
     */
    public function hasChildren()
    {
        return (count($this->getChildren()) > 0) ? true : false;
    }
    
    private $_model = null;
    
    /**
     * This method allows you the retrieve a property for an page property. If the property is not found false will be retunrend
     * otherwhise the property object itself will be returned (implements `\admin\base\Property`) so you can retrieve the value of the
     * property by calling your custom method or the default `getValue()` method.
     *
     * @param string $varName The variable name of the property defined inside of the property of the method `varName()`.
     * @since 1.0.0-beta8
     */
    public function getProperty($varName)
    {
        if ($this->_model === null) {
            $this->_model = Nav::findOne($this->navId);
        }

        if (empty($this->_model)) {
            throw new Exception('The model active record could not be found for the corresponding nav item. Maybe you have inconsistent Database data.');
        }
        
        return $this->_model->getProperty($varName);
    }

    /**
     * You can use with() before the following methods:
     *
     * - getParent()
     * - getParents()
     * - getTeardown()
     * - getChildren()
     * - hasChildren().
     *
     * Example use of with in subquery of the current item:
     *
     * ```php
     * if ($item->with(['hidden'])->hasChildren()) {
     *     print_r($item->getChildren());
     * }
     * ```
     *
     * The above example display also hidden pages.
     *
     * @see \cms\menu\Query::with()
     * @return \cms\menu\Item;
     */
    public function with($with)
    {
        $this->_with = (array) $with;

        return $this;
    }
    
    /**
     * Unset a value from the `with()` method. Lets assume you want to to get the children with hidden
     *
     * ```php
     * foreach ($item->with('hidden')->children as $child) {
     *     // but get the sibilings without the hidden state
     *     $siblings = $child->without('hidden')->siblings;
     * }
     * ```
     *
     * @param string|array $without Can be a string `hidden` or an array `['hidden']`.
     * @return \cms\menu\Item
     */
    public function without($without)
    {
        $without = (array) $without;
        
        foreach ($without as $expression) {
            $key = array_search($expression, $this->_with);
            if ($key !== false) {
                unset($this->_with[$key]);
            }
        }
        
        return $this;
    }
}
