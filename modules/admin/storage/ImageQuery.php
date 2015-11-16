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
    private $_storage = null;
    
    private $_where = [];
    
    public function getStorage()
    {
        if ($this->_storage === null) {
            $this->_storage = Yii::$app->storagecontainer;
        }
        
        return $this->_storage;
    }
    
    public function where(array $args)
    {
        $this->_where = $args;
        
        return $this;
    }
    
    protected function whereFilter($item)
    {
        foreach ($this->_where as $whereKey => $whereValue) {
            if ($item[$whereKey] != $whereValue) {
                return false;
            }
        }
        
        return true;
    }
    
    public function all()
    {
        return Yii::createObject(['class' => ImageQueryIterator::className(), 'data' => array_filter($this->storage->imagesArray, [$this, 'whereFilter'])]);
    }
    
    public function findOne($id)
    {
        
    }
    
    public static function createImageQueryObject(array $itemArray)
    {
        return Yii::createObject(['class' => ImageQueryObject::className(), 'itemArray' => $itemArray]);
    }
}