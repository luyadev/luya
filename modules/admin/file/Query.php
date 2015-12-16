<?php

namespace admin\file;

use Yii;

/**
 * @property object $storage The storage component
 * 
 * @author nadar
 */
class Query extends \yii\base\Object
{
    use \admin\storage\QueryTrait;
    
    public function getDataProvider()
    {
        return $this->storage->filesArray;
    }
    
    public function getItemDataProvider($id)
    {
        return $this->storage->getFilesArrayItem($id);
    }
    
    public function createItem(array $itemArray)
    {
        return Item::create($itemArray);
    }
    
    public function createIteratorObject(array $data)
    {
        return Yii::createObject(['class' => Iterator::className(), 'data' => $data]);
    }
}
