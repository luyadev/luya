<?php

namespace luya\cms\menu;

use Yii;
use luya\cms\Exception;
use yii\helpers\Inflector;
use luya\cms\Menu;
use yii\base\BaseObject;

/**
 * An item inject gives a module the possibility to add items into the menu Container.
 *
 * The most important propertie of the injectItem clas is the `childOf` definition, this
 * is where you have to define who is the parent *nav_item.id*.
 *
 * An item inject contain be done during the eventAfterLoad event to attach at the right
 * initializer moment of the item, but could be done any time. To inject an item use the
 * `injectItem` method on the menu Container like below:
 *
 * ```php
 * Yii::$app->menu->injectItem(new InjectItem([
 *     'childOf' => 123,
 *     'title' => 'This is the inject title',
 *     'alias' => 'this-is-the-inject-alias',
 * ]));
 * ```
 *
 * Instead of using the childOf property you can directly set an menu item:
 *
 * ```php
 * Yii::$app->menu->injectItem(new InjectItem([
 *     'item' => Yii::$app->menu->current,
 *     'title' => 'This is the inject title',
 *     'alias' => 'this-is-the-inject-alias',
 * ]));
 * ```
 *
 * You can also use the chain method to create a new inject item:
 *
 * ```php
 * $item = (new InjectItem())->setTitle('My Title')->setAlias('my Alias')->setItem(Yii::$app->menu->current);
 * ```
 *
 * To attach the item at right moment you can bootstrap your module and use the `eventAfterLoad`
 * event of the menu component:
 *
 * ```php
 * Yii::$app->menu->on(Container::MENU_AFTER_LOAD, function($event) {
 *
 *     $newItem = new InjectItem([
 *         'childOf' => 123,
 *         'title' => 'Inject Title',
 *         'alias' => 'inject-title',
 *     ]);
 *
 *     $event->sender->injectItem($newItem);
 * });
 * ```
 *
 * @property $childOf integer The child of id in order read data from this parent item.
 * @property $item \luya\cms\menu\Item The resolved Item.
 * @property $navId integer|string The navId for this inject item.
 * @property $id integer|string The id (navItemId) for this inject item.
 * @property $link string The link to the detail view.
 * @property $alias The alias path.
 * @property $title The navigation menu title.
 * @property $lang The language container name.
 * @property $description Alternative page descriptions.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class InjectItem extends BaseObject implements InjectItemInterface
{
    /**
     * @var integer The user id who created this page.
     */
    public $createUserId = 0;
    
    /**
     * @var integerThe user id who updated this page as last person.
     */
    public $updateUserId = 0;
    
    /**
     * @var integer The number which is used to sort the injected item. Lower is at the top.
     */
    public $sortIndex = 0;
    
    /**
     * @var boolean Whether this page is hidden or not.
     */
    public $isHidden = false;
    
    // Getter & Setter
    
    private $_item;

    /**
     * Returns the evalutead menu item whether from the childOf property or set from the setter method.
     * @return Item
     * @throws Exception
     */
    public function getItem()
    {
        if ($this->_item === null) {
            $this->_item = Yii::$app->menu->find()->where(['id' => $this->childOf])->with('hidden')->one();
            
            if (!$this->_item) {
                throw new Exception("Unable to find item with id " . $this->childOf);
            }
        }
        
        return $this->_item;
    }
    
    /**
     * Setter method for the item property.
     *
     * @param \luya\cms\menu\Item $item
     * @return \luya\cms\menu\InjectItem
     */
    public function setItem(Item $item)
    {
        $this->childOf = $item->id;
        $this->_item = $item;
        
        return $this;
    }
    
    private $_childOf;
    
    /**
     * Setter method for childOf property.
     *
     * @param integer $id
     * @return \luya\cms\menu\InjectItem
     */
    public function setChildOf($id)
    {
        $this->_childOf = (int) $id;
        
        return $this;
    }
    
    /**
     * Getter method for the childOf property.
     *
     * @throws Exception
     * @return number
     */
    public function getChildOf()
    {
        if ($this->_childOf === null) {
            throw new Exception("In order to inject an item, you have to set the `childOf` property.");
        }
        return $this->_childOf;
    }
    
    private $_alias;
    
    /**
     * Setter methdo for the item alias.
     *
     * @param string $alias A slugable alias string will be parsed by the inflector::slug method.
     * @return \luya\cms\menu\InjectItem
     */
    public function setAlias($alias)
    {
        $this->_alias = Inflector::slug($alias);
        
        return $this;
    }

    /**
     * Getter method for the alias.
     * @return string The alias with the parent childOf alias prefixed.
     * @throws Exception
     */
    public function getAlias()
    {
        if ($this->_alias === null) {
            throw new Exception('The $alias property can not be null and must be set.');
        }
        
        return $this->item->alias . '/' . $this->_alias;
    }
    
    private $_link;
    
    /**
     * Setter method fro the link.
     *
     * @param string $url
     * @return \luya\cms\menu\InjectItem
     */
    public function setLink($url)
    {
        $this->_link = $url;
        
        return $this;
    }
    
    /**
     * Getter method for the menu link.
     *
     * @return string The built link.
     */
    public function getLink()
    {
        return ($this->_link === null) ? Yii::$app->menu->buildItemLink($this->alias, $this->getLang()) : $this->_link;
    }
    
    private $_title;
    
    /**
     * Setter method for the menu title.
     *
     * @param string $title The menu item title.
     * @return \luya\cms\menu\InjectItem
     */
    public function setTitle($title)
    {
        // if the alias is empty use the title for the alias.
        if ($this->_alias === null) {
            $this->setAlias($title);
        }
        
        $this->_title = $title;
        
        return $this;
    }
    
    /**
     * Getter method for the menu title.
     *
     * @throws Exception
     * @return string
     */
    public function getTitle()
    {
        if ($this->_title === null) {
            throw new Exception('The $title property can not be null and must be set.');
        }
        
        return $this->_title;
    }
    
    private $_description;
    
    /**
     * Setter method for menu page description.
     *
     * @param string $description Description for the menu item.
     * @return \luya\cms\menu\InjectItem
     */
    public function setDescription($description)
    {
        $this->_description = $description;
        
        return $this;
    }
    
    /**
     * Getter method for the menu page description.
     *
     * @return string The menu item description.
     */
    public function getDescription()
    {
        return $this->_description;
    }
    
    // Getters
    
    /**
     * Getter method for the container from the child of item.
     *
     * @return integer
     */
    public function getContainer()
    {
        return $this->item->container;
    }
    
    /**
     * Returns the depth number based on the alias paths.
     *
     * @return number
     */
    public function getDept()
    {
        return count(explode('/', $this->alias));
    }
    
    private $_lang;
    
    /**
     * Returns the language from the childOf item.
     *
     * @return string
     */
    public function getLang()
    {
        if ($this->_lang === null) {
            $this->_lang = $this->item->lang;
        }
        
        return $this->_lang;
    }
    
    /**
     * Setter method for language container.
     *
     * @param string $lang The language short code for the given item, if nothing set the item will be resolved
     * due to useage of the parent item from $this->item.
     */
    public function setLang($lang)
    {
        $this->_lang = $lang;
    }
    
    /**
     * Getter method for the parent nav id from the childOf item.
     *
     * @return integer
     */
    public function getParentNavId()
    {
        return $this->item->navId;
    }
    
    /**
     * Getter method for the create item timestamp.
     *
     * @return number
     */
    public function getTimestampCreate()
    {
        return time();
    }
    
    /**
     * Getter method for the update item timestamp.
     *
     * @return number
     */
    public function getTimestampUpdate()
    {
        return time();
    }
    
    /**
     * Getter method for the isHhome item, which is false by default.
     * @return number
     */
    public function getIsHome()
    {
        return (int) false;
    }
    
    /**
     * Getter method for the type which is by default a page.
     *
     * @return number
     */
    public function getType()
    {
        return Menu::ITEM_TYPE_PAGE;
    }
    
    /**
     * Getter method for the redirect content if its a redirect page, by default 0.
     *
     * @return number
     */
    public function getRedirect()
    {
        return 0;
    }

    private $_id;
    
    /**
     * Setter methdo for the id (unique id).
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }
    
    /**
     * Getter method for the unique id.
     *
     * @return string|integer
     */
    public function getId()
    {
        if ($this->_id === null) {
            $this->_id = rand(10000, 1000000);
        }
        
        return $this->_id;
    }
    
    private $_navId;
    
    /**
     * Setter method for the navId.
     *
     * @param unknown $navId
     */
    public function setNavId($navId)
    {
        $this->_navId = $navId;
    }
    
    /**
     * Getter method for the navId.
     *
     * @return string|unknown
     */
    public function getNavId()
    {
        if ($this->_navId === null) {
            $this->_navId = rand(10000, 1000000);
        }
        return $this->_navId;
    }
    
    /**
     * Parse the injected item to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nav_id' => $this->getNavId(),
            'lang' => $this->getLang(),
            'link' => $this->getLink(),
            'title' => $this->title,
            'title_tag' => $this->title,
            'alias' => $this->getAlias(),
            'description' => $this->description,
            'keywords' => null,
            'create_user_id' => $this->createUserId,
            'update_user_id' => $this->updateUserId,
            'timestamp_create' => $this->getTimestampCreate(),
            'timestamp_update' => $this->getTimestampUpdate(),
            'is_home' => $this->getIsHome(),
            'parent_nav_id' => $this->getParentNavId(),
            'sort_index' => $this->sortIndex,
            'is_hidden' => (bool) $this->isHidden,
            'type' => $this->getType(),
            'redirect' => $this->getRedirect(),
            'container' => $this->getContainer(),
            'depth' => $this->getDept(),
        ];
    }
}
