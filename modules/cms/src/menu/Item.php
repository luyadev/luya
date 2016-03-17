<?php

namespace cms\menu;

use Yii;
use Exception;
use admin\models\User;
use cmsadmin\models\NavItemModule;

/**
 * Menu item Object.
 * 
 * Each menu itaration will return in an Item-Object. The Item-Object contains several methods like
 * returning title, url and ids or retrieve depending item iterations like parents or childs. As the
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
    public $itemArray = null;

    /**
     * @var string|null Can contain the language context, so the sub querys for this item will be the same language context
     * as the parent object which created this object.
     */
    public $lang = null;
    
    /**
     * @var array Privat property containing with informations for the
     *            Query Object.
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
        return $this->itemArray['id'];
    }

    public function getIsHidden()
    {
        return (bool) $this->itemArray['is_hidden'];
    }
    
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
    
    public function setTitle($title)
    {
        return $this->itemArray['title'] = $title;
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
            $module = NavItemModule::find()->select(['module_name'])->where(['id' => $this->itemArray['nav_item_type_id']])->asArray()->one();
            if ($module) {
                return $module['module_name'];
            }
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
     * @return string e.g. "/home/about-us" or with composition "/de/home/about-us"
     */
    public function getLink()
    {
        // take care of redirect
        if ($this->getType() === 3) {
            switch ($this->redirectMapData('type')) {
                case 1:
                    return (($item = (new Query())->where(['nav_id' => $this->redirectMapData('value')])->with($this->_with)->lang($this->lang)->one())) ? $item->getLink() : null;
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
            $this->_parent = (new Query())->where(['nav_id' => $this->parentNavId])->with($this->_with)->lang($this->lang)->one();
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
        $parent = $this->getParent();
        $data = [];
        while ($parent) {
            $data[] = $parent;
            $parent = $parent->getParent();
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
        return (new Query())->where(['parent_nav_id' => $this->getParentNavId()])->with($this->_with)->lang($this->lang)->all();
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

    private $_children = null;
    
    /**
     * Get all children of the current item. Children means going the depth/menulevel down e.g. from 1 to 2.
     * 
     * @return \cms\menu\QueryIterator Returns all children
     */
    public function getChildren()
    {
        if ($this->_children === null) {
            $this->_children = (new Query())->where(['parent_nav_id' => $this->navId])->with($this->_with)->lang($this->lang)->all();
        }
        
        return $this->_children;
    }

    /**
     * Check whether an item has childrens or not returning a boolean value.
     *
     * @return bool If there are childrens the method returns true, otherwhise false.
     */
    public function hasChildren()
    {
        return ($this->getChildren()) ? true : false;
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
