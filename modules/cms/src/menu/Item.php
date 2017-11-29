<?php

namespace luya\cms\menu;

use Yii;
use luya\admin\models\User;
use luya\cms\Exception;
use luya\cms\models\Nav;
use luya\web\LinkInterface;
use luya\web\LinkTrait;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\BaseObject;

/**
 * Menu item Object.
 *
 * Each menu itaration will return in an Item-Object. The Item-Object contains several methods like
 * returning title, url and ids or retrieve depending item iterations like parents or childs. As the
 * Item Object extends the {{yii\base\BaseObject}} all getter methods can be access as property.
 *
 * Read more in the [[app-menu.md]] Guide.
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
 * @property \luya\admin\models\User $userCreated Returns an active record object for the admin user who created this page.
 * @property \luya\admin\models\User $userUpdated Returns an active record object for the admin user who last time updated this page.
 * @property string $link  Returns the current item link relative path with composition (language). The path is always relativ to the host.
 * @property boolean $isActive Returns a boolean value whether the current item is an active link or not, this is also for all parent elements. If a child item is active, the parent element is activ as well.
 * @property integer $depth Returns the depth of the navigation tree start with 1. Also known as menu level.
 * @property object $parent Returns a Item-Object of the parent element, if no parent element exists returns false.
 * @property array $parents Return all parent elements **without** the current item.
 * @property array $sibilings Get all sibilings for the current item, this also includes the current item iteself.
 * @property array $teardown Return all parent elemtns **with** the current item.
 * @property \luya\cms\menu\QueryIterator $children Get all children of the current item. Children means going the depth/menulevel down e.g. from 1 to 2.
 * @property boolean $isHome Returns true if the item is the home item, otherwise false.
 * @property string $absoluteLink The link path with prepand website host `http://luya.io/home/about-us`.
 * @property integer $sortIndex Sort index position for the current siblings list.
 * @property boolean $hasChildren Check whether an item has childrens or not returning a boolean value.
 * @property boolean $hasParent Check whether the parent has items or not.
 * @property string $seoTitle Returns the Alternative SEO-Title. If entry is empty, the $title will returned instead.
 * @property \luya\cms\menu\Item|boolean $nextSibling Returns the next sibling based on the current sibling, if not found false is returned.
 * @property \luya\cms\menu\Item|boolean $prevSibling Returns the previous sibling based on the current sibling, if not found false is returned.
 * @property \luya\cms\models\Nav|boolean $model Returns the {{\luya\cms\models\Nav}} object for the current navigation item.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Item extends BaseObject implements LinkInterface, Arrayable
{
    use LinkTrait, ArrayableTrait;
    
    /**
     * @var array The item property containing the informations with key  value parinings. This property will be assigned when creating the
     * Item-Object.
     */
    public $itemArray;

    /**
     * @var string|null Can contain the language context, so the sub querys for this item will be the same language context
     * as the parent object which created this object.
     */
    public $lang;
    
    /**
     * @var array Privat property containing with informations for the Query Object.
     */
    private $_with = [];

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ['href', 'target'];
    }
    
    /**
     * @inheritdoc
     */
    public function getHref()
    {
        return $this->getLink();
    }
    
    private $_target;
    
    /**
     * Setter method for the link target.
     *
     * @param string $target
     */
    public function setTarget($target)
    {
        $this->_target = $target;
    }
    
    /**
     * @inheritdoc
     */
    public function getTarget()
    {
        return empty($this->_target) ? '_self' : $this->_target;
    }
    
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
     * Get the sorting index position for the item on the current siblings.
     *
     * @return integer Sort index position for the current siblings list.
     */
    public function getSortIndex()
    {
        return (int) $this->itemArray['sort_index'];
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
     * Whether current item is home or not.
     *
     * @return boolean Returns true if the item is the home item, otherwise false.
     */
    public function getIsHome()
    {
        return (bool) $this->itemArray['is_home'];
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
     * Returns the Alternative SEO-Title.
     *
     * If no SEO-Title is given, the page title from {{luya\cms\menu\Item::getTitle}} will be returned instead.
     *
     * @return string Return the SEO-Title, if empty the {{luya\cms\menu\Item::getTitle}} will be returned instead.
     */
    public function getSeoTitle()
    {
        return empty($this->itemArray['title_tag']) ? $this->title : $this->itemArray['title_tag'];
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
     */
    public function getModuleName()
    {
        if ($this->getType() === 2) {
            return $this->itemArray['module_name'];
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

    private $_keywords;
    
    private $_delimiters = [',', ';', '|'];
    
    /**
     * @return array An array with all keywords for this page
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
     * @return \luya\admin\models\User|boolean Returns an ActiceRecord for the admin user who created the page, if not
     * found the return value is false.
     */
    public function getUserCreated()
    {
        return User::findOne($this->itemArray['create_user_id']);
    }
    
    /**
     * Returns an active record object for the admin user who last time updated this page.
     *
     * @return \luya\admin\models\User|boolean Returns an ActiceRecord for the admin user who last time updated this page, if not
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
     * Hidden links will be returned from getLink. So if you make a link
     * from a page to a hidden page, the link of the hidden page will be returned and the link
     * will be successfully displayed
     *
     * @return string The link path `/home/about-us` or with composition `/de/home/about-us`
     */
    public function getLink()
    {
        // take care of redirect
        if ($this->getType() === 3) {
            switch ($this->redirectMapData('type')) {
                case 1:
                    $navId = $this->redirectMapData('value');
                    if (empty($navId) || $navId == $this->navId) {
                        return null;
                    }
                    return (($item = (new Query())->where(['nav_id' => $navId])->with(['hidden'])->lang($this->lang)->one())) ? $item->getLink() : null;
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
     * Returns the link with an absolute scheme.
     *
     * The link with an absolute scheme path example `http://luya.io/link` where link is the output
     * from the {{luya\cms\menu\item::getLink}} method.
     *
     * @return string The link path with prepand website host `http://luya.io/home/about-us`.
     */
    public function getAbsoluteLink()
    {
        return Yii::$app->request->hostInfo . $this->getLink();
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
     * Check whether the parent has items or not.
     *
     * @return boolean
     */
    public function getHasParent()
    {
        $parent = $this->getParent();
        return ($parent && count($parent) > 0) ? true : false;
    }
    
    /**
     * Returns a Item-Object of the parent element, if no parent element exists returns false.
     *
     * @return \luya\cms\menu\Item|bool Returns the parent item-object or false if not exists.
     */
    public function getParent()
    {
        return (new Query())->where(['nav_id' => $this->parentNavId, 'container' => $this->getContainer()])->with($this->_with)->lang($this->lang)->one();
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
     */
    public function getSiblings()
    {
        return (new Query())->where(['parent_nav_id' => $this->parentNavId, 'container' => $this->container])->with($this->_with)->lang($this->lang)->all();
    }
    
    /**
     * Get the next sibling in the current siblings list.
     *
     * If there is no next sibling (assuming its the last sibling item in the list) false is returned, otherwise the {{luya\cms\menu\Item}} is returned.
     *
     * @return \luya\cms\menu\Item|boolean Returns the next sibling based on the current sibling, if not found false is returned.
     */
    public function getNextSibling()
    {
        return (new Query())->where(['parent_nav_id' => $this->parentNavId, 'container' => $this->container])->andWhere(['>', 'sort_index', $this->sortIndex])->with($this->_with)->lang($this->lang)->one();
    }
    
    /**
     * Get the previous sibling in the current siblings list.
     *
     * If there is no previous sibling (assuming its the first sibling item in the list) false is returned, otherwise the {{luya\cms\menu\Item}} is returned.
     *
     * @return \luya\cms\menu\Item|boolean Returns the previous sibling based on the current sibling, if not found false is returned.
     */
    public function getPrevSibling()
    {
        return (new Query())->where(['parent_nav_id' => $this->parentNavId, 'container' => $this->container])->andWhere(['<', 'sort_index', $this->sortIndex])->with($this->_with)->lang($this->lang)->one();
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
    
    /**
     * Get all children of the current item. Children means going the depth/menulevel down e.g. from 1 to 2.
     *
     * @return \luya\cms\menu\QueryIterator Returns all children
     */
    public function getChildren()
    {
        return (new Query())->where(['parent_nav_id' => $this->navId, 'container' => $this->getContainer()])->with($this->_with)->lang($this->lang)->all();
    }
    
    /**
     * Check whether an item has childrens or not returning a boolean value.
     *
     * @return bool If there are childrens the method returns true, otherwhise false.
     */
    public function getHasChildren()
    {
        return count($this->getChildren()) > 0 ? true : false;
    }
    
    private $_model;
    
    /**
     * Get the ActiveRecord Model for the current Nav Model.
     *
     * @throws \luya\cms\Exception
     * @return \luya\cms\models\Nav Returns the {{\luya\cms\models\Nav}} object for the current navigation item.
     */
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = Nav::findOne($this->navId);
            
            if (empty($this->_model)) {
                throw new Exception('The model active record could not be found for the corresponding nav item. Maybe you have inconsistent Database data.');
            }
        }
        
        return $this->_model;
    }
    
    /**
     * Setter method for the Model.
     *
     * @param null|\luya\cms\models\Nav $model The Nav model Active Record
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }
    
    /**
     * Get Property Object.
     *
     * This method allows you the retrieve a property for an page property. If the property is not found false will be retunrend
     * otherwhise the property object itself will be returned {{luya\\admin\base\Property}} so you can retrieve the value of the
     * property by calling your custom method or the default `getValue()` method.
     *
     * In order to return the value, which is mostly the case, use: {{luya\cms\menu\Item::getPropertyValue}}
     *
     * @param string $varName The variable name of the property defined in the method {{luya\\admin\base\Property::varName}}
     * @return \luya\admin\base\Property
     */
    public function getProperty($varName)
    {
        return $this->model->getProperty($varName);
    }

    /**
     * Get the value of a Property Object.
     *
     * Compared to {{luya\cms\menu\Item::getProperty}} this method returns only the value for a given property. If the
     * property is not assigned for the current Menu Item the $defaultValue will be returned, which is null by default.
     *
     * @param string $varName The variable name of the property defined in the method {{luya\\admin\base\Property::varName}}
     * @param mixed $defaultValue The default value which will be returned if the property is not set for the current page.
     * @return string|mixed Returns the value of {{luya\admin\base\Property::getValue}} if set, otherwise $defaultValue.
     */
    public function getPropertyValue($varName, $defaultValue = null)
    {
        return $this->getProperty($varName) ? $this->getProperty($varName)->getValue() : $defaultValue;
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
     * if ($item->with(['hidden'])->hasChildren) {
     *     print_r($item->getChildren());
     * }
     * ```
     *
     * The above example display also hidden pages.
     *
     * @see \luya\cms\menu\Query::with()
     * @return \luya\cms\menu\Item;
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
     * @return \luya\cms\menu\Item
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
