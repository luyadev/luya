<?php

namespace admin\storage;

use Yii;

/**
 * @property object $storage The storage component
 * 
 * @author nadar
 */
class FolderQuery extends \yii\base\Object
{
    use \admin\storage\QueryTrait;
    
    public function getDataProvider()
    {
        return $this->storage->foldersArray;
    }
    
    public function getItemDataProvider($id)
    {
        return $this->storage->getFoldersArrayItem($id);
    }
    
    public function createObject(array $itemArray)
    {
        return FolderQueryObject::create($itemArray);
    }
    
    public function createIteratorObject(array $data)
    {
        return Yii::createObject(['class' => FolderQueryIterator::className(), 'data' => $data]);
    }
}
