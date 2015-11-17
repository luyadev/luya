<?php

namespace admin\storage;

use Yii;

trait QueryTrait
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
        return $this->createIteratorObject(array_filter($this->getDataProvider(), [$this, 'whereFilter']));
    }
    
    public function one()
    {
        $data = array_filter($this->getDataProvider(), [$this, 'whereFilter']);
        
        return (count($data) !== 0) ? $this->createObject(array_values($data)[0]): false;
    }
    
    public function findOne($id)
    {
        return ($itemArray = $this->getItemDataProvider($id)) ? $this->createObject($itemArray) : false;
    }
    
    abstract public function getDataProvider();
    
    abstract public function getItemDataProvider($id);
    
    abstract public function createObject(array $itemArray);
    
    abstract public function createIteratorObject(array $data);
}
