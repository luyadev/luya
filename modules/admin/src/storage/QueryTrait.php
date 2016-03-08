<?php

namespace admin\storage;

use Yii;

trait QueryTrait
{
    private $_storage = null;
    
    private $_where = [];
    
    /**
     * Singleton behavior for storage component getter.
     * 
     * @return admin\components\StorageContainer
     */
    public function getStorage()
    {
        if ($this->_storage === null) {
            $this->_storage = Yii::$app->storage;
        }
        
        return $this->_storage;
    }
    
    /**
     * Define the Query specific where values, all where conditions as provided with an assoc array, where the key is the 
     * field and the value accords to the field value. Each Query object have different condition keys, see the specific query
     * class to find all conditions.
     * 
     * ```php
     * ->where(['id' => 1]); // WHERE id=1
     * ```
     * 
     * ```php
     * ->where(['id' => 1, 'folder_id' => 2]); // WHERE id=1 AND folder_id=2
     * ```
     * 
     * All where conditions are defined as "equal" operators, so its *not possible* to set an not equal condition.
     * 
     * @param array $args Where "equal" conditions, multiple conditions are thread as "AND" statement.
     * @return \admin\storage\QueryTrait|Object Current object, to make object chaining possible.
     */
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
    
    /**
     * Find All
     * 
     * @return admin\storage\IteratorAbstract|Object
     */
    public function all()
    {
        return $this->createIteratorObject(array_filter($this->getDataProvider(), [$this, 'whereFilter']));
    }
    
    /**
     * 
     * @return integer Amount of filtere data.
     */
    public function count()
    {
        return count(array_filter($this->getDataProvider(), [$this, 'whereFilter']));
    }
    
    /**
     * Find One, if there are several items, it just takes the first one and does not throw an exception.
     * 
     * @return admin\storage\QueryTrait|Object
     */
    public function one()
    {
        $data = array_filter($this->getDataProvider(), [$this, 'whereFilter']);
        
        return (count($data) !== 0) ? $this->createItem(array_values($data)[0]): false;
    }
    
    /**
     * FindOne returns the specific item id
     * 
     * @param int $id The specific item id
     * @return admin\storage\QueryTrait|Object
     */
    public function findOne($id)
    {
        return ($itemArray = $this->getItemDataProvider($id)) ? $this->createItem($itemArray) : false;
    }
    
    abstract public function getDataProvider();
    
    abstract public function getItemDataProvider($id);
    
    abstract public function createItem(array $itemArray);
    
    abstract public function createIteratorObject(array $data);
}
