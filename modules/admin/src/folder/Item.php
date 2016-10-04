<?php

namespace luya\admin\folder;

use Yii;

class Item extends \yii\base\Object
{
    use \luya\admin\storage\ItemTrait;
    
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

    public function hasChild()
    {
        return ((new \luya\admin\folder\Query())->where(['is_deleted' => 0, 'parent_id' => $this->getId()])->count() > 0 ? true: false);
    }
    
    public function getParent()
    {
        return (!empty($this->getParentId())) ? Yii::$app->storage->getFolder($this->getParentId()) : false;
    }
    
    public function getFilesCount()
    {
        return (new \luya\admin\file\Query())->where(['is_hidden' => 0, 'is_deleted' => 0, 'folder_id' => $this->getId()])->count();
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
