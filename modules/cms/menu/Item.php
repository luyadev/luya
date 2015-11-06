<?php

namespace cms\menu;

use Yii;
use cms\menu\Query;

class Item extends \yii\base\Object
{
    public $itemArray = [];
    
    public function getId()
    {
        return $this->itemArray['id'];
    }
    
    public function getNavId()
    {
        return $this->itemArray['nav_id'];
    }
    
    public function getParentNavId()
    {
        return $this->itemArray['parent_nav_id'];
    }
    
    public function getTitle()
    {
        return $this->itemArray['title'];
    }
    
    public function getAlias()
    {
        return $this->itemArray['alias'];
    }
    
    public function getLink()
    {
        return ($this->itemArray['is_home']) ? '' : $this->itemArray['link'];
    }
    
    public function getIsActive()
    {
        return (Yii::$app->menu->current->link == $this->link);
    }
    
    public function hasChildren()
    {
        return ((new Query())->where(['parent_nav_id' => $this->navId])->one()) ? true : false;
    }
    
    public function getChildren()
    {
        return (new Query())->where(['parent_nav_id' => $this->navId])->all();   
    }
    
    public function getDepth()
    {
        return $this->itemArray['depth'];
    }
    
    public function getParent()
    {
        return (new Query())->where(['nav_id' => $this->parentNavId])->one();
    }
    
    public function getParentIncludeHidden()
    {
        return (new Query())->where(['nav_id' => $this->parentNavId])->includeHidden()->one();
    }
    
    /**
     * Return all parent elements (breadcrumb behavior) without the current item.
     * @return array 
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
}