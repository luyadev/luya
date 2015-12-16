<?php

namespace admin\folder;

use Yii;

class Item extends \yii\base\Object
{
    use \admin\storage\ItemTrait;
    
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
        return (!empty($this->getParentId())) ? Yii::$app->storage->getFolder($this->getParentId()) : false;
    }
    
    public function getFilesCount()
    {
        return (new \admin\file\Query())->where(['is_hidden' => 0, 'is_deleted' => 0, 'folder_id' => $this->getId()])->count();
    }
    
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'parentId' => $this->getParentId(),
            'filesCount' => $this->getFilesCount(),
        ];
    }
}
