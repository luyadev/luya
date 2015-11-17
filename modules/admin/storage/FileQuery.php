<?php

namespace admin\storage;

use Yii;
use Exception;

/**
 * @property object $storage The storage container object
 * 
 * @author nadar
 */
class FileQuery extends \yii\base\Object
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
    
    public function createObject(array $itemArray)
    {
        return FileQueryObject::create($itemArray);
    }
    
    public function createIteratorObject(array $data)
    {
        return Yii::createObject(['class' => FileQueryIterator::className(), 'data' => $data]);
    }
}
