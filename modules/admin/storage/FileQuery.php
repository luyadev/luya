<?php

namespace admin\storage;

use Yii;

/**
 * @property object $storage The storage container object
 * 
 * @author nadar
 */
class FileQuery extends \yii\base\Object
{
    private $_storage = null;
    
    private $_where = [];
    
    public function getStorage()
    {
        if ($this->_storage === null) {
            $this->_storage = Yii::$app->get('storagecontainer');
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
        return Yii::createObject(['class' => FileQueryIterator::className(), 'data' => array_filter($this->storage->filesArray, [$this, 'whereFilter'])]);
    }
    
    public function findOne($id)
    {
        return static::createFileQueryObject($this->storage->getFilesArrayItem($id));
    }
    
    public static function createFileQueryObject(array $itemArray)
    {
        return Yii::createObject(['class' => FileQueryObject::className(), 'itemArray' => $itemArray]);
    }
}