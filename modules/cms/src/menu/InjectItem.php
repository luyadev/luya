<?php

namespace luya\cms\menu;

use Yii;
use luya\Exception;

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
 * ```
 * Yii::$app->menu->injectItem(new InjectItem([
 *     'childOf' => 123,
 *     'title' => 'This is the inject title',
 *     'alias' => 'this-is-the-inject-alias',
 * ]));
 * ```
 *
 * To attach the item at right moment you can bootstrap your module and use the `eventAfterLoad`
 * event of the menu component:
 *
 * ```
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
 * @todo create item interface
 * @author nadar
 * @since 1.0.0-beta5
 */
class InjectItem extends \yii\base\Object
{
    public $childOf = null;
    
    public $title = null;
    
    public $alias = null;
    
    public $link = null;
    
    public $description = null;
    
    public $createUserId = 0;
    
    public $updateUserId = 0;
    
    public $sortIndex = 0;
    
    public $isHidden = false;
    
    private $_menu = null;
    
    private $_menuItem = null;
    
    private $_id = null;
    
    private $_navId = null;
    
    public function init()
    {
        parent::init();
        
        if ($this->childOf === null || $this->title === null || $this->alias === null) {
            throw new Exception("The properties childOf, title and alias must be defined to inject a new Item.");
        }
    }
    
    public function getMenu()
    {
        if ($this->_menu === null) {
            $this->_menu = Yii::$app->menu;
        }
        
        return $this->_menu;
    }
    
    public function getMenuItem()
    {
        if ($this->_menuItem === null) {
            if ($this->getChildOf() == 0) {
                throw new Exception("To inject an item which is on the root container you have to override all methods");
            }
            
            $this->_menuItem = $this->menu->find()->where(['id' => $this->getChildOf()])->with('hidden')->one();
        }
        
        return $this->_menuItem;
    }
    
    public function getChildOf()
    {
        return $this->childOf;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getAlias()
    {
        return $this->menuItem->alias . '/' . $this->alias;
    }
    
    public function getContainer()
    {
        return $this->menuItem->container;
    }
    
    public function getDept()
    {
        return count(explode('/', $this->getAlias()));
    }
    
    public function getLang()
    {
        return $this->menuItem->lang;
    }
    
    public function getLink()
    {
        return ($this->link === null) ? $this->menu->buildItemLink($this->getAlias(), $this->getLang()) : $this->link;
    }
    
    public function getParentNavId()
    {
        return $this->menuItem->navId;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function getCreateUserId()
    {
        return $this->createUserId;
    }
    
    public function getUpdateUserId()
    {
        return $this->updateUserId;
    }
    
    public function getTimestampCreate()
    {
        return time();
    }
    
    public function getTimestampUpdate()
    {
        return time();
    }
    
    public function getIsHome()
    {
        return (int) false;
    }
    
    public function getSortIndex()
    {
        return $this->sortIndex;
    }
    
    public function getIsHidden()
    {
        return (int) $this->isHidden;
    }
    
    public function getType()
    {
        return 1;
    }
    
    public function getRedirect()
    {
        return 0;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }
    
    public function getId()
    {
        if ($this->_id === null) {
            $this->_id = $this->menuItem->id . '_' . md5(spl_object_hash($this) . $this->getAlias());
        }
        
        return $this->_id;
    }
    
    public function setNavId($navId)
    {
        $this->_navId = $navId;
    }
    
    public function getNavId()
    {
        if ($this->_navId === null) {
            $this->_navId = $this->menuItem->navId . '_' . $this->getChildOf();
        }
        return $this->_navId;
    }
    
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nav_id' => $this->getNavId(),
            'lang' => $this->getLang(),
            'link' => $this->getLink(),
            'title' => $this->getTitle(),
            'alias' => $this->getAlias(),
            'description' => $this->getDescription(),
            'create_user_id' => $this->getCreateUserId(),
            'update_user_id' => $this->getUpdateUserId(),
            'timestamp_create' => $this->getTimestampCreate(),
            'timestamp_update' => $this->getTimestampUpdate(),
            'is_home' => $this->getIsHome(),
            'parent_nav_id' => $this->getParentNavId(),
            'sort_index' => $this->getSortIndex(),
            'is_hidden' => $this->getIsHidden(),
            'type' => $this->getType(),
            'redirect' => $this->getRedirect(),
            'container' => $this->getContainer(),
            'depth' => $this->getDept(),
        ];
    }
}
