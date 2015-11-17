<?php

namespace admin\storage;

use Yii;

/**
 * @property object $storage The storage component
 * 
 * @author nadar
 */
class ImageQuery extends \yii\base\Object
{
    use \admin\storage\QueryTrait;
    
    public function getDataProvider()
    {
        return $this->storage->imagesArray;
    }
    
    public function getItemDataProvider($id)
    {
        return $this->storage->getImagesArrayItem($id);
    }
    
    public function createObject(array $itemArray)
    {
        return ImageQueryObject::create($itemArray);
    }
    
    public function createIteratorObject(array $data)
    {
        return Yii::createObject(['class' => ImageQueryIterator::className(), 'data' => $data]);
    }
}
