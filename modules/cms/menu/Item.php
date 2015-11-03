<?php

namespace cms\menu;

class Item extends \yii\base\Object
{
    public $itemArray = [];
    
    public function getTitle()
    {
        return $this->itemArray['title'];
    }
    
    public function getLink()
    {
        return $this->itemArray['link'];
    }
    
    public function getChildren()
    {
        
    }
    
    public function getParent()
    {
        
    }
    
    public function teardown()
    {
        
    }
}