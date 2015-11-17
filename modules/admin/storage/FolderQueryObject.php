<?php

namespace admin\storage;

use Yii;
use admin\storage\FolderQuery;

class FolderQueryObject extends \yii\base\Object
{
    use \admin\storage\ObjectTrait;
    
    public function getId()
    {
        return $this->itemArray['id'];
    }
    
    public function getName()
    {
        return $this->itemArray['name'];
    }
    
    public function getParentId()
    {
        return $this->itemArray['parent_id'];
    }
    
    public function hasParent()
    {
        return !empty($this->getParentId());
    }
    
    public function getParent()
    {
        return (!empty($this->getParentId())) ? (new FolderQuery())->findOne($this->getParentId()) : false;
    }
}
